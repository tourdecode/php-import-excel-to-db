<?php

$config['mod']['root'] = 'md_supplier';
$config['mod']['masterkey'] = 'prd_suppliers';
if (isset($_GET['namefile'])) {
    $namefile = $_GET['namefile'];
    print_pre($namefile);
    $targetPath = _DIR . '/file/'.$namefile.'.xlsx';
    $Reader = new SpreadsheetReader($targetPath);
    // print_pre($Reader);
    $sheetCount = count($Reader->sheets());
    // print_pre($sheetCount);
    // $arrayPrefix = array();
    for($i=0;$i<$sheetCount;$i++)
     {
         $Reader->ChangeSheet($i);
         
         foreach ($Reader as $key => $Row)
         {
          //  print_pre($key); 
            // $arrayPrefix[$prefix] = $prefix;
             $code = (isset($Row[0])) ? $Row[0] : ''  ;
             $prefix = (!empty($Row[1])) ? checkGroup($Row[1]) : '0'  ;
             $name = (isset($Row[2])) ? $Row[2] : ''  ;
             $tel = (isset($Row[3])) ? $Row[3] : ''  ;
             $address = (isset($Row[4])) ? $Row[4] : ''  ;
            // $db->qstr($Row[4])

             
             if (!empty($code) || !empty($name)) {
                print_pre('code -> '.$code.' , prefix -> '.$prefix.' , name -> '.$name.' , address-> '.$address.' , tel -> '.$tel);
                $maxOrder = $fuc->maxOrder($config['mod']['root'],$config['mod']['masterkey']);
                // die();
                $insert = array();
                $insert[$config['mod']['root'] . "_masterkey"] = changeQuot($config['mod']['masterkey']);
                $insert[$config['mod']['root'] . "_keylang"] = 'th';
                $insert[$config['mod']['root'] . "_code"] = changeQuot($code);
                $insert[$config['mod']['root'] . "_subject"] = changeQuot($name);
                $insert[$config['mod']['root'] . "_status"] = 'Enable';
                $insert[$config['mod']['root'] . "_gid"] = changeQuot($prefix);
                $insert[$config['mod']['root'] . "_address1"] = changeQuot($address);
                $insert[$config['mod']['root'] . "_tel"] = changeQuot($tel);
                // $insert[$config['mod']['root'] . "_fax"] = changeQuot($fax);
                $insert[$config['mod']['root'] . "_credit"] = 1;
                $insert[$config['mod']['root'] . "_order"] = $maxOrder;
                $insert[$config['mod']['root'] . "_credate"] = date("Y-m-d H:i:s");
                // print_pre($insert);
                // $insertSQL = sqlinsert($insert, $config['mod']['root'], $config['mod']['root'] . "_id");
                // // $contantID = $insertSQL['id'];
                // if ($insertSQL['status']) {
                //     print_pre('Excel Data Imported into the Database');
                //     // if ($key == 5) {
                //     //     die();
                //     // }
                // }else{
                //     print_pre('Problem in Importing Excel Data');
                //     // if ($key == 5) {
                //     //     die();
                //     // }
                // }
             }
          }
          
      }
      print_pre('Success!!');
}


function checkGroup($var = null){
  $arrGroup = array(
    '169' => 'บจก.', 
    '170' => 'หจก.',
    '171' => 'บมจ.',
    '172' => 'ร้าน',
    '173' => 'คุณ'
  );
  
  return array_search($var,$arrGroup);
}