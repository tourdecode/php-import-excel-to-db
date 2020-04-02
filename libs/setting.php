<?php

## load modulus ##
require_once _DIR . '/libs/adodb5.20.13/adodb.inc.php';
require_once _DIR . '/libs/smarty-3.1.33/Smarty.class.php';
require_once _DIR . '/libs/smarty-3.1.33/SmartyBC.class.php';

## adodb start ##
$db = NewADOConnection($coreLanguageSQL);

$db->Connect($core_db_hostname, $core_db_username, $core_db_password, $core_db_name);

$db->charSet = "SET NAMES " . $core_db_charecter_set['charset'];
$db->Execute("SET character_set_results=" . $core_db_charecter_set['charset']);
$db->Execute("SET collation_connection=" . $core_db_charecter_set['collation']);
$db->Execute("SET NAMES '" . $core_db_charecter_set['charset'] . "'");
//$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->cacheSecs = 3600 * 12;

## smarty start ##
$smarty = new Smarty;
$smarty = new SmartyBC();
// $smarty->loadPlugin('smarty_compiler_switch');
$smarty->debugging = FALSE;
$smarty->caching = FALSE;
$smarty->setTemplateDir($path_template[$templateweb])->setCompileDir($path_compile)->setCacheDir($path_cache);

$listModulus = array();
$listNodeOn = array();