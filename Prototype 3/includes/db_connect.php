<?
$db_host = 'localhost';
$db_name = 'teencour_data';
$db_user = 'teencour_web';
$db_password = 't33nc0urtw3b12';

// global date format
date_default_timezone_set('America/Denver');
$globalDateFormat = "m/d/y g:i a";

$link = mysql_connect($db_host, $db_user, $db_password) or die('Could not connect: ' . mysql_error());
mysql_select_db($db_name) or die(print('Unable to connect to database.'));
?>