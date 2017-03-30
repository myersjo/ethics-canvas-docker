<?php
  session_start();
  if (isset($_SESSION['userlogin'], $_SESSION['userfirstname'])) {
    $email = $_SESSION['userlogin'];
    $name = $_SESSION['userfirstname'];
    if (isset($_GET['id'])) {
        $canvas_id = $_GET['id'];
        $_SESSION['canvas_id'] = $canvas_id;
    }
    else if (isset($_SESSION['canvas_id'])) {
      $canvas_id = $_SESSION['canvas_id'];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Brainstorm about the ethical implications of your project and represent them in a canvas.">
        <meta name="keywords" content="ethics canvas, ethics, social entrepreneurship, research, innovation, privacy, business development, business model canvas, open source tools">
        <title>The Ethics Canvas</title>

        <!-- favicons -->
        <link rel="icon" href="../icon/favicon.ico"/>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <!-- App style -->
        <link rel="stylesheet" type="text/css" href="css/canvas.css">

        <!-- php variables have to be retieved here as js variables -->
        <script type="text/javascript">
          var email_save_canvas = '<?php echo $email; ?>';
          var user_save_canvas = '<?php echo $name; ?>';
          var current_canvas_id = '<?php echo $canvas_id; ?>';
        </script>

    </head>
    <body>

        <div class="container-fluid">
            <div class="row">
                <div class = "col-12-md">
                    <h1>Oops!</h1>
                    <?php if (!empty($name)) { ?>
                        <p>Sorry <?php echo $name; ?>, you do not have permission to view this canvas.</p>
                        <p>To view this canvas, ask the creator to share it with you</p>
                     <?php } else{?>
                        <p>You do not have permission to view this canvas.</p>
                        <p>To view this canvas, <a href="../index.html/">log into</a> your account and ensure the creator has shared it with you</p>
                    <?php }?>
                </div>
            </div>

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
                         <li><img src="../icon/by.large.png" alt="ethics-canvas-by-icon"/> </li>
                            <li><img src="../icon/share.large.png" alt="ethics-canvas-share-icon"/> </li>
                         <li><img src="../icon/cc.large.png" alt="ethics-canvas-cc-icon"/> </li>
                         <li> <img src="../icon/remix.large.png" alt="ethics-canvas-remix-icon"/></li>
                         <li> <img src="../icon/sa.large.png" alt="ethics-canvas-sa-icon"/></li>
                       </ul>
                     </div>
                      <p class="ethics-copy terms"><a href="../privacy-terms/terms.html">Terms of Service</a></p>
                      <p class="ethics-copy privacy"><a href="../privacy-terms/privacy.html">Privacy Policy</a></p>

                    <p class="ethics-copy">The ADAPT Centre for Digital Content Technology</p> <p class="ethics-copy">is funded under the SFI Research Centres Programme (Grant 13/RC/2106).</p><p class="ethics-copy">It is co-funded under the European Regional Development Fund.</p>
                    <p class="ethics-copy">Ethics Canvas v1.7|&copy; ADAPT Center & Trinity College Dublin & Dublin City University, 2016</p>
                </footer>
            </div>
        </div>
        <!-- end of container-fluid -->


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <!-- jquery UI  -->
        <script src="https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js" integrity="sha256-55Jz3pBCF8z9jBO1qQ7cIf0L+neuPTD1u7Ytzrp2dqo=" crossorigin="anonymous"></script>
        <!-- Bootstrap -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <!-- The app javascript -->
        <script src="js/canvas.js" charset="utf-8"></script>
        <script language="javascript" type="text/javascript"></script>

    </body>

</html>
