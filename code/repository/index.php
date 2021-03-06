<?php
  session_start();
  if (isset($_SESSION['userlogin'], $_SESSION['userfirstname'])) {
    $email = $_SESSION['userlogin'];
    $name = $_SESSION['userfirstname'];
    if (isset($_SESSION['canvas_id'])) {
      $canvas_id = $_SESSION['canvas_id'];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Ethics Canvas</title>

        <!-- favicons -->
        <link rel="icon" href="../icon/favicon.ico"/>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- jQuery UI -->
        <link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css">
        <!-- Font Awesome -->
        <script src="https://use.fontawesome.com/f05ce90ed7.js"></script>
        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <!-- Slick Carousel Theme style (Creates a basic layout)-->
        <link rel="stylesheet" type="text/css" href="../css/slick-theme.css">
        <!-- HomePage Style -->
        <link rel="stylesheet" type="text/css" href="../css/landing.css">
        <!-- Custom CSS -->
        <link href="css/repository.css" rel="stylesheet" type="text/css">
        <!-- php variables have to be retieved here as js variables -->
        <script type="text/javascript">
          var email_save_canvas = '<?php echo $email; ?>';
          var user_save_canvas = '<?php echo $name; ?>';
          var current_canvas_id = '<?php echo $canvas_id; ?>';
        </script>
    </head>

    <body>

      <!-- Navigation -->
       <nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../index.html">
              <img src="../canvas/icons/logo-black-text.svg" alt="Ethics Canvas"/>
            </a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navbar-collapse">
              <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="../index.html">Home</a>
                </li>
                <?php if (!empty($name)) { ?>
                  <li class="dropdown" id="logged-in-dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $name; ?> <b class="caret"></b></a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                          <li><a id="toGuidelines" href="../download/handbook.pdf">Guidelines</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a id="toRepository" href="../repository">Repository</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a id="toDashboard" href="../canvas/php/dashboard.php">Your Canvases</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a id="logout" href="#">Log Out</a></li>
                        </ul>
                  </li>
                 <?php } ?>
              </ul>
          </div>
          <!-- /.navbar-collapse -->
        </div>
      </nav> <!-- End of navbar-->

      <!-- Page Content -->
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-12" href="#">
              <img src="../canvas/icons/pdf/logo-canvas-noText.png" alt="Ethics Canvas"/>
              <h1 class="page-header" >
                   Canvas<br>Repository
              </h1>
          </div>
          <div class="col-md-12">
            <p>
              Search for a canvas or browse the featured canvases below.
            </p>
          </div>
        </div>

        <!--Search Box -->
        <div class="row">
          <div class="col-lg-6 col-lg-offset-3">
              <form class="log-in-form search-box" action="search.php" method="get">
                  
                <div class="input-group">
                  <input type="text" autocomplete="off" class="form-control" id="search-box-input" placeholder="Enter a keyword..">
                  <span class="input-group-btn">
                      <div class="btn-group">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Popular <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a onclick="choose('Life')" href="#">Life</a></li>
                            <li><a onclick="choose('Work')" href="#">Work</a></li>
                            <li><a onclick="choose('Family')" href="#">Family</a></li>
                          </ul>
                        </div>
                    <button class="btn btn-default" type="submit" id="search-go-btn" name="search"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                        </button>
                      
                  </span>
                </div><!-- /input-group -->
              </form>
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <h2 id="content-heading">Featured Canvases</h2>
          </div>
        </div>
        <div class="row" id="canvases-row">
          <div class="col-md-4">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h4><i class="fa fa-fw fa-th"></i> Featured Canvas 1</h4>
                  </div>
                  <div class="panel-body">
                      <p>Name:</p>
                      <p>Username:</p>
                      <p>Tags:</p>
                      <a href="#" class="btn btn-default">View</a>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h4><i class="fa fa-fw fa-th"></i> Featured Canvas 2</h4>
                  </div>
                  <div class="panel-body">
                      <p>Name:</p>
                      <p>Username:</p>
                      <p>Tags:</p>
                        
                      <a href="#" class="btn btn-default">View</a>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h4><i class="fa fa-fw fa-th"></i> Featured Canvas 3</h4>
                  </div>
                  <div class="panel-body">
                      <p>Name:</p>
                      <p>Username:</p>
                      <p>Tags:</p>
                      <a href="#" class="btn btn-default">View</a>
                  </div>
              </div>
          </div>
        </div>

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
      </div> <!-- end of outer container-fluid -->

      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
      <!-- jquery UI  -->
      <script src="https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js" integrity="sha256-55Jz3pBCF8z9jBO1qQ7cIf0L+neuPTD1u7Ytzrp2dqo=" crossorigin="anonymous"></script>
      <!-- Bootstrap -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
      <!-- The app javascript -->
      <script src="js/repository.js" charset="utf-8"></script>
  </body>

</html>
