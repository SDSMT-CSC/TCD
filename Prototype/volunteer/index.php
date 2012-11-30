<?php
$pagename = "volunteer";
include($_SERVER['DOCUMENT_ROOT']."/includes/header.php");
?>

<form action="action.php" method="get">
 <p>Volunteer 1 <input type="button" name="select" value="Set Hours" id="volunteer1"/> <input type="button" name="select" value="Edit Volunteer" id="volunteer1"/></p>
 <p>Volunteer 2 <input type="button" name="select" value="Set Hours" id="volunteer2"/> <input type="button" name="select" value="Edit Volunteer" id="volunteer2"/></p>
</form>

<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/footer.php");
?>