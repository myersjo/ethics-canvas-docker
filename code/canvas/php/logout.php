<?php
/* Signs-out the user currently logged in */

session_start();
unset($_SESSION['userlogin']);
unset($_SESSION['canvas_id']);
unset($_SESSION['userfirstname']);
session_unset();
session_destroy();

echo 200;

?>
