<?php

$config['mod']['root'] = 'sys_employee';
$config['mod']['masterkey'] = 'customer';
$config['mod']['gid'] = 2;
if (isset($_GET['namefile'])) {
    $namefile = $_GET['namefile'];
    print_pre($namefile);
    $targetPath = _DIR . '/file/'.$namefile.'.xlsx';
    $Reader = new SpreadsheetReader($targetPath);
    // print_pre($Reader);
    $sheetCount = count($Reader->sheets());
    // print_pre($sheetCount);

    for($i=0;$i<$sheetCount;$i++)
     {
         $Reader->ChangeSheet($i);
         
         foreach ($Reader as $key => $Row)
         {
           print_pre($key); 
             $code = (isset($Row[0])) ? $Row[0] : ''  ;
             $name = (isset($Row[1])) ? $Row[1] : ''  ;
             $address = (isset($Row[2])) ? $Row[2] : ''  ;
             $tel = (isset($Row[3])) ? $Row[3] : ''  ;
             $fax = (isset($Row[4])) ? $Row[4] : ''  ;
            // $db->qstr($Row[4])
             
             
             if (!empty($code) || !empty($name)) {
                print_pre('code -> '.$code.' , name -> '.$name.' , address-> '.$address.' , tel -> '.$tel.' , fax -> '.$fax);
                $maxOrder = $fuc->maxOrder($config['mod']['root'],$config['mod']['masterkey']);
                // die();
                $insert = array();
                $insert[$config['mod']['root'] . "_masterkey"] = changeQuot($config['mod']['masterkey']);
                $insert[$config['mod']['root'] . "_user"] = changeQuot($code);
                $insert[$config['mod']['root'] . "_name"] = changeQuot($name);
                $insert[$config['mod']['root'] . "_lname"] = changeQuot($name);
                $insert[$config['mod']['root'] . "_status"] = 'Enable';
                $insert[$config['mod']['root'] . "_group"] = changeQuot($config['mod']['gid']);
                $insert[$config['mod']['root'] . "_address2"] = changeQuot($address);
                $insert[$config['mod']['root'] . "_tel"] = changeQuot($tel);
                $insert[$config['mod']['root'] . "_fax"] = changeQuot($fax);
                $insert[$config['mod']['root'] . "_credit"] = 1;
                $insert[$config['mod']['root'] . "_order"] = $maxOrder;
                $insert[$config['mod']['root'] . "_credate"] = date("Y-m-d H:i:s");
                
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