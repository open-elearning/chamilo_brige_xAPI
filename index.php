<?php

// @package chamilo.plugin.rgpd_consentement

if(file_exists(__DIR__."/chamilo_brige_xAPI.php")){
	require_once(__DIR__."/chamilo_brige_xAPI.php");
	$plugin_info = chamilo_brige_xAPI::create()->get_info();
}

require_once("inc/fonctions.php");

$parsedUrl = parse_url($_SERVER['REQUEST_URI']);
$parsedUrlpathCtr = $parsedUrl['path'];

$version = '?v=01';
$interface = 'localhost';
$loginAccepted = isset($_SESSION['chamilo_brige_xAPI_accepted']) ? $_SESSION['chamilo_brige_xAPI_accepted'] : null;

$aid = api_get_current_access_url_id();

$pwp = api_get_path(WEB_PLUGIN_PATH) . 'chamilo_brige_xAPI/resources/';

$fh = '<script src="'.$pwp.'chamilo_brige_xapi.js'.$version.'" type="text/javascript" ></script>';

echo $fh;