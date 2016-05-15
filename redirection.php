<?php

/******
This file provides links to the pages.
******/	

$base_url = 'http://clive.cs.ualberta.ca/~'.$_COOKIE['ccid'];

$url = array();

$folder = "/data_analysis/";
$url['analysis_main'] = $base_url . $folder . "analysis_main.php";

$folder = "/display/";
$url['view_all'] = $base_url . $folder . "viewer_all.php";
$url['view_limited'] = $base_url. $folder . "viewer_permitted.php";
$url['view_list'] = $base_url. $folder . "viewer_list.php";
$url['top_5'] = $base_url. $folder . "get_topfive.php";
$url['viewer_specific'] = $base_url. $folder . "viewer_specific.php";

$folder = "/search/";
$url['search_main'] = $base_url . $folder . "search_main.php";

$folder = "/security/";
$url['groups_main'] = $base_url . $folder . "groups_main.php";
$url['create_group'] = $base_url . $folder . "create_group.php";
$url['view_group'] = $base_url . $folder . "view_group.php";
$url['login'] = $base_url . $folder . "login.php";

$folder = "/uploading/";
$url['uploader_main'] = $base_url . $folder . "uploader_main.php";
$url['uploader_select'] = $base_url . $folder . "uploader_select.php";

$folder = "/user_management/";
$url['registration_main'] = $base_url . $folder . "registration.php";
$url['welcome_main'] = $base_url . $folder . "welcome_main.php";
$url['settings'] = $base_url . $folder . "settings.php";

$folder = "/user_help/";
$url['help'] = $base_url . $folder . "help.php";

?>
