<?php
$menuarea = "program";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

$action = $_GET["action"];
?>

<script type="text/javascript">
  jQuery(function($) {
  $("#my-program").button().click(function() {  window.location.href = "program.php"; });
  $("#location-delete").button().click(function () {
    $("#action").val("Delete Location");
    $("#location").submit();
  });
});
</script>

<div id="control-header"> 
  <div class="left"><h1><? echo $action ?></h1></div> 
  <div class="right">
    <div id="control" class="ui-state-error">
      <button id="my-program">Back to Program</button>
    </div>
  </div>
</div>

<? if($action == "Edit Location") { ?>
<script type="text/javascript">
  jQuery(function($) {      
    
  var locTable = $("#location-table").dataTable( { 
        "aaSorting": [],
        "sPaginationType": "full_numbers",
        "bProcessing": false,
        "sAjaxSource": '/data/program_locations.php'
  });
  
  //$(document).ready( function() {
    $('#location-table tbody tr').live("click", function() {
      var oData = locTable.fnGetData(this); // get datarow
      if (oData != null)  // null if we clicked on title row
      {
        $("#location-city").val(oData[0]);
        $("#location-state").val(oData[1]);
        $("#location-zip").val(oData[2]);
        $("#location-id").val(oData[3]);
      }
    });
  //});
});
</script>
<table id="location-table">
  <thead>
      <tr>
        <th>City</th>
        <th>State</th>
        <th>Zip</th>
      </tr>
  </thead>
  <tbody></tbody>
</table>

<form name="location" id="location" method="post" action="process.php">
  <input type="hidden" name="action" value="Edit Location"/>
  <input type="hidden" id="location-id" name="location-id" />
  <fieldset>
    <legend>Location Information</legend>
      <table>
        <tr>
          <td>City:</td>
          <td><input type="text" id="location-city" name="location-city"/></td>
          <td></td>
        </tr>
        <tr>
          <td>State:</td>
          <td><input type="text" id="location-state" name="location-state"/></td>
          <td><button id="location-delete">Delete</button></td>
        </tr>
        <tr>
          <td>Zip:</td>
          <td><input type="text" id="location-zip" name="location-zip"/></td>
          <td><input type="submit" id="submit" name="submit" value="Submit"/></td>
        </tr>
      </table>
  </fieldset>
</form>

<? } if($action == "Edit Common Location") { ?>
<script type="text/javascript">
  jQuery(function($) {
    var commonLocationTable = $("#common-location-table").dataTable( { 
        "aaSorting": [],
        "aoColumns": [ { sClass: "alignLeft" } ],
        "sPaginationType": "full_numbers",
        "bProcessing": false,
        "sAjaxSource": '/data/program_common_locations.php'
    });
    
    $('#common-location-table tbody tr').live('click', function (event) {        
    var oData = commonLocationTable.fnGetData(this); // get datarow
    if (oData != null)  // null if we clicked on title row
    {
        $("#common-location").val(oData[0]);
        $("#common-locationID").val(oData[1]);
    }
    });
  });
</script>

<div id="common-location-dialog" title="Add Common Location">
  <table id="common-location-table">
    <thead>
        <tr>
          <th>Location</th>
        </tr>
    </thead>
    <tbody></tbody>
  </table> 
</div>

<form name="common" id="common" method="post" action="process.php">
  <input type="hidden" name="action" value="Edit Common Location"/>
  <input type="hidden" name="common-locationID" id="common-locationID" />
  <fieldset>
    <legend>Common Location Name</legend>
    <table>
      <tr>
        <td>Name:</td>
        <td><input type="text" name="common-location" id="common-location" /></td>
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
      </tr>
    </table>
  </fieldset>
</form>

<? } if($action == "Edit Officers") { ?>
<script type="text/javascript">
  jQuery(function($) {
    var commonLocationTable = $("#officer-table").dataTable( { 
        "aaSorting": [],
        "sPaginationType": "full_numbers",
        "bProcessing": false,
        "sAjaxSource": '/data/program_officers.php'
    });
    
    $('#officer-table tbody tr').live('click', function (event) {        
    var oData = commonLocationTable.fnGetData(this); // get datarow
    if (oData != null)  // null if we clicked on title row
    {
        $("#officer-firstName").val(oData[0]);
        $("#officer-lastName").val(oData[1]);
        $("#officer-idNumber").val(oData[2]);
        $("#officer-phone").val(oData[3]);
        $("#officer-id").val(oData[4]);
    }
    });
  });
</script>

<table id="officer-table">
  <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>ID Number</th>
        <th>Phone Number</th>
      </tr>
  </thead>
  <tbody></tbody>
</table> 


<form id="officer" name="officer" method="post" action="process.php">
  <input type="hidden" name="action" value="Edit Officers" />
  <input type="hidden" name="officer-id" id="officer-id" />
  <fieldset>
    <table>
      <tr>
        <td width="100">Identification:</td>
        <td><input type="text" name="officer-idNumber" id="officer-idNumber" /></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td><input type="text" name="officer-lastname" id="officer-lastName" /></td>
      </tr>
      <tr>
        <td>First Name:</td>
        <td><input type="text" name="officer-firstname" id="officer-firstName" /></td>
      </tr>
      <tr>
        <td>Phone Number:</td>
        <td><input type="text" class="phone" name="officer-phone" id="officer-phone" /></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
      </tr>
    </table>
  </fieldset>
</form>

<? } if($action == "Edit Statutes") { ?>
<script type="text/javascript">
  jQuery(function($) {
    var statuteTable = $("#statute-table").dataTable( { 
        "aaSorting": [],
        "aoColumns" : [ 
          { "bVisible": false, "bSearchable": false },  // statuteID
          { sWidth: '20%' },                            // statute
          { sWidth: '80%', sClass: "alignLeft" } ],     // description
        "sPaginationType": "full_numbers",
        "iDisplayLength": 5,
        "aLengthMenu": [[5, 10], [5, 10]],
        "bProcessing": false,
        "sAjaxSource": '/data/program_statutes.php'
    });
    
    $('#statute-table tbody tr').live('click', function (event) {
    var oData = statuteTable.fnGetData(this); // get datarow
    if (oData != null)  // null if we clicked on title row
    {
      $("#statuteID").val(oData[0]);
      $("#statute-code").val(oData[1]);
      $("#statute-title").val(oData[3]);
      $("#statute-description").val(oData[4]);
    }  
    });
  });
</script>

<table id="statute-table">
  <thead>
      <tr>
        <th>StatuteID</th>
        <th>Statute</th>
        <th align="left">Description</th>
      </tr>
  </thead>
  <tbody></tbody>
</table>

<form id="statute" action="process.php" method="post">
  <input type="hidden" name="action" value="Edit Statutes" />
  <input type="hidden" name="statuteID" id="statuteID" />
  <fieldset>
    <legend>Statute Information</legend>
    <table>
      <tr>
        <td width="100">Code:</td>
        <td><input type="text" name="statute-code"  id="statute-code" style="width: 300px" /></td>
      </tr>
      <tr>
        <td>Title:</td>
        <td><input type="text" name="statute-title" id="statute-title" style="width: 300px" /></td>
      </tr>
      <tr>
        <td valign="top">Description:</td>
        <td><textarea name="statute-description" id="statute-description" style="width: 300px; height: 100px;"></textarea></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
      </tr>
    </table>
  </fieldset>
</form>
  
<? } if($action == "Edit Schools") { ?>
<script type="text/javascript">
  jQuery(function($) {
    var schoolTable = $("#school-table").dataTable( { 
        "aaSorting": [],
        "sPaginationType": "full_numbers",
        "bProcessing": false,
        "sAjaxSource": '/data/program_schools.php'
    });
  
    $('#school-table tbody tr').live('click', function (event) {        
      var oData = schoolTable.fnGetData(this); // get datarow
      if (oData != null)  // null if we clicked on title row
      {
          $("#school-name").val(oData[0]);
          $("#school-address").val(oData[1]);
          $("#school-city").val(oData[2]);
          $("#school-state").val(oData[3]);
          $("#school-zip").val(oData[4]);
          $("#schoolID").val(oData[5]);
      }
    });
  });
</script>

<table id="school-table">
  <thead>
    <tr>
      <th>School</th>
      <th>Address</th>
      <th>City</th>
      <th>State</th>
      <th>Zip</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<form name="school" id="school" method="post" action="process.php"/>
<fieldset>
  <input type="hidden" name="action" value="Edit Schools" />
  <input type="hidden" name="schoolID" id="schoolID" />
  <legend>School Information</legend>
  <table>
    <tr>
      <td>School Name:</td>
      <td><input type="text" name="school-name" id="school-name" size="40" /></td>
    </tr>
    <tr>
      <td>Address:</td>
      <td><input type="text" name="school-address" id="school-address" size="40" /></td>
    </tr>
    <tr>
      <td>City:</td>
      <td>
        <input type="text" name="school-city" id="school-city" />
        State: <input type="text" name="school-state" id="school-state" size="2" />
        Zip: <input type="text" name="school-zip" id="school-zip" size="7" />
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
    </tr>
  </table>
</fieldset>
  
<? } if($action == "Edit Positions") { ?>
<script type="text/javascript">
  jQuery(function($) {
    var schoolTable = $("#position-table").dataTable( { 
        "aaSorting": [],
        "sPaginationType": "full_numbers",
        "bProcessing": false,
        "sAjaxSource": '/data/program_positions.php'
    });
    
    $('#position-table tbody tr').live('click', function (event) {        
      var oData = schoolTable.fnGetData(this); // get datarow
      if (oData != null)  // null if we clicked on title row
      {
          $("#position-title").val(oData[0]);
          $("#positionID").val(oData[1]);
      }
    });
  });
</script>

<table id="position-table">
  <thead>
    <tr>
      <th>Position</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<form id="position" name="position" method="post" action="process.php">
  <fieldset>
    <input type="hidden" name="action" value="Edit Positions" />
    <input type="hidden" name="positionID" id="positionID" />
    <table>
      <tr>
        <td>Position:</td>
        <td><input type="text" name="position" id="position-title" /></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
      </tr>
    </table>
  </fieldset>
</form>
  
<? } if($action == "Edit Court Locations") { ?>
<script type="text/javascript">
  jQuery(function($) {
    $('#program-location').button().click(function(){ $('#location-dialog').dialog('open'); }); 
    $("#location-dialog").dialog({
      resizable: false,
      autoOpen:false,
      modal: true,
      width:500,
      buttons: {
        Cancel: function() {
          resetDataTable( locTable );
          $(this).dialog('close');
        }
      }
    });
    
    var locTable = $("#location-table").dataTable({ 
          "aaSorting": [],
          "sPaginationType": "full_numbers",
          "bProcessing": false,
          "sAjaxSource": '/data/program_locations.php'
    });
    
    var courtLocationTable = $("#court-location-table").dataTable({ 
          "aaSorting": [],
          "sPaginationType": "full_numbers",
          "bProcessing": false,
          "sAjaxSource": '/data/court_location.php'
    });
    
    $('#court-location-table tbody tr').live('click', function (event) {        
      var oData = courtLocationTable.fnGetData(this); // get datarow
      if (oData != null)  // null if we clicked on title row
      {
        $("#court-name").val(oData[0]);
        $("#court-address").val(oData[1]);
        $("#court-city").val(oData[2]);
        $("#court-state").val(oData[3]);
        $("#court-zip").val(oData[4]);
        $("#court-location-id").val(oData[5]);
      }
    });
    
    $('#location-table tbody tr').live('click', function (event) {
      var oData = locTable.fnGetData(this);
      if (oData != null)
      {
        $("#court-city").val(oData[0]);
        $("#court-state").val(oData[1]);
        $("#court-zip").val(oData[2]);
        $("#location-id").val(oData[3]);
        $('#location-dialog').dialog('close');
      }
    });
  });
</script>

<div id="location-dialog" title="Select Existing Location">
  <table id="location-table">
    <thead>
        <tr>
          <th>City</th>
          <th>State</th>
          <th>Zip</th>
        </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<table id="court-location-table">
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

<form id="court" name="court" method="post" action="process.php">
  <input type="hidden" name="action" value="Edit Court Locations" />
  <input type="hidden" name="court-location-id" id="court-location-id" />
  <input type="hidden" name="location-id" id="location-id" />
  <fieldset>
    <legend>Court Location</legend>
    <table>
      <tr>
        <td>Name:</td>
        <td><input type="text" name="court-name" id="court-name" style="width: 250px;"/></td>
      </tr>
      <tr>
        <td>Address:</td>
        <td><input type="text" name="court-address" id="court-address" style="width: 250px;" /></td>
      </tr>
      <tr>
        <td>City:</td>
        <td>     
          <input type="text" name="court-city" id="court-city" readonly/>
          State: <input type="text" name="court-state" id="court-state" size="2" readonly/>
          Zip: <input type="text" name="court-zip" id="court-zip" size="7" readonly/>
          
          <a class="select-item ui-state-default ui-corner-all"  id="program-location" title="Select Existing Location">
            <span class="ui-icon ui-icon-newwin"></span>
          </a>
        </td>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
      </tr>
    </table>
  </fieldset>
</form>
  
<? } if($action == "Edit Sentence") { ?>
<script type="text/javascript">
  jQuery(function($) {
    var sentenceTable = $("#sentence-table").dataTable( { 
        "aaSorting": [],
        "aoColumnDefs" : [ { "aTargets": [0], "bVisible": false, "bSearchable": false } ],
        "sPaginationType": "full_numbers",
        "bProcessing": false,
        "sAjaxSource": '/data/program_sentences.php'
    });
    
    $('#sentence-table tr').live('click', function (event) {
      var oData = sentenceTable.fnGetData(this); // get datarow
      if (oData != null)  // null if we clicked on title row
      {
          $("#sentenceID").val(oData[0]);
          $("#sentence-name").val(oData[1]);
          $("#sentence-description").val(oData[2]);
          $("#sentence-additional").val(oData[3]);
      }
    });
  });
</script>

<table id="sentence-table">
  <thead>
    <tr>
      <th>SentenceID</th>
      <th>Sentence</th>
      <th>Description</th>
      <th>Type</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<form id="sentence" name="sentence" method="post" action="process.php">
  <input type="hidden" name="action" value="Edit Sentence" />
  <input type="hidden" name="sentenceID" id="sentenceID" />
  <fieldset>
    <legend>Sentence Information</legend>
      <table>
        <tr>
          <td width="150">Sentence:</td>
          <td><input type="text" name="sentence-name" id="sentence-name"/></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td><input type="text" name="sentence-description" id="sentence-description"/></td>
        </tr>
        <tr>
          <td>Additional Text Name:</td>
          <td><input type="text" name="sentence-additional" id="sentence-additional"/></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
        </tr>
      </table>
  </fieldset>
</form>
<?php
}

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>