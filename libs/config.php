<?php
session_cache_expire(1280);
$cache_expire = session_cache_expire();
@session_start();
date_default_timezone_set('Asia/Bangkok');
ini_set('memory_limit', '128M');

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

if (!empty($_REQUEST['mode'])) {
    $modefunction = $_REQUEST['mode'];
} else {
    $modefunction = null;
}

switch ($modefunction) {
    case 'debug':
        echo "<i>## DEBUG MODE ##</i>";

        if (empty($errors) === false){
            echo '<ul>';
                foreach($errors as $error){
                echo '<li>', $error, '</li>';
                }
            echo '</ul>';
        }

        echo "<br>---<br>";


        break;

    case 'delsession':
        echo "<i>## TOKEN DEL MODE ##</i>";
        $_SESSION["token"] = "";
        unset($_SESSION["token"]);
        exit();
        break;

    case 'delcookie':
        echo "<i>## TOKEN DEL MODE ##</i>";
        $_COOKIE["token"] = "";
        unset($_COOKIE["token"]);
        setcookie("token", null, time() - 3600, "/");
        setcookie("token", null, time() - 3600);
        exit();
        break;

    default:
        error_reporting(0);
        break;
}

## config Sql ##
$coreLanguageSQL = "mysqli";
$core_db_hostname = "127.0.0.1";
$core_db_username = "root";
$core_db_password = "1234";
// $core_db_name = "2018_lgk_new";
$core_db_name = "2020_ljk_import";
$core_db_charecter_set = array('charset' => "utf8", 'collation' => "utf8_general_ci");

## limit ##
$limitpage['showperPage'] = 8;
$limitpage['showperPageSeller'] = 11;

## config token ##
$token_timeout = 240; // หน่วยเป็นนาที
$token_cookie_timeout = "8"; // หน่วยเป็นชม
$token_action = "10"; // การเข้าที่หน้าสงสัยจำนวนครั้ง จะบล๊อคไม่ให้เข้าสู่ระบบตามจำนวน $token_cookie_timeout
## lang ## ex. "xx" => array("dbinclude","fullname","shortname")
$lang_set = array(
    "th" => array("", "Thai", "th", "", "Thai"),
    "en" => array("", "English", "en", "en", "Eng"),
);
$lang_default = "th";

## url ##
$url_show_lang = false;
$url_show_default = "login";

## config path system ##
$path_template = array(
    "default" => array('front/template/default', 'style.css'),
);

## addon js ##
$listjs = array();

## addon css ##
$listcss = array();

## template Set ##
$templateweb = "default";

## config path temp ##
$path_compile = _DIR . '/temp/template';
$path_cache = _DIR . '/temp/cache';

## config path upload ##
$path_upload = _DIR . '/upload';
// $path_upload = '/upload';
$path_upload_url = _URL . '/upload';

$core_pathname_upload = "/upload";
$core_pathname_mupload = "/core/upload/";
$core_pathname_logs = "/logs";

## Size Photo ###################################

$sizeWidthhightlight = "474";
$sizeHeighthightlight = "280";

$sizeWidthPic = "300";
$sizeHeightPic = "300";

$sizeWidthOff = "50";
$sizeHeightOff = "50";

$sizeWidthAlbum = "600";
$sizeHeightAlbum = "600";

$sizeWidthAlbumOff = "50";
$sizeHeightAlbumOff = "50";

