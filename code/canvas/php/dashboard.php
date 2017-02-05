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
                <div class="container-fluid user-dashboard">

                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                      <!--logo -->
                      <h1 class="page_title ">
                          <a class="logo" href="../../index.html">
                              <img src="../icons/logo-black-text.svg" alt="Online Ethics Canvas"/>
                          </a>
                      </h1>
                  </div>
                   <div class="row ">
                     <div class="user-bar col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center">
                        <img src="../../icon/profile.svg"/><span class="welcome-user">Welcome, </span><span class="user-name"><?php echo $name; ?></span>
                     </div>
                   </div>
                   <div class="row ">
                     <div class="create-new-canvas col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2 text-center">
                        <button class="dashbord-logout-btn">Log out</button>
                      </div>
                    </div>
                   <div class="row ">
                     <div class="create-new-canvas col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2 text-center">
                        <p>


                          <a class="create-canvas-btn " href="../index.php"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Create a new canvas</a>
                        </p>
                     </div>
                   </div>
                   <div class="row ">
                     <div class="user-canvases-intro text-center col-md-6 col-md-offset-3 ">
                        <h2 >Your canvases</h2>
                        <p> The Canvases that you create are shown here</p>
                     </div>
                    </div>
                     <div class="row user-canvas-gallery">
                     <!-- canvas gallery elements would be dynamically created by jQuery -->
                     <!-- <div class="canvas-gallery-item col-md-4 col-sm-6 text-center">
                       <div  class="col-md-12 color0">
                          <h3>Canvas Title</h3>
                          <p>created: <span>2016/09/14</span></p>
                        </div>
                     </div>
                   -->

                 </div>
<!-- end of .user-canvas-gallery -->
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
                                 <li><img src="../../icon/by.large.png" alt="ethics-canvas-by-icon"/> </li>
                                    <li><img src="../../icon/share.large.png" alt="ethics-canvas-share-icon"/> </li>
                                 <li><img src="../../icon/cc.large.png" alt="ethics-canvas-cc-icon"/> </li>
                                 <li> <img src="../../icon/remix.large.png" alt="ethics-canvas-remix-icon"/></li>
                                 <li> <img src="../../icon/sa.large.png" alt="ethics-canvas-sa-icon"/></li>
                               </ul>
                             </div>
                              <p class="ethics-copy terms"><a href="../../privacy-terms/terms.html">Terms of Service</a></p>
                              <p class="ethics-copy privacy"><a href="../../privacy-terms/privacy.html">Privacy Policy</a></p>


                            <p class="ethics-copy">The ADAPT Centre for Digital Content Technology</p>
                            <p class="ethics-copy">is funded under the SFI Research Centres Programme (Grant 13/RC/2106).</p>
                            <p class="ethics-copy">It is co-funded under the European Regional Development Fund.</p>
                            <p class="ethics-copy">Ethics Canvas v1.7|&copy; ADAPT Center & Trinity College Dublin & Dublin City University, 2016</p>
                        </footer>
                    </div>
                    <!-- end of footer .row -->
                </div>
                <!-- end of container-fluid -->

                <!-- add jquery -->
                <script src="https://code.jquery.com/jquery-3.0.0.min.js" integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>

                <!-- The dashboard javascript -->
                <script src="../js/dashboard.js" charset="utf-8"></script>


            </body>

        </html>

<?php }
    }
  }
?>
