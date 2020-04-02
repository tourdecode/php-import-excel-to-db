<?php

## print pre ##

function print_pre($expression, $return = false, $wrap = false)
{
    $css = 'border:1px dashed #06f;background:#69f;padding:1em;text-align:left;z-index:99999;font-size:12px;position:relative';
    if ($wrap) {
        $str = '<p style="' . $css . '"><tt>' . str_replace(
            array('  ', "\n"),
            array('&nbsp; ', '<br />'),
            htmlspecialchars(print_r($expression, true))
        ) . '</tt></p>';
    } else {
        $str = '<pre style="' . $css . '">' . print_r($expression, true) . '</pre>';
    }
    if ($return) {
        if (is_string($return) && $fh = fopen($return, 'a')) {
            fwrite($fh, $str);
            fclose($fh);
        }
        return $str;
    } else {
        echo $str;
    }

}

## clean array ##

function cleanArray($arr)
{
    $size = sizeof($arr);
    for ($i = 0; $i < $size; $i++) {
        $thum = trim($arr[$i]);
        if ($thum != "") {
            $r[] = $thum;
        }
    }
    return $r;
}

## include Page to template #####

function templateInclude($setting, $settemplate = null)
{
#################################
    if (!empty($settemplate)) {
        return _DIR . "/front/controller/script/" . $setting['page'] . "/template/" . $settemplate;
    } else {
        return _DIR . "/front/controller/script/" . $setting['page'] . "/template/" . $setting['template'];
    }
}

## link lang ##

function configlang($lang)
{
    global $url_show_lang, $path_root;
    if (!empty($url_show_lang)) {
        return $path_root . "/" . $lang;
    } else {
        if (!empty($path_root)) {
            return $path_root;
        } else {
            return "";
        }
    }
}

## loop number ##

function loopnum($min, $max, $sort = "asc")
{
    $list = array();
    while ($min <= $max) {
        $list[$min] = $min;
        $min++;
    }
    switch ($sort) {
        case 'desc':
            krsort($list);
            break;

        case 'asc':
            ksort($list);
            break;
    }

    return $list;
}

## show month ##

function showmonth($month, $lang, $type = "shot")
{
    global $strMonthCut;
    return $strMonthCut[$type][$lang][$month];
}

## sql insert ##

function sqlinsert($array, $dbname, $key)
{
    global $db;

    // print_pre($db);
    $sql_insert = "Select * From " . $dbname . " where " . $key . " = -1";

    // print_pre($sql_insert);
    // print_pre($key);
    $result_insert = $db->Execute($sql_insert);

    $sql_create_insert = $db->GetInsertSQL($result_insert, $array);
    $result_insert_execute = $db->Execute($sql_create_insert);

    $return['id'] = $db->Insert_ID();
    $return['sql'] = $sql_create_insert;
    $return['status'] = $result_insert_execute;
    $return['sqle'] = $sql_insert;
    return $return;
}

## sql update ##

function sqlupdate($array, $dbname, $key, $where)
{
    global $db;
    // print_pre($where);
    $listWhere = "";

    if (is_array($key)) {
        foreach ($key as $para => $value) {
            $listWhere .= " " . $para . " " . $value;
        }
    } else {
        $listWhere = $key;
    }

    // print_pre($listWhere);
    $sql_update = "Select * From " . $dbname . " where " . $listWhere . " = " . $where;

    $result_update = $db->Execute($sql_update);
    if (!empty($result_update->fields)) {
        $return['thishave'] = true;
        $updateSQL = $db->GetUpdateSQL($result_update, $array);
        $result_update_execute = $db->execute($updateSQL);
    } else {
        $return['thishave'] = false;
        $result_update_execute = false;
    }


    $return['where'] = $where;
    $return['sql'] = $sql_update;
    $return['sqlexecute'] = $updateSQL;
    $return['type'] = "update";
    $return['status'] = $result_update_execute;


    return $return;
}

## sql update ##

