<?php 
$menuarea = "defendant";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

//search terms
if (isset($_POST["firstName"]))
  $firstName = $_POST["firstName"];
else
  $firstName = NULL;
if (isset($_POST["lastName"]))
  $lastName = $_POST["lastName"];
else
  $lastName = NULL;
if (isset($_POST["location"]))
  $location = $_POST["location"];
else
  $location = NULL;
if (isset($_POST["dateOfBirth"]))
  $dateOfBirth = $_POST["dateOfBirth"];
else
  $dateOfBirth = NULL;
if (isset($_POST["phone"]))
  $phone = $_POST["phone"];
else
  $phone = NULL;
/*if (isset($_POST["expungedDate"]))
  $expungedDate = $_POST["expungedDate"];
else
  $expungedDate = NULL;*/
if (isset($_POST["courtFileNumber"]))
  $courtFileNumber = $_POST["courtFileNumber"];
else
  $courtFileNumber = NULL;
if (isset($_POST["agencyNumber"]))
  $agencyNumber = $_POST["agencyNumber"];
else
  $agencyNumber = NULL;
?>

<script>
jQuery(function($) {
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": false,
        "sAjaxSource": '/data/defendants_search.php?firstName=<? echo $firstName?>&lastName=<? echo $lastName?>&location=<? echo $location?>&dateOfBirth=<? echo $dateOfBirth?>&homePhone=<? echo $phone?>&courtFileNumber=<? echo $courtFileNumber?>&agencyNumber=<? echo $agencyNumber?>'
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
								<td><input type="text" name="lastName" value="<? echo $lastName ?>"/></td>
								<td>Date of Birth:</td>
                <td><input type="text" name="dateOfBirth" value="<? echo $dateOfBirth ?>" /></td>
                <td>Court Case #: </td>
                <td><input type="text" name="courtFileNumber" value="<? echo $courtFileNumber ?>" /></td>
							</tr>
							<tr>
								<td>First Name:</td>
								<td><input type="text" name="firstName" value="<? echo $firstName ?>"/></td>
								<td>Home Phone:</td>
                <td><input type="text" name="phone" value="<? echo $phone ?>" /></td>
                <td>Agency Case #:</td>
                <td><input type="text" name="agencyNumber" value="<? echo $agencyNumber ?>" /></td>
							</tr>
							<tr>
								<td>City:</td>
								<td><input type="text" name="location" value="<? echo $location ?>"</td>
								<td></td>
								<td></td>
								<td></td>
								<td><input type="submit" id="submit" name="submit" value="Search" /></div></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
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