<?php
  session_start();
  if (isset($_SESSION['userlogin'])) {
    $email = $_SESSION['userlogin'];
    unset($_SESSION['canvas_id']);
    require_once('../../php/db_utils.php');
    $conn = db_connect(); // Connect to the database

    // Check if the username exists
    if(($result = mysqli_query($conn, "SELECT name FROM user WHERE username = '$email'"))) {
      // Check that there is only one user with this email
      if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $name = $row['name'];
        $_SESSION['userfirstname'] = $name;
      }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Ethics Canvas</title>

        <!-- favicons -->
        <link rel="icon" href="../../icon/favicon.ico"/>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <!-- App style -->
        <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
        <!-- retieving the user's email sent by php, as a js variable               -->
        <script language="javascript" type="text/javascript">
          var loggedin_user_email = '<?php echo $email; ?>';
        </script>
    </head>

    <body>
      <div class="navbar">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
                  <!--logo -->
                  <h1 class="page_title text-center">
                      <a class="logo " href="index.html">
                          <img src="icon/logo.svg" alt="Online Ethics Canvas"/>
                      </a>
                  </h1>
                  <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                  <li>
                    <a href="~/">Home</a>
                  </li>
                </ul>
            </div>
          </div>
        </div>
      </div> <!-- End of navbar-->

      <div class="container-fluid">

        <!--Search Box -->
        <div class="row">
          <div class="col-lg-6">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Enter a keyword..">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->

        <!-- FOOTER -->
        <div class="row">
          <footer class="col-md-12 text-center">
            <div class="contact">
              <h2>Contact us:</h2>
              <p> hello@ethicscanvas.org  </p>
            </div>
              <div class="license">
                  <p>The Ethics Canvas is adapted from Alex Osterwalder’s Business Model Canvas.</p>
                  <p>The Business Model Canvas is designed by: Business Model Foundry AG.
                  </p>
                  <p>
                      This work is licensed under the Creative Commons Attribution-Share Alike 3.0 unported license.</p>
                    <p class="cc"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> View a copy of this license on:</p>
                  <p>
                    <a href="https://creativecommons.org/licenses/by-sa/3.0/">creativecommons.org</a>

                  </p>
                  <p class="bmc"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
                      View the original Business Model Canvas on:
                  </p>
                  <p>
                    <a href="https://strategyzer.com/canvas">strategyzer.com</a>
                  </p>
              </div>
               <div class="license-icons">
                 <ul>
                   <li><img src="icon/by.large.png" alt="ethics-canvas-by-icon"/> </li>
                      <li><img src="icon/share.large.png" alt="ethics-canvas-share-icon"/> </li>
                   <li><img src="icon/cc.large.png" alt="ethics-canvas-cc-icon"/> </li>
                   <li> <img src="icon/remix.large.png" alt="ethics-canvas-remix-icon"/></li>
                   <li> <img src="icon/sa.large.png" alt="ethics-canvas-sa-icon"/></li>
                 </ul>
               </div>
                <p class="ethics-copy terms"><a href="privacy-terms/terms.html">Terms of Service</a></p>
                <p class="ethics-copy privacy"><a href="privacy-terms/privacy.html">Privacy Policy</a></p>

                <p class="ethics-copy">The ADAPT Centre for Digital Content Technology</p> <p class="ethics-copy">is funded under the SFI Research Centres Programme (Grant 13/RC/2106).</p><p class="ethics-copy">It is co-funded under the European Regional Development Fund.</p>
                <p class="ethics-copy">Ethics Canvas v1.7|&copy; ADAPT Center & Trinity College Dublin & Dublin City University, 2016</p>
          </footer>
        </div>
      </div> <!-- end of outer container-fluid -->

      <!-- add jquery -->
      <script src="https://code.jquery.com/jquery-3.0.0.min.js" integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>
      <!-- jquery UI  -->
      <script src="https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js" integrity="sha256-55Jz3pBCF8z9jBO1qQ7cIf0L+neuPTD1u7Ytzrp2dqo=" crossorigin="anonymous"></script>

      <!-- Mailchimp Script-->
      <script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script>
      <script type="text/javascript">
          (function($) {
              window.fnames = new Array();
              window.ftypes = new Array();
              fnames[0] = 'EMAIL';
              ftypes[0] = 'email';
              fnames[1] = 'FNAME';
              ftypes[1] = 'text';
              fnames[2] = 'LNAME';
              ftypes[2] = 'text';
          }(jQuery));
          var $mcj = jQuery.noConflict(true);
      </script>

      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
      <!-- Bootstrap -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

      <!-- The Slick Carousel jQuery plugin (slider) -->
      <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
      <!-- The app javascript -->
      <script src="js/landing.js" charset="utf-8"></script>
  </body>

</html>
