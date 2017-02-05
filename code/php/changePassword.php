<?php
    require_once('db_utils.php');

    if(isset($_POST['salt'], $_POST['new-password'])) { // Parameters received
      // Get parameters
      $old_salt = $_POST['salt'];
      $password = $_POST['new-password'];

      $conn = db_connect(); // Connect to the database

      // Check if the user already exists
      if(!($result = mysqli_query($conn, "SELECT * FROM user WHERE salt = '$old_salt'"))) {
        $verification = 'false'; // Wrong query
      }

      else { // Query successful
        if(mysqli_num_rows($result) != 1) { // User doesn't exist, or duplicated
          $verification = 'false';
        }
        else { // User returned successfully
              $algorithm = '$2a'; // Blowfish
              $cost = '$10'; // for hashing
              $new_salt = $algorithm . $cost . '$' . substr(sha1(mt_rand()),0,22);
              $hash = crypt($password, $new_salt);
         
              // Update activation status
              if(!mysqli_query($conn, "UPDATE user SET salt = '$new_salt', password = '$hash' WHERE salt = '$old_salt'")) {
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

    header('Location: /index.html?changed='. $verification);
?>
