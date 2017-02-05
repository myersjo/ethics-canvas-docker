<?php
  /* Authenticates the user or returns error if the credentials are not correct */

  $params = array(); 
  parse_str($_POST['sign_in_data'], $params);

  if(!array_key_exists('email-login', $params) || !array_key_exists('password-login', $params)) {
    echo 400; // Missing parameters
  }
  else {
    // Retrieve user credentials
    $email = $params['email-login'];
    $password = $params['password-login'];

    require_once('db_utils.php');
    $conn = db_connect(); // Connect to the database

    // Check if the username already exists
    if(!($result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$email'"))) {
      echo 400; // Wrong query
    }
    else {
      if(mysqli_num_rows($result) != 1) { // User not registered or duplicated
        echo 401;
      }
      else {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        $activated = $row['activated'];
        if($activated == FALSE)
          echo 402; // Email not activated
        else { // Email verified
          $hash = $row['password'];
          $full_salt = substr($hash, 0, 29);
          $new_hash = crypt($password, $full_salt);
          if ($hash == $new_hash) {
            session_start(); // Start session for this user
            $_SESSION['userlogin'] = $email; // Save email in the session
            echo 200; // Authentication successful
          }
  	  else
            echo 401; // Wrong username or password
        }
      }
    }

    mysqli_free_result($result);
    db_close($conn); // Close the database
  } 
?>
