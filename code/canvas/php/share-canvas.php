<?php
  /* Receives a recipient email address and sends him a previously generated
     canvas in PDF on behalf of the user that is signed in */

  session_start();
  if(!isset($_POST['share_email']) || !isset($_SESSION['userlogin'])) {
    // Recipient or sender emails not present
    echo 400;
  }
  else {
    $params = array();
    parse_str($_POST['share_email'], $params);
    if(!array_key_exists('share-canvas-email', $params)) {
      echo 400; // Missing parameters
    } 
    else { // All parameters received  
      $senderEmail = $_SESSION['userlogin'];
      $recipientEmail = $params['share-canvas-email'];
      $path = "../saved-pdf/Ethics-Canvas.pdf";
      require_once('../../php/db_utils.php');
      $conn = db_connect(); // Connect to the database

      if(!($result = mysqli_query($conn, "SELECT name FROM user WHERE username = '$senderEmail'"))) {
        echo 400; // Wrong query
      }
      else if(mysqli_num_rows($result) != 1) { // User not registered or duplicated
        echo 401;
      }
      else { // Share canvas
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $senderName = $row['name']; 
    
        // Share canvas email
        $shareEmail = "Hello,<br><br>$senderName ($senderEmail) wanted to share with you the attached Ethics Canvas generated at <a href='https://ethicscanvas.org' target='_new'>EthicsCanvas.org</a>.<br><br>Kind regards,<br><br>Ethics Canvas Team";

        // Send activation email
        include('../../php/mailer.php');
        smtpmailer($recipientEmail, "$senderName shared this Ethics Canvas with you", $shareEmail, $path);
        echo 200;
      }

      mysqli_free_result($result);
      db_close($conn); // Close the database
    }
  } 
?>
