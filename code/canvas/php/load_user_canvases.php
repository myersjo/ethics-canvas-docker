<?php
   /* Retrieves all the canvases created by the user passed by parameter in JSON format */

   // Retrieve user credentials
   $email = $_POST['loggedin_user_email'];

   require_once('../../php/db_utils.php');
   $conn = db_connect(); // Connect to the database

   // Check if the username already exists
   if(!($result = mysqli_query($conn, "SELECT name FROM user WHERE username = '$email'"))) {
     echo 400; // Wrong query
   }
   else if(mysqli_num_rows($result) != 1) { // User not registered or duplicated
     echo 401;
   }
   else { // User registered: retrieve canvases
     if(!($result = mysqli_query($conn, "SELECT * FROM canvas WHERE user_id = '$email'"))) {
       echo 400; // Wrong query
     }
     else { // Request accepted
       $rows = array();
       while($r = mysqli_fetch_assoc($result)) {
         $rows[] = $r;
       }
       echo json_encode($rows);
     }
   }
   mysqli_free_result($result);
   db_close($conn); // Close the database
?>
