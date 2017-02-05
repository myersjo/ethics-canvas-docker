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
        else { // User returned successfully ?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon -->
        <link rel="icon" href="icon/favicon.ico"/>

        <title>Online Ethics Canvas|Reset Your Password</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

        <link rel="stylesheet" type="text/css" href="css/landing.css">
    </head>
    <body>

        <div class="container-fluid">
            <div class="row">
                <div class=" new-password col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                  <div class="form-new-password-feedback "></div>
                    <form class="new-password-form" method="post" action="php/changePassword.php">
                      <h1>Get A New Password</h1>
                        <p>
                            <label for="new-password">New Password</label>
                        </p>
                        <p>
                            <input type="password" name="new-password" id="new-password" required/>
                        </p>
                        <div class="form-message" id="new-password-message1"></div>
                        <p>
                            <label for="new-password-conf">Confirm Password</label>
                        </p>
                        <p>
                            <input type="password" name="new-password-conf" id="new-password-conf" required/>
                        </p>
                        <div class="form-message" id="new-password-message2"></div>
                        <input type="hidden" name="salt" id="salt" value="<?php print "$salt" ?>"/>
                    <p>
                       <button class="new-pass-btn" name="password-change" type="submit">Done!</button>
                    </p>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of outer container-fluid -->


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

        <!-- The app javascript -->
        <script src="js/reset.js" charset="utf-8"></script>
    </body>

</html>


<?php   }
      }
      mysqli_free_result($result);
      db_close($conn); // Close the database
    }
    else { // Salt not been sent as parameter
      $verification = 'false';
    }
?>
