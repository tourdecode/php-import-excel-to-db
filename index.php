<?php

define("_DIR", str_replace("\\", '/', dirname(__FILE__)));

require_once _DIR . '/libs/config.php'; #load config
require_once _DIR . '/libs/setting.php'; #load setting
require_once _DIR . '/libs/function.php'; #load function
require_once _DIR . '/libs/php-excel-reader/excel_reader2.php'; #load function
require_once _DIR . '/libs/php-excel-reader/SpreadsheetReader.php'; #load function

$fuc = new func();
if (!empty($_GET['namefile'])) {
       if (file_exists($_GET['namefile'].'.php')) {
              include $_GET['namefile'].'.php';
       }else{
              print_pre('Please check namefile');
       }
}else{
       print_pre('Please namefile');
}
die();
       // die();

       // //ทำการเปิดไฟล์ CSV เพื่อนำข้อมูลไปใส่ใน MySQL  

       // $objCSV = fopen("mr_member6.csv", "r");  
       // $objArr = fgetcsv($objCSV, 1000, ",");

       // while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {  

       //        //นำข้อมูลใส่ในตาราง member  

       //        $strSQL = "INSERT INTO md_memm2 ";  


       //        //ข้อมูลใส่ใน field ข้อมูลดังนี้  

       // $strSQL .="(md_memm2_id,md_memm2_code,md_memm2_type,
       //               md_memm2_gid,md_memm2_masterkey,
       //               md_memm2_language,md_memm2_idcard,
       //               md_memm2_idcard_sdate,md_memm2_idcard_edate,
       //               md_memm2_fname,md_memm2_lname,
       //               md_memm2_credate,md_memm2_lastdate,
       //               md_memm2_logindate,md_memm2_status,
       //               md_memm2_tel,md_memm2_sex,
       //               md_memm2_date,md_memm2_month,
       //               md_memm2_year,md_memm2_prefix,
       //               md_memm2_house,md_memm2_province,
       //               md_memm2_district,md_memm2_subdistrict,  
       //               md_memm2_village ,md_memm2_road ,md_memm2_religion ,
       //               md_memm2_job,md_memm2_education,
       //               md_memm2_card_a,md_memm2_card_b
       //               ) ";  

       // $strSQL .="VALUES ";  

              

       //        //ข้อมูลตามที่อ่านได้จากไฟล์ลงฐานข้อมูล  

       // $strSQL .="('".$objArr[0]."','".$objArr[1]."','".$objArr[2]."' ";  

       // $strSQL .=",'".$objArr[3]."','".$objArr[4]."' ";  
       // $strSQL .=",'".$objArr[5]."','".$objArr[6]."' ";  
       // $strSQL .=",'".$objArr[7]."','".$objArr[8]."' ";  
       // $strSQL .=",'".$objArr[9]."','".$objArr[10]."' ";  
       // $strSQL .=",'".$objArr[11]."','".$objArr[12]."' ";  
       // $strSQL .=",'".$objArr[13]."','".$objArr[14]."' ";  
       // $strSQL .=",'".$objArr[15]."','".$objArr[16]."' ";  
       // $strSQL .=",'".$objArr[17]."','".$objArr[18]."' ";  
       // $strSQL .=",'".$objArr[19]."','".$objArr[20]."' ";  
       // $strSQL .=",'".$objArr[21]."','".$objArr[22]."' ";
       // $strSQL .=",'".$objArr[23]."','".$objArr[24]."' ";    
       // $strSQL .=",'".$objArr[25]."','".$objArr[26]."','".$objArr[27]."' ";  
       // $strSQL .=",'".$objArr[28]."','".$objArr[29]."' ";  
       // $strSQL .=",'".$objArr[30]."','".$objArr[31]."' ";  
       // $strSQL .=") ";  

       // //ให้ข้อมูลอยู่ในรูปแบบที่อ่านได้ใน phpmyadmin (By.SlayerBUU Credits พี่ไผ่)  

       // mysql_query("SET NAMES UTF8");  

       

       // //เพิ่มข้อมูลลงฐานข้อมูล  

       // $objQuery = mysql_query($strSQL);  
       // var_dump($strSQL);
       // echo '<br/>';
       // }  

       // fclose($objCSV);  

       

       // echo "Import Done.";  


// }