<?php
$menuarea = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

if (isset($_POST["firstName"]))
  $firstName = $_POST["firstName"];
else
  $firstName = NULL;
if (isset($_POST["lastName"]))
  $lastName = $_POST["lastName"];
else
  $lastName = NULL;
if (isset($_POST["phone"]))
  $phone = $_POST["phone"];
else
  $phone = NULL;
if (isset($_POST["email"]))
  $email = $_POST["email"];
else
  $email = NULL;
if (isset($_POST["active"]))
  $active = $_POST["active"];
else
  $active = NULL;
?>

<script>
jQuery(function($) {
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": false,
        "sAjaxSource": '/data/volunteers_search.php?firstName=<? echo $firstName ?>&lastName=<? echo $lastName ?>&phone=<? echo $phone ?>&email=<? echo $email?>&active=<? echo $active?>'
	} );

	 $( "#accordion" ).accordion({
		 				active: false,
            collapsible: true,
						heightStyle: "content"
        });
});
</script>

<h1>Search All Volunteers</h1>

<div id="accordion">
	  <h3>Detailed Search</h3>
    <div>		
			<form name="searchVolunteer" id="searchVolunteer" method="post" action="search.php">
			<table>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="firstName" value="<? echo $firstName?>"/></td>
					<td>Phone #:</td>
					<td><input type="text" name="phone" size="10" value="<? echo $phone?>"/></td>
					<td>Active:</td>
					<td>
							<select name="active">
							  <option></option>
								<option <? if($active == "Yes") echo " selected"?>>Yes</option>
								<option <? if($active == "No") echo " selected"?>>No</option>
							</select>
					</td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="lastName" value="<? echo $lastName ?>"/></td>
					<td>Email:</td>
					<td><input type="text" name ="email" value="<? echo $email?>"/></td>
					<td></td>
					<td><input type="submit" id="submit" name="submit" value="Search" /></td>
				</tr>
			</table>
		</form>
		</div>
</div>

<table id="data-table">
	<thead>
			<tr>
				<th width="50">Volunteer#</th>
				<th width="75">First Name</th>
				<th width="75">Last Name</th>
				<th width="125">Phone#</th>
				<th width="150">Email</th>
				<th width="125">Modify</th>
			</tr>
	</thead>
	<tbody></tbody>
</table>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>