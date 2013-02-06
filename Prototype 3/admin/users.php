<?php
$menuarea = "admin";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

$core = Core::dbOpen();
$result = mysql_query("SELECT programID, type, firstName, lastName, email FROM user");
$stmt = $core->dbh->prepare($sql);
$stmt->execute();
$rows = array();
while($r = mysql_fetch_assoc($stmt))
	$rows[] = $r;
$table = json_encode($rows);
Core::dbClose();

?>

<script>
jQuery(function($)
{
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": true,
        "sAjaxSource": $table
	} );

});
</script>

<h1>Active Court Programs</h1>

<table id="data-table">
	<thead>
			<tr>
				<th width="50">Program ID</th>
				<th width="30">Type</th>
				<th width="200">First name</th>
				<th width="100">Last name</th>
				<th width="150">Email</th>
			</tr>
	</thead>
	<tbody>

	</tbody>
</table>


<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>