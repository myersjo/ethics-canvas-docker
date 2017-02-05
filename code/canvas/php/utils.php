<?php
session_start();

if (isset($_POST['canvas_ID'])) {
  $canvas_id = $_POST['canvas_ID'];
  $_SESSION['canvas_id'] = $canvas_id;
  echo 200;
}
else
  echo 401;
?>
