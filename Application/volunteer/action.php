<?php

include($_SERVER['DOCUMENT_ROOT']."/includes/header.php");

?>



<?php

$name = htmlspecialchars($_POST['name']);

$page = htmlspecialchars($_POST['value']);



echo htmlspecialchars($_POST['name']);

?>



<?php

include($_SERVER['DOCUMENT_ROOT']."/includes/footer.php");

?>