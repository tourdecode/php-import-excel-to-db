<?php

$config['mod']['root'] = 'md_prd';
$config['mod']['rate'] = 'md_prp';
$config['mod']['masterkey'] = 'prd';
if (isset($_GET['namefile'])) {
    $namefile = $_GET['namefile'];
    // print_pre($namefile);
    $targetPath = _DIR . '/file/'.$namefile.'.xlsx';
    $Reader = new SpreadsheetReader($targetPath);
    // print_pre($Reader);
    $sheetCount = count($Reader->sheets());
    // print_pre($sheetCount);
    // $arrayUnit = array();
    for($i=0;$i<$sheetCount;$i++)
     {
         $Reader->ChangeSheet($i);
         foreach ($Reader as $key => $Row)
         {
           $arrPrice = array();
           $column_first = $Row[0];
          if (is_numeric($column_first)) {
            
              // $arrayUnit[$Row[2]] = $Row[2];
             
            // 7253
            // if ($key == 7253) {
              $code = (isset($Row[0])) ? strval($Row[0]) : ''  ;
              $name = (isset($Row[1])) ? $Row[1] : ''  ;
              $unitid = (!empty($Row[2])) ? checkUnit($Row[2]) : '0'  ;
              $price = (!empty($Row[4])) ? $Row[4] : '0.00'  ;
              
              $arrPrice[174] = $Row[5];
              $arrPrice[175] = $Row[6];
              $arrPrice[176] = $Row[7];
              $arrPrice[177] = $Row[8];
              $arrPrice[178] = $Row[9];
              $arrPrice[179] = $Row[10];
              $arrPrice[180] = $Row[11];
              $arrPrice[181] = $Row[12];
              
              print_pre($key.' '.$code);
              
              print_pre('code -> '.$code.' , name -> '.$name.' , unit_id -> '.$unitid.' , price -> '.$price);
              
              print_pre($arrPrice);


            //   if (!empty($code) || !empty($name)) {
            //       $maxOrder = $fuc->maxOrder($config['mod']['root'],$config['mod']['masterkey']);
            // //       // die();
            //       $insert = array();
            //       $insert[$config['mod']['root'] . "_masterkey"] = changeQuot($config['mod']['masterkey']);
            //       $insert[$config['mod']['root'] . "_keylang"] = 'th';
            //       $insert[$config['mod']['root'] . "_code"] = changeQuot($code);
            //       $insert[$config['mod']['root'] . "_barcode"] = changeQuot($code);
            //       $insert[$config['mod']['root'] . "_uid"] = changeQuot($unitid);
            //       $insert[$config['mod']['root'] . "_subject"] = changeQuot($name);
            //       $insert[$config['mod']['root'] . "_initials"] = changeQuot($name);
            //       $insert[$config['mod']['root'] . "_pricefix"] = changeQuot($price);
            //       $insert[$config['mod']['root'] . "_status"] = 'Enable';
            //       $insert[$config['mod']['root'] . "_order"] = $maxOrder;
            //       $insert[$config['mod']['root'] . "_credate"] = date("Y-m-d H:i:s");
            //       // print_pre($insert);
            //       $insertSQL = sqlinsert($insert, $config['mod']['root'], $config['mod']['root'] . "_id");
            //       $contantID = $insertSQL['id'];
            //       if ($insertSQL['status']) {
            //           if (is_array($arrPrice)) {
            //             $insert_list = array();
            //             $insert_list[$config['mod']['rate'] . "_pid"] = $contantID;
            //             $insert_list[$config['mod']['rate'] . "_rate"] = serialize($arrPrice);
            //             $insertSQL_list = sqlinsert($insert_list, $config['mod']['rate'], $config['mod']['rate'] . "_id");  
            //           }
            //           print_pre('Excel Data Imported into the Database');
                      
            //       }else{
            //           print_pre('Problem in Importing Excel Data');
            //       }
                  
            //   }
            // }
             
              


            }
          }
          // print_pre(checkUnit());
          // print_pre($arrayUnit);
          // foreach ($arrayUnit as $key => $value) {
          // print_pre(checkUnit($value));
          // }
      }
      // print_pre('Success!!');
}


function checkUnit($var = null){
  global $config, $db,$fuc;
  $unit_db = "md_unit";
  $unit_masterkey = "prd_unit";
  $sql = "SELECT " . $unit_db . "." . $unit_db . "_id as id
  FROM " . $unit_db ."
  WHERE " . $unit_db ."." . $unit_db ."_subject = '".$var."'
  AND " . $unit_db ."." . $unit_db ."_masterkey = '".$unit_masterkey."'
  ";
  
  $result = $db->Execute($sql);
  if ($result->_numOfRows > 0) {
    return $result->fields['id'];
  }else{

    $incre = array();
    $incre['dateCreate'] = date("d/m/Y");
    $onOrderNumber = 'UN001'.DateThaiOrder();
    
    $sqlCheckOrder = "SELECT
     Max(" . $unit_db . "." . $unit_db . "_reforderid) AS lastorder
    FROM
    " . $unit_db . "
    WHERE
    " . $unit_db . "." . $unit_db . "_code LIKE '" . $onOrderNumber . "%' AND
    " . $unit_db . "." . $unit_db . "_masterkey = '" . $unit_masterkey . "'";
    $checkCodeOrder = $db->execute($sqlCheckOrder);
    
    $refOrderid = $checkCodeOrder->fields['lastorder'] + 1;
    $refOrderid = sprintf("%04s",$refOrderid); 
    $incre['orderid'] = $onOrderNumber . $refOrderid;
    $incre['refOrderid'] = $refOrderid;
    $maxOrder = $fuc->maxOrder($unit_db,$unit_masterkey);
    $insert = array();
    $insert[$unit_db . "_masterkey"] = changeQuot($unit_masterkey);
    $insert[$unit_db . "_keylang"] = 'th';
    $insert[$unit_db . "_code"] = changeQuot($incre['orderid']);
    $insert[$unit_db . "_subject"] = changeQuot($var);
    $insert[$unit_db . "_status"] = 'Enable';
    $insert[$unit_db . "_reforderid"] = changeQuot($incre['refOrderid']);
    $insert[$unit_db . "_order"] = $maxOrder;
    $insert[$unit_db . "_credate"] = date("Y-m-d H:i:s");
    // print_pre($insert);
    $insertSQL = sqlinsert($insert, $unit_db, $unit_db . "_id");
    $contantID = $insertSQL['id'];
    return $contantID;
  }
  
}