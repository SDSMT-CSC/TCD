<?
ini_set("session.gc_maxlifetime", "3600");
session_start();

include($_SERVER['DOCUMENT_ROOT']."/includes/db_connect.php");

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Youth Court Database</title>
<link type="text/css" href="/includes/css/site.css" rel="stylesheet" />
<link type="text/css" href="/includes/css/jquery-ui-custom.css" rel="stylesheet" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>

<script>
jQuery(function($)
{
	$("#tabs").tabs();
});

</script>

</head>

<body>

<div id="container">
	<!-- BEGIN HEADER -->
	<div id="header">
  	
		HEADER
		 
	</div>
	
	<!-- BEGIN TOOLBAR -->
	<div id="toolbar"><?php #include("menu.php") ?></div>
		
	<!-- END HEADER / BEGIN BODY -->
	<div id="content">
	
	