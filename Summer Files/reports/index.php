<?php
$menuarea = "reports";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

$demographicsAccess = $program->getProgramAccess();
?>

<script type="text/javascript">
jQuery(function($) {
  $("#start-date").datepicker();
  $("#end-date").datepicker();
  $("#generate-report").button().click( function(){ $("#report").submit(); });
  
  $("#demographic-dialog").dialog({
    resizable: false,
    autoOpen:false,
    modal: true,
    width:650,
    buttons: {
      Cancel: function() {
        $(this).dialog('close');
      }
    }
  });
});
</script>

<h1>Reports</h1>

<form name="report" id="report" method="post" action="process.php">
<input type="hidden" name="programID" id="programID" value="<? echo $user_programID; ?>" />
<fieldset>
  <legend>Set up report</legend>
  <table>
    <tr>
      <td>Select Report Type:</td>
      <td>
        <select name="report_type" id="report_type">
          <option></option>
          <option val="Volunteer Hours">Volunteer Hours</option>
          <option val="Demographics">Demographics</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Start Date:</td>
      <td><input type="text" class="date" name="start-date" id="start-date" value="<? echo date("m/d/Y", time() - 60 * 60 * 24); ?>"></td>
    </tr>
    <tr>
      <td>End Date:</td>
      <td><input type="text" class="date" name="end-date" id="end-date" value="<? echo date("m/d/Y"); ?>"></td>
    </tr>
  </table>
</fieldset>

<fieldset>
<legend>Programs to pull demographics from</legend>
  <table>
    <tr>
      <td width="250"><? echo $program->getName(); ?></td>
      <td>
        <input type="checkbox" name="demographics[]" value="<? echo $user_programID; ?>"/>
      </td>
    </tr>
    <? foreach( $demographicsAccess as $key => $value) { ?>
      <tr>
        <td width="250"><? echo $key ?></td>
        <td>
          <input type="checkbox" name="demographics[]" value="<? echo $value; ?>"/>
        </td>
      </tr>
    <? } ?>
  </table>
</fieldset>
</form>

<button id="generate-report">Create Report</button>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>