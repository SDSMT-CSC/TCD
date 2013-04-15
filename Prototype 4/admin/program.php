<?php
$menuarea = "program";
include($_SERVER['DOCUMENT_ROOT']."/includes/header_internal.php");

// access check: make sure logged in user has access to edit this program
// or if some user with type 3 and a different program tries to view it
if( $user_type != 3 || $user_programID != $program->getProgramID() ) 
{
?><p>You do not have access to this page.</p><? 
} else { 
?>

<h1>Program Data</h1>

<p><strong>Show Information:</strong></p>
Court Code<br />

<p><strong>Areas to allow program admins to modify:</strong></p>

Primary Program Information ( address, phone number )<br />
Common Location<br />
Locations<br />
Officers<br />
Statutes<br />
Schools<br />
Court Positions<br />
Court Locations<br />
Sentence Requirements

<?php
} // end error check

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>