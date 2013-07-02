<?php
$menuarea = "program";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

// access check: make sure logged in user has access to edit this program
// or if some user with type 3 and a different program tries to view it
if( $user_programID != $program->getProgramID() ) 
{
?><p>You do not have access to this page.</p><?
} else { 
?>

<h1>Program Data</h1>

<table>
  <tr>
    <td>Your Program Code: <? echo $program->getCode() ?></td>
    <td>The Program Code is used to allow non-users to create an account to gain access to your program.</td>
  </tr>
</table>

<fieldset>
  <legend>Program Information</legend>
  <table>
    <tr>
      <td><a href="view_program.php?id=<? echo $program->getProgramID() ?>">Primary Program Information</a></td>
      <td>Edit Program's Name, Code, Phone Number, and Address</td>
    </tr>
    <tr>
      <td><a href="program_data.php?action=Edit%20Location">Add/Edit Program Locations</a></td>
      <td>Add/Edit City, State, and Zip Information</td>
    </tr>
    <tr>
      <td><a href="program_data.php?action=Edit%20Common%20Location">Add/Edit Program Common Locations</a></td>
      <td>Add/Edit Common Locations for Citations</td>
    </tr>
    <tr>
      <td><a href="program_data.php?action=Edit%20Officers">Add/Edit Program Officers</a></td>
      <td>Add/Edit Officers Issuing Citations</td>
    </tr>
    <tr>
      <td><a href="program_data.php?action=Edit%20Statutes">Add/Edit Program Statutes</a></td>
      <td>Add/Edit Legal Statues</td>
    </tr>
    <tr>
      <td><a href="program_data.php?action=Edit%20Schools">Add/Edit Program Schools</a></td>
      <td>Add/Edit Schools within Program</td>
    </tr>
    <tr>
      <td><a href="program_data.php?action=Edit%20Positions">Add/Edit Program Court Positions</a></td>
      <td>Add/Edit Program Volunteer Positions</td>
    </tr>
    <tr>
      <td><a href="program_data.php?action=Edit%20Court%20Locations">Add/Edit Program Court Locations</a></td>
      <td>Add/Edit Locations Court is held</td>
    </tr>
    <tr>
      <td><a href="program_data.php?action=Edit%20Sentence">Add/Edit Program Sentences</a></td>
      <td>Add/Edit Sentences Defendants can be assigned</td>
    </tr>
  </table>
</fieldset>

<?php
} // end error check

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>