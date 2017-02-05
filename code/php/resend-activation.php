<?php
  $params = array();
  parse_str($_POST['email_resend'], $params);

  if(!array_key_exists('email-login', $params)) {
    echo 400; // Missing parameters
  }
  else {
    //the name attribute of the input field is email-login
    $email = $params['email-login'];
    require_once('db_utils.php');
    $conn = db_connect(); // Connect to the database

    // Check if the username already exists
    if(!($result = mysqli_query($conn, "SELECT salt, name FROM user WHERE username = '$email'"))) {
      echo 400; // Wrong query
    }
    else {
      if(mysqli_num_rows($result) != 1) { // User not registered or duplicated
        echo 401;
      }
      else { // User registered
        // Get user details
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $salt = $row['salt'];
        $name = $row['name'];

        // Activation email
        $activationLink = "https://ethicscanvas.org/activation.php?salt=$salt";
        $activationEmail = "Hi $name,<br><br>Thanks for signing up at EthicsCanvas.org.<br><br>Please, click on the link below in order to verify you email address:<br>$activationLink<br><br>Thanks,<br><br>Ethics Canvas Team";

        // Send activation email
        include('mailer.php');
        smtpmailer($email, 'Email verification required at ethicscanvas.org', $activationEmail, null);
        echo 200;
      }
    }

    mysqli_free_result($result);
    db_close($conn); // Close the database
  }
?>
