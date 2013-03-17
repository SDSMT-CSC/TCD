<?
include($_SERVER['DOCUMENT_ROOT']."/includes/secure.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Teen Court Database</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" href="/favicon.ico">
<style type="text/css" media="screen">
	@import "/includes/css/site.css";
	@import "/includes/css/jquery-ui-teencourt.css";
	@import "/includes/css/jquery.dataTables.css";
	@import "/includes/css/jquery.ui.timepicker.css";
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
<script src="/includes/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/includes/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="/includes/js/jquery.cookie.js" type="text/javascript"></script>
<script src="/includes/js/jquery.ui.timepicker.js" type="text/javascript"></script>

<script>
jQuery(function($)
{
	$("#submit").button();
	$(".delete").button();
	$(".add").button();
	
	$("#menu ul li ul").hover( 
		 function () {
			$(this).parent().children("a").removeClass("selected");
			$(this).parent().children("a").addClass("over");
		}, 
		function () {
			$(this).parent().children("a").removeClass("over");
			<? if( $menuarea) { ?>	$("#<? echo $menuarea ?>").parent().children("a").addClass("selected") <? } ?>
		}	
	);
	
	<? if( $menuarea ) { ?>
	$("#<? echo $menuarea ?>").addClass("selected");
	<? } ?>	
	
	$(".listing").each(function() {
			$(this).children('tbody').children(':even').css("background-color", "#EFF4F6");
    });
	
});

// function to reset the datatables
function resetDataTable( dTable ) {
	dTable.fnFilter('');
	var tLength = $("#"+dTable.attr("id")+"_length option:eq(0)");
	tLength.prop('selected', true);
	dTable.fnSettings()._iDisplayLength = tLength.val();
	dTable.fnDraw();
}
</script>

</head>

<body>

<!-- BEGIN CONTAINER -->

<div id="container">

	<!-- BEGIN HEADER -->
	<div id="header">
		<div class="left">
			<strong><? echo $program->getName() ?></strong><br />
			<? echo $program->getFullAddress() ?><br />
			<? echo $program->phone ?> | <a href="/contact.php">Contact Administrator</a>
		</div>
		<div class="right">		
			<div class="identity">605-555-5555 | <a href="/help.php">Help</a> | <a href="/contact.php">Support</a></div>
			<div class="user">Logged in as: <a href="/profile.php"><? echo $user->getName(); ?></a> | <a href="/index.php?logout">Logout</a></div>
		</div>		 
	</div>
	<!-- END HEADER -->
	
	<!-- BEGIN TOOLBAR -->
	<div id="toolbar"><?php include("menu.php") ?></div>
	<!-- END TOOLBAR -->
		
	<!-- BEGIN BODY -->
	<div id="content">