function sqlupdateContent($array, $dbname, $key, $where)
{
    global $db;
    // print_pre($where);
    $listWhere = "";

    if (is_array($key)) {
        foreach ($key as $para => $value) {
            $listWhere .= " " . $para . " " . $value;
        }
    } else {
        $listWhere = $key . " = " . $where;
    }

    // print_pre($listWhere);
    $sql_update = "Select * From " . $dbname . " where " . $listWhere;
//    if (!empty($listWhere)) {
    //        $sql_update .= " where " . $listWhere;
    //    }
    // print_pre($sql_update);
    $result_update = $db->Execute($sql_update);

    $updateSQL = $db->GetUpdateSQL($result_update, $array);
    $result_update_execute = $db->execute($updateSQL);

    $return['where'] = $where;
    $return['sql'] = $sql_update;
    $return['sqlexecute'] = $updateSQL;
    $return['status'] = $result_update_execute;

    return $return;
}

## sql delete ##

function sqldelete($db, $key)
{
    global $db;
}

## get ip ##

function getip()
{

    $ip = false;
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = false;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])) {
                if (version_compare(phpversion(), "5.0.0", ">=")) {
                    if (ip2long($ips[$i]) != false) {
                        $ip = $ips[$i];
                        break;
                    }
                } else {
                    if (ip2long($ips[$i]) != -1) {
                        $ip = $ips[$i];
                        break;
                    }
                }
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

// ## encodeStr ##

// function encodeStr($variable)
// {

// ############################################
//     $key = "xitgmLwmp";
//     $index = 0;
//     $temp = "";
//     $variable = str_replace("=", "?O", $variable);
//     for ($i = 0; $i < strlen($variable); $i++) {
//         $temp .= $variable{
//             $i} . $key{
//             $index};
//         $index++;
//         if ($index >= strlen($key)) {
//             $index = 0;
//         }

//     }
//     $variable = strrev($temp);
//     $variable = base64_encode($variable);
//     $variable = utf8_encode($variable);
//     $variable = urlencode($variable);
//     $variable = str_rot13($variable);
//     $variable = str_replace("%", "WewEb", $variable);
//     return $variable;
// }

// ## decodeStr ##

// function decodeStr($enVariable)
// {
//     $enVariable = str_replace("WewEb", "%", $enVariable);
//     $enVariable = str_rot13($enVariable);
//     $enVariable = urldecode($enVariable);
//     $enVariable = utf8_decode($enVariable);
//     $enVariable = base64_decode($enVariable);
//     $enVariable = strrev($enVariable);
//     $current = 0;
//     $temp = "";
//     for ($i = 0; $i < strlen($enVariable); $i++) {
//         if ($current % 2 == 0) {
//             $temp .= $enVariable{
//                 $i};
//         }
//         $current++;
//     }
//     $temp = str_replace("?O", "=", $temp);
//     parse_str($temp, $variable);
//     return $temp;
// }

## add sql date start end ##

function checkStartEnd($dbname, $namestart = "_sdate", $nameend = "_edate")
{
    if (!empty($dbname)) {
        //   $sqlReturn = " and (( " . $dbname . "." . $dbname . "_sdate <= Now() and " . $dbname . "." . $dbname . "_edate >= Now() ) ";
        //   $sqlReturn .= " or ( " . $dbname . "." . $dbname . "_sdate Is Null and " . $dbname . "." . $dbname . "_edate Is Null )) ";

        $sqlReturn = " and ((" . $dbname . "" . $namestart . "='0000-00-00 00:00:00' AND " . $dbname . "" . $nameend . "='0000-00-00 00:00:00')  ";
        $sqlReturn .= " OR (" . $dbname . "" . $namestart . "='0000-00-00 00:00:00' AND TO_DAYS(" . $dbname . "" . $nameend . ")>=TO_DAYS(NOW()) )";
        $sqlReturn .= " OR (TO_DAYS(" . $dbname . "" . $namestart . ")<=TO_DAYS(NOW()) AND " . $dbname . "" . $nameend . "='0000-00-00 00:00:00' ) ";
        $sqlReturn .= " OR (TO_DAYS(" . $dbname . "" . $namestart . ")<=TO_DAYS(NOW()) AND  TO_DAYS(" . $dbname . "" . $nameend . ")>=TO_DAYS(NOW())  )";
        $sqlReturn .= " OR ( " . $dbname . "." . $dbname . "_sdate Is Null and " . $dbname . "." . $dbname . "_edate Is Null )) ";

        return $sqlReturn;
    } else {
        return false;
    }
}

##############################################

function DateThai($strDate, $function = null, $lang = "th", $type = "shot")
{

    global $strMonthCut, $url;
    if($strDate != '0000-00-00 00:00:00'){

    $lang = $url->pagelang[2];
    // print_pre($strMonthCut);
    //  global $slug;
    //   $lang = $slug['pageLang'];
    ##############################################
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strYear2 = date("Y", strtotime($strDate));
    $strYear_mini = substr($strYear, 2, 4);
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonth2 = date("m", strtotime($strDate));

    $strMonth = $strMonthCut[$type][$lang][$strMonth];
    if (!empty($strDate)) {
        switch ($function) {
            case '1':
                $day = "$strDay $strMonth $strYear";
                break;
            case '2':
                $day = "$strDay $strMonth $strYear2";
                break;
            case '3':
                $day = "$strDay $strMonth $strYear_mini";
                break;
            case '4':
                $day = "$strDay $strMonth $strYear , $strHour:$strMinute ";
                break;

            case '5':
                $day = "$strDay $strMonth $strYear , $strHour:$strMinute:$strSeconds ";
                break;
            case '6':
                $day = "$strDay";
                break;
            case '7':
                $day = "$strMonth $strYear";
                break;
            case '8':
                $day = "$strHour:$strMinute";
                break;
            case '9':
                $day = "$strMonth";
                break;
            case '10':
                $day = "$strYear";
                break;
            case '11':
                $day = "$strDay $strMonth $strYear $strHour:$strMinute ";
                break;
            // case '12':
            //     $day = "$strYear/$strMonth2/$strDay";
            //     break;
            case '12':
                if ($strHour.':'.$strMinute == '00:00') {
                    $day = "$strYear/$strMonth2/$strDay";
                }else{
                    $day = "$strDay/$strMonth2/$strYear $strHour:$strMinute ";
                }
                
                break;
            case '13':
                $day = "$strDay/$strMonth2/$strYear2";
                break;
            case '14':
                $day = "$strDay/$strMonth2/$strYear";
                break;
            case '15':
                $day = "$strYear/$strMonth2/$strDay $strHour:$strMinute:$strSeconds";
                break;
            // case 'add':
            //     $day = "$strYear2-$strMonth2-$strDay 00:00:00";
            //     break;
            default:
                break;
        }
    } else {
        $day = "-";
    }

        return $day;
    }else{
        return '';
    }
}

## check date expire ##

function checkexpire($date)
{
    //  $startdate = "16-May-2016";
    $expire = strtotime($date);
    $today = strtotime("today midnight");

    if ($today >= $expire) {
        return true;
    } else {
        return false;
    }
}

## checkstatus ##

function checkstatus($status)
{
    global $lang;

    if (!empty($lang['status'][$status])) {
        return $lang['status'][$status];
    } else {
        return $status;
    }
}

############################################

function changeQuot($Data)
{
############################################
    global $coreLanguageSQL;

    $valTrim = trim($Data);
//    $valChangeQuot = wewebEscape($coreLanguageSQL, $valTrim);
    $valChangeQuot = $valTrim;
    //$valChangeQuot=str_replace("'","&rsquo;",str_replace('"','&quot;',$valChangeQuot));
    $valChangeQuot = str_replace("'", "&rsquo;", str_replace('"', '&quot;', $valChangeQuot));

    return $valChangeQuot;
}

## page pagination ##

function pagepagination($uri, $limit = null)
{
    global $limitpage;
    //print_pre($uri->pagelang[2]);
    $pageOn = array();
    if (!empty($limit)) {
        $pageOn['limit'] = $limit;
    } else {
        $pageOn['limit'] = $limitpage['showperPageSeller'];
    }
    $pagemain = str_replace($uri->pagelang[2] . "/", "", explode("?", $uri->url));

    $pageOn['page'] = $pagemain[0];
    $listparameter = array();

    foreach ($uri->uri as $key => $value) {
        if ($key != "page") {
            $listparameter[] = $key . "=" . $value;
        }
    }

    $countPara = count($listparameter);

    if ($countPara >= 1) {
        $pageOn['parambefor'] = "?" . implode("&", $listparameter);
        $pageOn['parameter'] = "&page=";
    } else {
        $pageOn['parambefor'] = "";
        $pageOn['parameter'] = "?page=";
    }

    if (array_key_exists('page', $uri->uri)) {
        $pageOn['on'] = $uri->uri['page'];
    } else {
        $pageOn['on'] = 1;
    }

    // print_pre($pageOn);
    return $pageOn;
}

function alertpopup($idform, $msg, $status = false, $return = false, $html = null, $title = null)
{
    global $url_show_lang, $lang_set, $lang_default;
    unset($_SESSION['alert']);
    $_SESSION['alert']['id'] = $idform;
    $_SESSION['alert']['msg'] = $msg;
    $_SESSION['alert']['status'] = $status;
    $_SESSION['alert']['return'] = $return;
    $_SESSION['alert']['title'] = $title;
    if (!empty($html)) {
        $_SESSION['alert']['html'] = $html;
    }

    if (!empty($url_show_lang)) {
        $langInLink = $lang_set[$lang_default][2] . "/";
    } else {
        $langInLink = "";
    }

    if (!empty($return)) {
        switch ($return) {
            case 'history':
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
                break;

            default:
                header('Location: ' . _URL . $langInLink . $return);
                exit();
                break;
        }
    } else {
        header("Location:" . $_SERVER['REQUEST_URI']);
        exit();
    }
}

function alertmodal($idform, $load = true)
{
    global $url_show_lang, $lang_set, $lang_default;

    unset($_SESSION['modal']);
    $_SESSION['modal']['id'] = $idform;

    if (!empty($url_show_lang)) {
        $langInLink = $lang_set[$lang_default][2] . "/";
    } else {
        $langInLink = "";
    }

    if ($load == true) {
        header("Location:" . $_SERVER['REQUEST_URI']);
        exit();
    }
}

function array_key_first(array $array = null)
{
    if (count($array)) {
        reset($array);
        return key($array);
    }
    return null;
}

## Call Subject ##
function callSubjectLang($dbname, $fields = null, $id = null)
{
    global $config, $db, $pageSet;
    $sql = "Select " . $dbname . "_keylang as keylang, " . $dbname . "" . $fields . " From " . $dbname;
    if (!empty($id)) {
        $sql .= " where " . $dbname . "_id = '" . $id . "' OR " . $dbname . "_idparent = '" . $id . "' ";
    }
    // print_pre($sql);
    $result = $db->Execute($sql);
    $subjectLang = array();
    // print_pre($pageSet);
    foreach ($result as $key => $value) {
        //     print_pre($value);
        $subjectLang[$value['keylang']] = $value[1];
    }
    //
    return $subjectLang;
}

function nameModulus($data)
{

    $data = unserialize($data);
    return implode(" , ", $data);

}

function fileinclude($filename, $fileType = 'html', $mod_tb_about_masterkey, $for = 'check', $crop = false, $cropthumb = false)
{
    global $path_upload, $path_upload_url, $path_template, $templateweb, $core_pathname_upload, $detectDivice;

    //if ($detectDivice->isMobile()) {
    // if ($fileType == "real") {
    //    $fileType = "pictures";
    //}

//        if ($fileType == "album") {
    //            $fileType = "album/reB_";
    //        }
    //}
    //if($fileType == 'pictures'){
    //    $fileType = 'real';
    //}

    if ($for == 'linkthumb') {
        $fileType = "album";
        $filename = "reO_" . $filename;
    }

    //print_pre($detectDivice);
    $checkFile = $path_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename;
    $path_url_vdo = _URL . 'upload/';
    $checkFileCrop = $path_upload . "/" . $mod_tb_about_masterkey . "/crop/" . $filename;

    if (!empty($cropthumb)) {
        $checkFileCropThumb = $path_upload . "/" . $mod_tb_about_masterkey . "/cropthumb/" . $filename;
    }

    //   print_pre(file_exists($checkFile));

    if (file_exists($checkFile) && $filename) {
        $setFoldet = $path_upload_url;
        $setimg = str_replace($path_upload, "", $checkFile);

        if (!empty($crop)) {
            if (file_exists($checkFileCrop)) {
                $setimg = str_replace($path_upload, "", $checkFileCrop);
            }
        }

        if (!empty($cropthumb)) {
            if (file_exists($checkFileCropThumb)) {
                // print_pre("have");
                $setimg = str_replace($path_upload, "", $checkFileCropThumb);
            }
        }
    } else {
        $setFoldet = _URL . $path_template[$templateweb][0];
        // $setimg = "/public/image/upload/s3.png";
        $setimg = "/public/image/icon/none-img.png";
    }

    switch ($for) {
        case 'linkthumb':
        case 'link':
            // $pathFile = _URL . $path_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename;
            $pathFile = $setFoldet . $setimg;
            break;

        case 'download':
            $fileLoad = encodeStr($path_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename);
            //$fileLoad = $core_pathname_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename;
            $pathFile = "?file=" . $fileLoad;

            break;
        case 'downloadfiile':
            $fileLoad = encodeStr($path_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename, true);
            //$fileLoad = $core_pathname_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename;
            $pathFile = "?file=" . $fileLoad;

            break;
        case 'bookRead':
            $fileLoad = encodeStr($path_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename, true);
            //$fileLoad = $core_pathname_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename;
            $pathFile = $fileLoad;

            break;
        case 'vdo':
            $pathFile = $path_url_vdo . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename;
            break;

        default:
            $pathFile = $path_upload . "/" . $mod_tb_about_masterkey . "/" . $fileType . "/" . $filename;
            break;
    }
    return $pathFile;
}

function useKeySame($masterkey, $node)
{
    $listNode = explode("_", $masterkey);
    if ($node == $listNode[0]) {
        return $listNode[0];
    }
}

function allow($menu, $permis)
{

    switch ($menu) {
        case 'mange':
            if ($permis >= 777) {
                return true;
            } else {
                return "disableMenu";
            }
            break;
        case 'status':
            if ($permis >= 777) {
                return true;
            } else {
                return "disableStatus";
            }
            break;

        case 'top':
        case 'sort':
            if ($permis >= 777) {
                return true;
            } else {
                return "disableMenu";
            }
            break;
        case 'add':
            if ($permis >= 777) {
                return true;
            } else {
                return "disableMenu";
            }
            break;

        case 'edit':
            if ($permis >= 777) {
                return true;
            } else {
                return "disableMenu";
            }
            break;

        case 'delete':
            if ($permis >= 777) {
                return true;
            } else {
                return "disableMenu";
            }
            break;
    }
}
###############################################################################################################################################################################

class func
{

    public function encodeStr($variable)
    {
        ############################################
        $key = "xitgmLwmp";
        $index = 0;
        $temp = "";
        $variable = str_replace("=", "?O", $variable);
        for ($i = 0; $i < strlen($variable); $i++) {
            $temp .= $variable{
                $i} . $key{
                $index};
            $index++;
            if ($index >= strlen($key)) {
                $index = 0;
            }

        }
        $variable = strrev($temp);
        $variable = base64_encode($variable);
        $variable = utf8_encode($variable);
        $variable = urlencode($variable);
        $variable = str_rot13($variable);
        $variable = str_replace("%", "WewEb", $variable);
        return $variable;
    }

    ## decodeStr ##
    public function decodeStr($enVariable)
    {
        $enVariable = str_replace("WewEb", "%", $enVariable);
        $enVariable = str_rot13($enVariable);
        $enVariable = urldecode($enVariable);
        $enVariable = utf8_decode($enVariable);
        $enVariable = base64_decode($enVariable);
        $enVariable = strrev($enVariable);
        $current = 0;
        $temp = "";
        for ($i = 0; $i < strlen($enVariable); $i++) {
            if ($current % 2 == 0) {
                $temp .= $enVariable{
                    $i};
            }
            $current++;
        }
        $temp = str_replace("?O", "=", $temp);
        parse_str($temp, $variable);
        return $temp;
    }

    ## direct page
    public function directpage($page)
    {
        global $linklang;
        // print_pre($_SESSION);
        // exit();
        // print_pre($linklang . "/" . $page);
        //sleep(1);
        header("Location: " . $linklang . "/" . $page);
        exit();
    }

    ## check dir ##
    public function dirfolder($dir)
    {
        $d = dir($dir);
        while (false !== ($entry = $d->read())) {
            if ($entry != '.' && $entry != '..' && is_dir($dir . $entry)) {
                $arDir[$entry] = $this->dirfolder($dir . $entry . '/');
            }

        }
        $d->close();
        return $arDir;
    }

    ## Max Order ##
    public function maxOrder($dbname, $masterkey = null, $where = null)
    {
        global $config, $db;
        $sql = "Select MAX(" . $dbname . "_order) as maxOrder From " . $dbname;
        $listwhere = array();

        if (!empty($masterkey)) {
            $listwhere[] = $dbname . "_masterkey = '" . $masterkey . "'";
            // $sql .= " where " . $dbname . "_masterkey = '" . $masterkey . "'";
        }
        if (!empty($where)) {
            $listwhere[] = $where;
            //$sql .= " and " . $where;
        }

        if (!empty(count($listwhere))) {
            $sql .= " where " . implode(" and ", $listwhere);
        }

        // print_pre($sql);
        $result = $db->Execute($sql);
        $maxOrder = $result->fields['maxOrder'] + 1;

        return $maxOrder;
    }

    public function permis($idmenmu = null)
    {
        global $url;
        if ($_SESSION['member']['login_permission'] == "root") {
            return 777;
        } else {
            $checkInpermis = $_SESSION['member']['login_permission'][$idmenmu];
            if (!empty($checkInpermis)) {
                return $checkInpermis;
            } else {
                alertmodal("#modalPermisError", false);
                $this->directpage("modulus");
            }
        }
    }

    public function resize($img, $w, $h, $newfilename)
    {
        ############################################
        //Check if GD extension is loaded
        if (!extension_loaded('gd') && !extension_loaded('gd2')) {
            trigger_error("GD is not loaded", E_USER_WARNING);
            return false;
        }

        //Get Image size info
        $imgInfo = getimagesize($img);
        switch ($imgInfo[2]) {
            case 1:$im = imagecreatefromgif($img);
                break;
            case 2:$im = imagecreatefromjpeg($img);
                break;
            case 3:$im = imagecreatefrompng($img);
                break;
            default:trigger_error('Unsupported filetype!', E_USER_WARNING);
                break;
        }

        //If image dimension is smaller, do not resize
        if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
            $nHeight = $imgInfo[1];
            $nWidth = $imgInfo[0];
        } else {
            //yeah, resize it, but keep it proportional
            if ($w / $imgInfo[0] > $h / $imgInfo[1]) {
                $nWidth = $w;
                $nHeight = $imgInfo[1] * ($w / $imgInfo[0]);
            } else {
                $nWidth = $imgInfo[0] * ($h / $imgInfo[1]);
                $nHeight = $h;
            }
        }
        $nWidth = round($nWidth);
        $nHeight = round($nHeight);

        $newImg = imagecreatetruecolor($nWidth, $nHeight);

        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($imgInfo[2] == 1) or ($imgInfo[2] == 3)) {
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
            imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
        }
        imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);

        //Generate the file, and rename it to $newfilename
        switch ($imgInfo[2]) {
            case 1:imagegif($newImg, $newfilename);
                break;
            case 2:imagejpeg($newImg, $newfilename);
                break;
            case 3:imagepng($newImg, $newfilename);
                break;
            default:trigger_error('Failed resize image!', E_USER_WARNING);
                break;
        }

        return $newfilename;
    }

}




