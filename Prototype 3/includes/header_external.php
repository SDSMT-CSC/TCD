<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Teen Court Database</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<meta http-equiv="Content-type" content="text/html">
	<meta http-equiv="Cache-Control" content="must-revalidate">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Cache-Control" content="private">
	<meta http-equiv="Pragma" content="no-cache">
	
	<link rel="shortcut icon" href="/favicon.ico">
	<style type="text/css" media="screen">
		@import "/includes/css/site.css";
		@import "/includes/css/jquery-ui-teencourt.css";
	</style>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js" type="text/javascript"></script>
	<script src="/includes/js/jquery.validate.min.js" type="text/javascript"></script>
	<? if( $areaname == "registration") { ?><script src="/includes/js/jquery.pstrength.js" type="text/javascript"></script><? } ?>
</head>

<body>

<!-- BEGIN CONTAINER -->
<div id="container">

	<!-- BEGIN HEADER -->
	<div id="header-external"></div>

	<!-- BEGIN BODY -->
	<div id="content">