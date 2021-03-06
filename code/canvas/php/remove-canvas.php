<?php
 /* Removes the canvas passed by parameter, prior check that it
    belongs to the user currently logged in                    */
 session_start();

 if(!isset($_POST['remove_canvas_ID'], $_SESSION['userlogin'])) {
   echo 400; // Missing parameters
   echo "Missing parameters";
 }
 else {
   // Retrieve user credentials
   $canvas_id = $_POST['remove_canvas_ID'];
   $email = $_SESSION['userlogin'];

   require_once('../../php/db_utils.php');
   $conn = db_connect(); // Connect to the database

   // Check if the canvas exists and belongs to the current user
   if(!($result = mysqli_query($conn, "SELECT canvas_id FROM canvas WHERE canvas_id = '$canvas_id' AND user_id = '$email'"))) {
      echo 400; // Wrong query
      echo " Wrong select canvas query ";
   }
   else if(mysqli_num_rows($result) != 1) { // User not registered or duplicated
      echo 401;
   }
   else { // Canvas exists: delete canvas
     if(!mysqli_query($conn, "DELETE FROM tag_relation WHERE canvas_id='$canvas_id'")) {
       echo 400; // Wrong query
       echo " Wrong delete from tag_relation query ";
     }
     if(!mysqli_query($conn, "DELETE FROM canvas WHERE canvas_id='$canvas_id'")) {
       echo 400; // Wrong query
       echo " Wrong delete from canvas query ";
     }
     if(!mysqli_query($conn, "DELETE FROM canvas_json WHERE canvas_id = '$canvas_id'")) {
       echo 400; // Wrong query
       echo " Wrong delete from canvas_json query ";
     }
    //  else { // Canvas successfully deleted: remove json file
    //    unlink("../json/$canvas_id.json");
    //    echo 200;
    //  }
   }

   mysqli_free_result($result);
   db_close($conn); // Close the database
}

?>
