<?php
$menuarea = "program";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

$action = $_GET["action"];
?>

<script type="text/javascript">
  jQuery(function($) {
  $("#my-program").button().click(function() {  window.location.href = "program.php"; });
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
  
  $("#location-delete").button().click(function () {
    $("#action").val("Delete Location");
    $("#location").submit();
  });
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
    
    $("#common-location-delete").button().click(function () {
      $("#action").val("Delete Location");
      $("#common").submit();
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
        <td><button id="common-location-delete">Delete</button></td>
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
    
    $("#officer-delete").button().click(function () {
      $("#action").val("Delete Officer");
      $("#officer").submit();
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
        <td></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td><input type="text" name="officer-lastname" id="officer-lastName" /></td>
        <td></td>
      </tr>
      <tr>
        <td>First Name:</td>
        <td><input type="text" name="officer-firstname" id="officer-firstName" /></td>
        <td></td>
      </tr>
      <tr>
        <td>Phone Number:</td>
        <td><input type="text" class="phone" name="officer-phone" id="officer-phone" /></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
        <td><button id="officer-delete">Delete</button></td>
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
    
    $("#statute-delete").button().click(function () {
      $("#action").val("Delete Statute");
      $("#statute").submit();
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
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
        <td><button id="statute-delete">Delete</button></td>
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
    
    $("#school-delete").button().click(function () {
      $("#action").val("Delete School");
      $("#school").submit();
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
      <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
      <td><button id="school-delete">Delete</button></td>
    </tr>
  </table>
</fieldset>
</form>
  
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
    
    $("#position-delete").button().click(function () {
      $("#action").val("Delete Position");
      $("#position").submit();
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
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
        <td><button id="position-delete">Delete</button></td>
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
    
    $("#court-location-delete").button().click(function () {
      $("#action").val("Delete CourtLocation");
      $("#court").submit();
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
        <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
        <td><button id="court-location-delete">Delete</button></td>
      </tr>
    </table>
  </fieldset>
</form>

  
<? } if( $action == "Edit Sentence" ) { ?>
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
    
    $("#sentence-delete").button().click(function () {
      $("#action").val("Delete Sentence");
      $("#sentence").submit();
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
          <td><input type="submit" name="submit" id="submit" value="Submit"/></td>
          <td><button id="sentence-delete">Delete</button></td>
        </tr>
      </table>
  </fieldset>
</form>

<? } if( $action == "Edit Workshop Location" ) { ?>

<script type="text/javascript">
  jQuery(function($) {
    $('#program-location').button().click(function(){ $('#program-location-dialog').dialog('open'); });
    
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
    
    $("#program-location-dialog").dialog({
      resizable: false,
      autoOpen:false,
      modal: true,
      width:550,
      buttons: {
        Cancel: function() {
          resetDataTable( locTable );
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
    
    var locTable = $("#program-location-table").dataTable( { 
          "aaSorting": [],
          "sPaginationType": "full_numbers",
          "bProcessing": false,
          "sAjaxSource": '/data/program_locations.php'
    });
    
    $('#workshop-location-table tbody tr').live('click', function (event) {        
      var oData = workshopLocationTable.fnGetData(this); // get datarow
      if (oData != null)  // null if we clicked on title row
      {
        $("#workshop-name").val(oData[0]);
        $("#workshop-address").val(oData[1]);
        $("#workshop-city").val(oData[2]);
        $("#workshop-state").val(oData[3]);
        $("#workshop-zip").val(oData[4]);
        $("#workshop-location-id").val(oData[5]);
      }
    });
    
    $('#program-location-table tbody tr').live('click', function (event) {
      var oData = locTable.fnGetData(this);
      if (oData != null)
      {
        $("#workshop-city").val(oData[0]);
        $("#workshop-state").val(oData[1]);
        $("#workshop-zip").val(oData[2]);
        $("#location-id").val(oData[3]);
        $('#program-location-dialog').dialog('close');
      }
    });
    
    $("#workshop-delete").button().click(function () {
      $("#action").val("Delete Workshop");
      $("#sentence").submit();
    });
  });
</script>

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

<div id="program-location-dialog" title="Select Existing Location">
  <table id="program-location-table">
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

<fieldset>
  <form id="workshop-location" name="workshop-location" method="post" action="process.php">
  <input type="hidden" name="action" id="action" value="Edit Workshop" />
  <input type="hidden" name="workshop-location-id" id="workshop-location-id" />
  <input type="hidden" name="location-id" id="location-id" />
  <legend>Workshop Location</legend>
  <table>
    <tr>
      <td width="75">Name:</td>
      <td>
        <input type="text" name="workshop-name" id="workshop-name" style="width: 250px;" />  
      </td>
    </tr>
    <tr>
      <td>Address:</td>
      <td><input type="text" name="workshop-address" id="workshop-address" style="width: 250px;" /></td>
    </tr>
    <tr>
      <td>City:</td>
      <td>     
        <input type="text" name="workshop-city" id="workshop-city" readonly=""/>
        State: <input type="text" name="workshop-state" id="workshop-state" size="2" readonly/>
        Zip: <input type="text" name="workshop-zip" id="workshop-zip" size="7" readonly/>
        
        <a class="select-item ui-state-default ui-corner-all"  id="program-location" title="Select Existing Location">
          <span class="ui-icon ui-icon-newwin"></span>
        </a>
      </td>
    </tr>
    <tr>
      <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
      <td><button id="workshop-delete">Delete</button></td>
    </tr>
  </table>
  </form>
</fieldset>

<? } if( $action == "Record Access" ) { ?>
<script>
  jQuery(function($) {
    $('#submit').button().click(function() { $('#program-access').submit(); });
    
    $("#program-access-delete").button().click(function () {
      $("#action").val("Delete Program Access");
      $("#sentence").submit();
    });
    
    var programAccessTable = $("#program-access-table").dataTable( { 
          "aaSorting": [],
          "sPaginationType": "full_numbers",
          "bProcessing": false,
          "sAjaxSource": '/data/program_access.php'
    });
    
    $('#program-access-table tbody tr').live('click', function (event) {        
      var oData = programAccessTable.fnGetData(this); // get datarow
      if (oData != null)  // null if we clicked on title row
      {
        $("#program-code").val(oData[1]);
        $("#programID").val(oData[2]);
      }
    });
  });
</script>

<table id="program-access-table">
  <thead>
    <tr>
      <th>Program Name</th>
      <th>Code</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<fieldset>
  <form id="program-access" name="program-access" method="post" action="process.php">
    <input type="hidden" name="action" id="action" value="Program Access" />
    <input type="hidden" name="programID" id="programID" />
    <legend>Program Access</legend>
    <table>
      <tr>
        <td>Code:</td>
        <td><input type="text" id="program-code" name="program-code"</td>
      </tr>
      <tr>
        <td><button id="submit">Submit</button></td>
        <td><button id="program-access-delete">Delete</button></td>
      </tr>
    </table>
  </form>
</fieldset>

<?php
}

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>