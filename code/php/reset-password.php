<?php
 $params = array();
 parse_str($_POST['reset_password'], $params);

 if(!array_key_exists('email-reset-password', $params)) {
   echo 400; // Missing parameters
 }

 else {
   // Retrieve user credentials
   $email = $params['email-reset-password'];
  //  echo  $email;
   require_once('db_utils.php');
   $conn = db_connect(); // Connect to the database

   // Check if the username already exists
     if(!($result = mysqli_query($conn, "SELECT salt, name FROM user WHERE username = '$email'"))) {
       echo 400; // Wrong query
     }
     else if(mysqli_num_rows($result) != 1) { // User not registered or duplicated
          echo 401;
          }
    else { // User registered
    //
            echo 200;
            // Get user details
                  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                  $salt = $row['salt'];
                  $name = $row['name'];

                  // Reset password email
                  $resetLink = "https://ethicscanvas.org/reset.php?salt=$salt";
                  $resetEmail = "Hi $name,<br><br>We have received a request to reset your password at EthicsCanvas.org.<br><br>Please, click on the link below in order to complete the process:<br>$resetLink<br><br>Thanks,<br><br>Ethics Canvas Team";

                  // Send activation email
                  include('mailer.php');
                  smtpmailer($email, 'Password reset at ethicscanvas.org', $resetEmail, null);
   }

}

?>
