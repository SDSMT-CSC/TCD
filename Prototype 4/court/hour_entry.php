<?php
$menuarea = "court";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");
include($_SERVER['DOCUMENT_ROOT']."/includes/class_court.php");

$court = new Court( $user_programID );
$court->getFromID( $_GET["id"] );

?>
<fieldset>
  <legend>Set hours for court members</legend>
  <table style="width: 600px">
  <?
  // get programs court positions and who was assigned for this court
  $members = $court->getMembersForTime();
  
  foreach( $members as $row )
  {
   ?>
    <tr>
      <td><? echo $row['position'] ?>: </td>
      <td><? echo $row['lastName'] . ", " . $row['firstName'] ?></td>
      <td><input type="text" name="member[]" value="" size="5" /></td>
    </tr>  
  <?
  }
  ?>
  </table>
</fieldset>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>
