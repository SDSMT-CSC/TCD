<?php 
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
?>

<script>
jQuery(function($) {
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": false,
        "sAjaxSource": '/data/defendants.php'
	} );
	
	 $( "#accordion" ).accordion({
		 				active: false,
            collapsible: true,
						heightStyle: "content"
        });

});
</script>

<h1>Search All Defendants</h1>

<div id="accordion">
	  <h3>Detailed Search</h3>
    <div>		
			<form name="searchDefendant" id="searchDefendant" method="post" action="search.php">
			<table>
				<tr>
					<td>
						<table>
							<tr>
								<td>Last Name: </td>
								<td><input type="text" name="last-name" id="first-name" /></td>
							</tr>
							<tr>
								<td>First Name:</td>
								<td><input type="text" name="last-name" id="last-name" /></td>
							</tr>
							<tr>
								<td>City:</td>
								<td>
									<select name="city">
										<option>Deadwood, SD</option>
										<option>Lead, SD</option>
										<option>Spearfish, SD</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td>		
						<table>
							<tr>
								<td>Date of Birth:</td>
								<td><input type="text" name="last-name" id="dob" /></td>
							</tr>
							<tr>
								<td>Home Phone:</td>
								<td><input type="text" name="last-name" id="home-phone" /></td>
							</tr>
							<tr>
								<td>Expunged:</td>
								<td><input type="text" name="last-name" id="expunged-date" /></td>
							</tr>
						</table>
					</td>
					<td>		
						<table>
							<tr>
								<td>Court Case #:	</td>
								<td><input type="text" name="last-name" id="court-case" /></td>
							</tr>
							<tr>
								<td>Agency Case #:</td>
								<td><input type="text" name="last-name" id="agency-case" /></td>
							</tr>
							<tr>
								<td>Closed:</td>
								<td><input type="text" name="last-name" id="closed-date" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div class="submitrow"><input type="submit" id="submit" name="submit" value="Search" /></div>
			</form>
		</div>
</div>

<table id="data-table">
	<thead>
			<tr>
				<th width="50">Citation#</th>
				<th width="75">Court Case#</th>
				<th width="75">Last Name</th>
				<th width="75">First Name</th>
				<th width="125">Location</th>
				<th width="150">Added</th>
				<th width="50"></th>
			</tr>
	</thead><tbody>
	</tbody>
</table>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>