<?php
  /* Regists a new user unless it already exists in the database */

  $params = array();
  parse_str($_POST['sign_up_data'], $params);

  if(!array_key_exists('firstname-signup', $params) || !array_key_exists('email-signup', $params) || !array_key_exists('password-signup', $params)) {
    echo 400; // Missing parameters
  }
  else {
    // Generate user credentials
    $name = $params['firstname-signup'];
    $email = $params['email-signup'];
    $password = $params['password-signup'];
    $algorithm = '$2a'; // Blowfish
    $cost = '$10'; // for hashing
    $salt = $algorithm . $cost . '$' . substr(sha1(mt_rand()),0,22);
    $hash = crypt($password, $salt);

    // Activation email
    $activationLink = "https://ethicscanvas.org/activation.php?salt=$salt";
    $activationEmail = "Hi $name,<br><br>Thanks for signing up at EthicsCanvas.org.<br><br>Please, click on the link below in order to verify you email address:<br>$activationLink<br><br>Thanks,<br><br>Ethics Canvas Team";

    require_once('db_utils.php');
    include('mailer.php');
    $conn = db_connect(); // Connect to the database

    // Check if the username already exists
    if(!($result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$email'"))) {
      echo 400; // Wrong query
    }
    else {
      if(mysqli_num_rows($result) > 0) { // User already registered - not allow
        echo 401;
      }
      else {
        // Register the new user
        if(!mysqli_query($conn, "INSERT INTO user (username, password, name, salt) VALUES ('$email', '$hash', '$name', '$salt')")) {
          echo 400; // Wrong query
        }
        else {
          smtpmailer($email, 'Welcome to ethicscanvas.org', $activationEmail, null);
          echo 201;
        }
      }
    }

    mysqli_free_result($result);
    db_close($conn); // Close the database
  }
?>