## file ##
$validextensions = array("jpeg", "jpg", "png");
$validsizefile = 1024; // kb
## date month ##
$strMonthCut['shot']['th'] = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$strMonthCut['shot']['en'] = array("", 'Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'Jun.', 'Jul.', 'Aug.', 'Sep.', 'Oct.', 'Nov.', 'Dec.');

$strMonthCut['full']['th'] = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
$strMonthCut['full']['en'] = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December');

$weekDay['th'] = array('อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส');
$weekDay['en'] = array('Su', 'M', 'T', 'W', 'Th', 'F', 'Sa');

$colorpatten = array("#e6e6e6", "#f46b23", "#ffb400", "#e7352b", "#8d42a1", "#3853d8", "#20a5ea", "#5cb328", "#7c5e4c", "#484848", "#01d2f9", "#7f8c8d");

#member
$config['member']['masterkey'] = "mem";
$config['member']['db'] = "md_mem";
$config['member']['db_group'] = "md_meg";
$config['member']['db_user_group'] = "md_mel";
$config['member']['db_user_address'] = "md_mea";

#country
$config['main']['db_country_amphur'] = "md_ads_amphures";
$config['main']['db_country_amphur_postcode'] = "md_ads_amphur_postcode";
$config['main']['db_country_district'] = "md_ads_districts";
$config['main']['db_country_province'] = "md_ads_provinces";

/* =Time&Date Config
-------------------------------------------------------------- */
$SuffixTime = array(
    "th" => array(
        "time" => array(
            "Seconds" => " วินาทีที่แล้ว",
            "Minutes" => " นาทีที่แล้ว",
            "Hours" => " ชั่วโมงที่แล้ว",
        ),
        "day" => array(
            "Yesterday" => "เมื่อวาน เวลา ",
            "Monday" => "วันจันทร์ เวลา ",
            "Tuesday" => "วันอังคาร เวลา ",
            "Wednesday" => "วันพุธ เวลา ",
            "Thursday" => "วันพฤหัสบดี เวลา ",
            "Friday" => "วันศุกร์ เวลา ",
            "Saturday" => " วันวันเสาร์ เวลา ",
            "Sunday" => "วันอาทิตย์ เวลา ",
        ),
    ),
    "en" => array(
        "time" => array(
            "Seconds" => " seconds ago",
            "Minutes" => " minutes ago",
            "Hours" => " hours ago",
        ),
        "day" => array(
            "Yesterday" => "Yesterday at ",
            "Monday" => "Monday at ",
            "Tuesday" => "Tuesday at ",
            "Wednesday" => "Wednesday at ",
            "Thursday" => "Thursday at ",
            "Friday" => "Friday at ",
            "Saturday" => "Saturday at ",
            "Sunday" => "Sunday at ",
        ),
    ),
);

$DateThai = array(
    // Day
    "l" => array( // Full day
        "Monday" => "วันจันทร์",
        "Tuesday" => "วันอังคาร",
        "Wednesday" => "วันพุธ",
        "Thursday" => "วันพฤหัสบดี",
        "Friday" => "วันศุกร์",
        "Saturday" => "วันวันเสาร์",
        "Sunday" => "วันอาทิตย์",
    ),
    "D" => array( // Abbreviated day
        "Monday" => "จันทร์",
        "Tuesday" => "อังคาร",
        "Wednesday" => "พุธ",
        "Thursday" => "พฤหัส",
        "Friday" => "ศุกร์",
        "Saturday" => "วันเสาร์",
        "Sunday" => "อาทิตย์",
    ),
    // Month
    "F" => array( // Full month
        "January" => "มกราคม",
        "February" => "กุมภาพันธ์",
        "March" => "มีนาคม",
        "April" => "เมษายน",
        "May" => "พฤษภาคม",
        "June" => "มิถุนายน",
        "July" => "กรกฎาคม",
        "August" => "สิงหาคม",
        "September" => "กันยายน",
        "October" => "ตุลาคม",
        "November" => "พฤศจิกายน",
        "December" => "ธันวาคม",
    ),
    "M" => array( // Abbreviated month
        "January" => "ม.ค.",
        "February" => "ก.พ.",
        "March" => "มี.ค.",
        "April" => "เม.ย.",
        "May" => "พ.ค.",
        "June" => "มิ.ย.",
        "July" => "ก.ค.",
        "August" => "ส.ค.",
        "September" => "ก.ย.",
        "October" => "ต.ค.",
        "November" => "พ.ย.",
        "December" => "ธ.ค.",
    ),
);
/* =Time&Date Config
-------------------------------------------------------------- */

#########Setting Email##########
$url_website = _URL . '/' . $path_template[$templateweb][0];
$url_website2 = _URL;
$core_default_typemail = 1;
$core_send_email = "info@dmscpt.in.th";