function DateInsert($strDate, $function = null, $lang = "th", $type = "shot")
{
    global $strMonthCut, $url;

    $lang = $url->pagelang[2];
    $strDate = explode("/", $strDate);
    // print_pre($strMonthCut);
    //  global $slug;
    //   $lang = $slug['pageLang'];
    ##############################################
    // $strYear = date("Y", strtotime($strDate)) + 543;
    $strYear2 = $strDate[2];
    // $strYear_mini = substr($strYear, 2, 4);
    // $strMonth = date("n", strtotime($strDate));
    $strDay = $strDate[0];
    // $strHour = date("H", strtotime($strDate));
    // $strMinute = date("i", strtotime($strDate));
    // $strSeconds = date("s", strtotime($strDate));
    $strMonth2 = $strDate[1];

    // $strMonth = $strMonthCut[$type][$lang][$strMonth];
    // if (!empty($strDate)) {
    //     switch ($function) {
    //         case 'add':
    $day = "$strYear2-$strMonth2-$strDay 00:00:00";
    //             break;
    //         default:
    //             break;
    //     }
    // } else {
    //     $day = "-";
    // }

    return $day;
}

function daterangex($date){
    $explodeDate = explode(' - ', $date);
    $listreturn = array();
    $listreturn['s'] = str_replace('/', '-', $explodeDate[0]);
    $listreturn['e'] = str_replace('/', '-', $explodeDate[1]);
    if(empty($listreturn['e'])){
        $listreturn['e'] = date("d-m-Y");
    }
    return $listreturn;
}




