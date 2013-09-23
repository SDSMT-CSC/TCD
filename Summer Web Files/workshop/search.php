<?php
$menuarea = "workshop";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

if( isset($_POST["date"]))
  $date = $_POST["date"];
else
  $date = NULL;
if( isset($_POST["instructor"]))
  $instructor = $_POST["instructor"];
else
  $instructor = NULL;
if( isset($_POST["workshop-name"]))
  $name = $_POST["workshop-name"];
else
  $name = NULL;
if( isset($_POST["workshopLocationID"]))
  $location = $_POST["workshopLocationID"];
else
  $location = NULL;
if( isset($_POST["time"]))
  $time = $_POST["time"];
else
  $time = NULL;
if( isset($_POST["topic"]))
  $topic = $_POST["topic"];
else
  $topic = NULL;
?>

<script>
jQuery(function($) {
	$("#data-table").dataTable( { 
				"aaSorting": [],
        "sPaginationType": "full_numbers",
				"bProcessing": false,
        "sAjaxSource": '/data/workshops_search.php?date=<?echo $date?>&instructor=<?echo $instructor?>&location=<?echo $location?>&time=<?echo $time?>&topic=<?echo $topic?>'
	} );

	$( "#accordion" ).accordion({
		 				active: false,
            collapsible: true,
						heightStyle: "content"
        });
  
  $('#workshop-location').button().click(function(){ $('#workshop-location-dialog').dialog('open'); });
  $("#workshop-location-dialog").dialog({
    resizable: false,
    autoOpen:false,
    modal: true,
    width:550,
    buttons: {
      Cancel: function() {
        resetDataTable( workshopLocationTable );
        $(this).dialog('close');
      }
    }
  });
  var workshopLocationTable = $("#workshop-location-table").dataTable( { 
        "aaSorting": [],
        "sPaginationType": "full_numbers",
        "bProcessing": false,
        "sAjaxSource": '/data/workshop_location.php'
  });
  $('#workshop-location-table tbody tr').live('click', function (event) {        
    var oData = workshopLocationTable.fnGetData(this); // get datarow
    if (oData != null)  // null if we clicked on title row
    {
      $("#workshop-name").val(oData[0]);
      $("#workshopLocationID").val(oData[5]);
      $("#workshop-location-dialog").dialog('close');
    }
  });
        
  $("#date").datepicker();
  $("#time").timepicker({showPeriod: true,defaultTime: ''});
});
</script>

<div id="workshop-location-dialog" title="Select Existing Location">
  <table id="workshop-location-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Zip</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<h1>Search All Workshops</h1>

<div id="accordion">
	  <h3>Detailed Search</h3>
    <div>		
			<form name="searchWorkshop" id="searchWorkshop" method="post" action="search.php">
			<table>
				<tr>
					<td>Date:</td>
					<td><input type="text" id="date" class="date" name="date" value="<? echo $date ?>"/></td>
					<td>Instructor:</td>
					<td><input type="text" name="instructor" value="<? echo $instructor ?>"/></td>
					<td>Location:</td>
					<td>
					  <input type="text" id="workshop-name" name="workshop-name" value="<? echo $name ?>"/>
					  <input type="hidden" id="workshopLocationID" name="workshopLocationID" value="<? echo $location ?>"/>
					  <a class="select-item ui-state-default ui-corner-all"  id="workshop-location" title="Select Existing Location">
              <span class="ui-icon ui-icon-newwin"></span>
            </a>  
					</td>
				</tr>
				<tr>
					<td>Time:</td>
					<td><input type="text" id="time" class="time" name="time" value="<? echo $time ?>"/></td>
					<td>Topic:</td>
					<td><input type="text" name ="topic" value="<? echo $topic ?>"/></td>
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
				<th width="15%">Date</th>
				<th width="20%">Topic</th>
				<th width="15%">Instructor</th>
        <th width="25%">Venue</th>
				<th width="20%">Location</th>
				<th width="5%"></th>
			</tr>
	</thead>
	<tbody></tbody>
</table>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>