<?
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

if( isset($_POST["court-name"]))
  $courtName = $_POST["court-name"];
else
  $courtName = NULL;
if( isset($_POST["court-address"]))
  $courtAddress = $_POST["court-address"];
else
  $courtAddress = NULL;
if( isset($_POST["court-time"]))
  $courtTime = $_POST["court-time"];
else
  $courtTime = NULL;
if( isset($_POST["court-date"]))
  $courtDate = $_POST["court-date"];
else
  $courtDate = NULL;
?>

<script>
jQuery(function($) {
  $("#data-table").dataTable( { 
        "aaSorting": [],
        "sPaginationType": "full_numbers",
        "bProcessing": false,
        "sAjaxSource": '/data/courts_search.php?courtName=<? echo $courtName ?>&courtAddress=<? echo $courtAddress?>&courtTime=<? echo $courtTime?>&courtDate=<? echo $courtDate ?>'
  } );

  $( "#accordion" ).accordion({
            active: false,
            collapsible: true,
            heightStyle: "content"
        });
        
  $('#court-location').button().click(function(){ $('#court-location-dialog').dialog('open'); });
  $("#court-location-dialog").dialog({
    resizable: false,
    autoOpen:false,
    modal: true,
    width:650,
    buttons: {
      Cancel: function() {
        resetDataTable( courtLocationTable );
        $(this).dialog('close');
      }
    }
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
      $("#court-location-dialog").dialog('close');
    }
  });
  
  $("#court-date").datepicker();
  $("#court-time").timepicker({showPeriod: true,defaultTime: ''});
});
</script>

<div id="court-location-dialog" title="Select Existing Location">
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
</div>

<h1>Search All Courts</h1>

<div id="accordion">
    <h3>Detailed Search</h3>
    <div>   
      <form name="searchCourt" id="searchCourt" method="post" action="search.php">
      <table>
        <tr>
          <td width="100">Name:</td>
          <td>
            <input type="text" name="court-name" id="court-name" style="width: 250px;" value="<? echo $courtName ?>"/>
            
            <a class="select-item ui-state-default ui-corner-all"  id="court-location" title="Select Existing Location">
              <span class="ui-icon ui-icon-newwin"></span>
            </a>        
          </td>
          <td>Court Date: </td>
          <td><input type="text" class="date" name="court-date" id="court-date" value="<? echo $courtDate ?>"></td>
        </tr>
        <tr>
          <td>Address:</td>
          <td><input type="text" name="court-address" id="court-address" style="width: 250px;" value="<? echo $courtAddress ?>"/></td>
          <td>Court Time: </td>
          <td><input type="text" class="time" name="court-time" id="court-time" value="<? echo $courtTime ?>"></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
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
        <th width="125">Court Cases</th>
        <th width="125">Date</th>
        <th width="150">Place</th>
        <th width="150">Location</th>
        <th width="50"></th>
      </tr>
  </thead>
  <tbody></tbody>
</table>

<?
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>