// function dateExplode($date){
//     $explodeDate = explode(' - ', $date);
//     $listreturn = array();

    
//     $listreturn['s'] = explode('/', $explodeDate[0]);
//     print_pre($listreturn['s']);
//     $listreturn['e'] = $explodeDate[1];
//     if(empty($listreturn['e'])){
//         $listreturn['e'] = date("d-m-Y");
//     }
//     return $listreturn;
// }


function DateThaiOrder(){
    $reDate = date("ymd");
    $strYear = date("y",strtotime($reDate))+43;
    $strMonth= date("m",strtotime($reDate));
    // $strDay= date("j",strtotime($reDate));
    $strDay= date("d",strtotime($reDate));

    return $strYear.$strMonth.$strDay;
}


function splitCommaInNumber($var){
    return str_replace(",","",$var);
}


function convert($number){ 
    $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
    $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
    $number = str_replace(",","",$number); 
    $number = str_replace(" ","",$number); 
    $number = str_replace("บาท","",$number); 
    $number = explode(".",$number); 
    if(sizeof($number)>2){ 
    return 'ทศนิยมหลายตัวนะจ๊ะ'; 
    exit; 
    } 
    $strlen = strlen($number[0]); 
    $convert = ''; 
    for($i=0;$i<$strlen;$i++){ 
        $n = substr($number[0], $i,1); 
        if($n!=0){ 
            if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
            elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
            elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
            else{ $convert .= $txtnum1[$n]; } 
            $convert .= $txtnum2[$strlen-$i-1]; 
        } 
    } 
    
    $convert .= 'บาท'; 
    if($number[1]=='0' OR $number[1]=='00' OR 
    $number[1]==''){ 
    $convert .= 'ถ้วน'; 
    }else{ 
    $strlen = strlen($number[1]); 
    for($i=0;$i<$strlen;$i++){ 
    $n = substr($number[1], $i,1); 
        if($n!=0){ 
        if($i==($strlen-1) AND $n==1){$convert 
        .= 'เอ็ด';} 
        elseif($i==($strlen-2) AND 
        $n==2){$convert .= 'ยี่';} 
        elseif($i==($strlen-2) AND 
        $n==1){$convert .= '';} 
        else{ $convert .= $txtnum1[$n];} 
        $convert .= $txtnum2[$strlen-$i-1]; 
        } 
    } 
    $convert .= 'สตางค์'; 
    } 
    return $convert; 
} 