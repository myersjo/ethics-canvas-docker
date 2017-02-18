<?php
   /* Retrieves the data for the given canvas id, passed by parameter in JSON format */

   // Retrieve user credentials
   $canvas_id = $_GET['current_canvas_id'];

   require_once('../../php/db_utils.php');
   $conn = db_connect(); // Connect to the database

   // Check if the canvas exists
   if(!($result = mysqli_query($conn, "SELECT canvas_content FROM canvas_json WHERE canvas_id = '$canvas_id'"))) {
     echo 400; // Wrong query
   }
   else if(mysqli_num_rows($result) != 1) { // Canvas not found
     echo 401;
   }
   else { // Canvas exists: retrieve canvas
     $r = mysqli_fetch_object($result);
     echo ($r->canvas_content);
   }
   mysqli_free_result($result);
   db_close($conn); // Close the database
?>
