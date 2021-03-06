<?php
session_start();

if (isset($_GET['current_canvas_id'])) {
  $canvas_id = $_GET['current_canvas_id'];
  $_SESSION['canvas_id'] = $canvas_id;

  $user_id;
  if (isset($_SESSION['userlogin'])) {
    $user_id = $_SESSION['userlogin'];
  }
  else {
      $user_id = '';
  }

  require_once('../../php/db_utils.php');
  $conn = db_connect(); // Connect to the database

  if(!($result = mysqli_query($conn, "SELECT * FROM canvas WHERE canvas_id = '$canvas_id'"))) {
     echo 400; // Wrong query
   }
   else if (mysqli_num_rows($result) < 1) {
    echo 400;
   } else {
       $visiblity = mysqli_fetch_assoc($result);
        if (($visiblity["is_public"] == 1) || ($visiblity["user_id"] == $user_id)) {
            echo 200; // Canvas is public or user is canvas creator
        } else {
            if(!($usersRes = mysqli_query($conn, "SELECT user_id FROM user_canvas_visibility WHERE canvas_id = '$canvas_id'"))) {
                echo 400; // Wrong query
            }
            else if (mysqli_num_rows($usersRes) < 1) {
                // unset($_SESSION['canvas_id']);
                echo 401;
            }
            else {
                while ($user = mysqli_fetch_assoc($usersRes)) {
                    if ($user['user_id'] == $user_id) {
                        echo 200;
                        return;
                    }
                }
                // unset($_SESSION['canvas_id']);
                echo 401; // If this line is reached, user is not permitted to view the canvas
            }
            mysqli_free_result($usersRes);
        }
   }
   mysqli_free_result($result);
}
else {
  echo 401;
}
?>