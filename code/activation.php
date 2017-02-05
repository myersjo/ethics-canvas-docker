<?php
    require_once('php/db_utils.php');


    if(isset($_GET['salt'])) { // Parameter received
      $salt = $_GET['salt']; // Get parameter

      $conn = db_connect(); // Connect to the database

      // Check if the user already exists
      if(!($result = mysqli_query($conn, "SELECT * FROM user WHERE salt = '$salt'"))) {
        $verification = 'false'; // Wrong query

      }

      else { // Query successful
        if(mysqli_num_rows($result) != 1) { // User doesn't exist, or duplicated
          $verification = 'false';


        }
        else { // User returned successfully
          // Update activation status
          if(!mysqli_query($conn, "UPDATE user SET activated = TRUE WHERE salt = '$salt'")) {
             $verification = 'false'; // Wrong query

          }
          else { // Update successful
            $verification = 'true';

          }
        }
      }
      mysqli_free_result($result);
      db_close($conn); // Close the database
    }
    else { // Salt not been sent as parameter
      $verification = 'false';


    }

    header('Location: /index.html?verification='. $verification);
?>
