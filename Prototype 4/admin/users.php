<?php
$menuarea = "users";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

if( $user_type > 3 ) 
{
?><p>You do not have access to this page.</p><? 
} else { 
?>

<script>
jQuery(function($)
{
	$( "#new-user" ).button().click(function() {	window.location.href = "view_user.php";	});
	
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": false,
        "sAjaxSource": '/data/users.php'
	} );

});
</script>

<div id="control-header">
	<div class="left"><h1>User List</h1></div>	
	<div class="right">
		<div id="control" class="ui-state-error">
			<button id="new-user">New User</button>
		</div>
	</div>
</div>


<table id="data-table">
	<thead>
			<tr>
				<th width="50">Program</th>
				<th width="150">Type</th>
				<th width="100">First name</th>
				<th width="100">Last name</th>
				<th width="150">Email</th>
				<th width="20">Active</th>
			  <th width="20">Action</th>
			</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<?php
} // end error check

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>