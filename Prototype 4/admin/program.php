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

<p>Areas to allow program admins to modify:</p>

 common location<br />
 locations<br />
 officers<br />
 statutes<br />
 schools<br />
 court positions<br />
 court locations

<?php
} // end error check

include($_SERVER['DOCUMENT_ROOT']."/includes/footer_internal.php");
?>