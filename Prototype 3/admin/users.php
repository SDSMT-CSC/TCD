<?php

$menuarea = "admin";

include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

include($_SERVER['DOCUMENT_ROOT']."/includes/class_data.php");

?>



<script>



jQuery(function($)

{

	$("#data-table").dataTable( { 

				"aaSorting": [],

        "sPaginationType": "full_numbers",

				"bProcessing": true,

        "sAjaxSource": '/data/user_listing.php'

	} );



});

</script>



<h1>Active Court Programs</h1>



<table id="data-table">

	<thead>

			<tr>

				<th width="50">Program</th>

				<th width="100">Type</th>

				<th width="100">First name</th>

				<th width="100">Last name</th>

				<th width="150">Email</th>
				<th width="20">Action</th>

			</tr>

	</thead>

	<tbody>



	</tbody>

</table>





<?php

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");

?>