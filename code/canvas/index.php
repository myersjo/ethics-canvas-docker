<?php
  session_start();
  if (isset($_SESSION['userlogin'], $_SESSION['userfirstname'])) {
    $email = $_SESSION['userlogin'];
    $name = $_SESSION['userfirstname'];
  }
  if (isset($_GET['id'])) {
    $canvas_id = $_GET['id'];
    $_SESSION['canvas_id'] = $canvas_id;
  }
  else if (isset($_SESSION['canvas_id'])) {
    $canvas_id = $_SESSION['canvas_id'];
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

            <form class="canvas-form form" action="mpdf/canvas-pdf.php" method="post" target="_blank">
                <!-- Canvas Form Header -->
                <div class="form-header row text-center">
                    <div class="col-md-3 ">
                        <!--logo -->
                        <h1 class="page_title ">
                            <a class="logo" href="../index.html">
                                <img src="icons/logo-black-text.svg" alt="Online Ethics Canvas"/>
                            </a>
                        </h1>
                    </div>
                    <div class="col-md-3  ">
                        <label class="project_title">Project Title</label>
                        <input class="proj_title" name="field_00[]" type="text"/>
                    </div>
                    <div hidden class="col-md-3  ">
 -                        <label class="project_date">Date</label>
 -                        <input class="proj_date" name="field_00[]" type="date"/>
 -                    </div>
                    <!--<p class=“text-center”>
                        <a href=“www.facebook.com”>
                            <button class= "guidelines" type="button" name="guidelines"> Guidelines pdf</button>
                        </a>
                    </p>-->
                    <!--<p class=“text-center”>
                        <a href=“../repository/index.php”>
                            <button class= "guidelines" type="button" name="guidelines"> Repository Page</button>
                        </a>
                    </p>-->
                    <!-- login coming soon -->
                    <div class="col-md-3  ">
                    <?php if (!empty($name)) { ?>

                          <!-- bootstrap dropdown component -->
                        <div class="dropdown user-profile">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <img src="../icon/profile.svg"/><span><?php echo $name; ?></span>
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a id="toGuidelines" href="../download/handbook.pdf">Guidelines</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a id="toRepository" href="../repository">Repository</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a id="toDashboard" href="php/dashboard.php">Your Canvases</a></li>
                            <!-- <li><a href="#">Something else here</a></li> -->
                            <li role="separator" class="divider"></li>
                            <li><a id="logout" href="#">Log Out</a></li>
                          </ul>
                        </div>
                    <?php } ?>
                    </div>

                </div>
            <div class="row">
                <!-- LAYOUT -->
                <!-- ================ 8/5 col=================== -->
                <div class="canvas-box">
                    <div class="masonry-layout8-5" id="8-5-col-layout">
                        <div class="masonry-layout__panel ">
                            <div class="card field_01 masonry-layout__panel-content bg--purple ">
                                <h2 class="field-title">
                                    <!-- FIELD 1 -->
                                    Individuals Affected
                                </h2>

                                <p class="intro">
                                    Relevant types of individual stakeholders affected by the project, such as men/women, user/non-user, age, category, etc.
                                </p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>

                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_01" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                        <span class=" handle glyphicon glyphicon-th"></span>
                                        <span class="glyphicon glyphicon-trash remove"></span>
                                        <textarea name="field_01[]">Item 1</textarea>

                                    </li> -->

                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea data-limit-rows="true" class="new_item expandable" rows="2" maxlength="100" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel ">
                            <div class="card field_05 masonry-layout__panel-content bg--blue">
                                <h2 class="field-title">
                                    <!-- FIELD 5 -->
                                    Changes in Behaviour
                                </h2>
                                <p class="intro">
                                    Problematic differences in behaviour such as differences in habits, time schedules, choice of activities, etc.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_05" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                        <span class=" handle glyphicon glyphicon-th"></span>
                                        <span class="glyphicon glyphicon-trash remove"></span>
                                        <textarea name="field_05[]">Item 1</textarea>

                                    </li> -->
                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->
                                <!-- the field id icons -->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel">
                            <div class="card field_06 masonry-layout__panel-content bg--green ">
                                <h2 class="field-title">
                                    <!-- Field 6 -->
                                    Changes in Relations
                                </h2>
                                <p class="intro">
                                    Problematic changes in relations between people, such ways of communication, frequency of interpersonal contact etc.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_06" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                        <span class=" handle glyphicon glyphicon-th"></span>
                                        <span class="glyphicon glyphicon-trash remove"></span>
                                        <textarea name="field_06[]">Item 1</textarea>

                                    </li> -->

                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel">
                            <div class="card field_11 masonry-layout__panel-content bg--green1 ">
                                <h2 class="field-title">
                                    <!-- Field 11 -->
                                    Social Conflicts
                                </h2>
                                <p class="intro">
                                    Possible social conflicts that could be caused by the project, such as labour conflicts, minority conflicts etc.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>

                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_11" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                        <span class=" handle glyphicon glyphicon-th"></span>
                                        <span class="glyphicon glyphicon-trash remove"></span>
                                        <textarea name="field_11[]">Item 1</textarea>
                                    </li> -->

                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel">
                            <div class="card field_12 masonry-layout__panel-content bg--darkblue">
                                <h2 class="field-title">
                                    <!-- Field 12 -->
                                    Resolving Ethical Impacts
                                </h2>
                                <p class="intro">
                                    Select the four most important ethical impacts you discussed. Discuss ways of solving these impacts by changing your project’s product/service design, organisation or by providing recommendations.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_12" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                        <span class=" handle glyphicon glyphicon-th"></span>
                                        <span class="glyphicon glyphicon-trash remove"></span>
                                        <textarea name="field_12[]">Item 1</textarea>
                                    </li> -->

                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel">
                            <div class="card field_07 masonry-layout__panel-content bg--green">
                                <h2 class="field-title">
                                    <!-- Field 7 -->
                                    Group Interests
                                </h2>
                                <p class="intro">
                                    Relevant ethical interests that other groups might have in your project; such as environmental, privacy, justice interests.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_07" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                      <span class=" handle glyphicon glyphicon-th"></span>
                                      <span class="glyphicon glyphicon-trash remove"></span>
                                      <textarea name="field_07[]">Item 1</textarea>
                                  </li> -->
                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel">
                            <div class="card field_08 masonry-layout__panel-content bg--seagreen">
                                <h2 class="field-title">
                                    <!-- Field 8 -->
                                    Public Sphere
                                </h2>
                                <p class="intro">
                                    How the general perception of somebody’s role in society can be affected by the project, e.g. people behaving more individualistic or collectivist, people behaving more or less materialistic.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_08" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                      <span class=" handle glyphicon glyphicon-th"></span>
                                      <span class="glyphicon glyphicon-trash remove"></span>
                                      <textarea name="field_08[]">Item 1</textarea>
                                  </li> -->
                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel ">
                            <div class="card field_02 masonry-layout__panel-content bg--purple ">
                                <h2 class="field-title">
                                    <!-- Field 2 -->
                                    Organisations and Groups Affected
                                </h2>
                                <p class="intro">
                                    Relavant collective stakeholders that can be affected by your project, such as environmental and religious groups, competing companies and government agencies; considering any interest they might have in the effects of the project.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_02" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                      <span class=" handle glyphicon glyphicon-th"></span>
                                      <span class="glyphicon glyphicon-trash remove"></span>
                                      <textarea name="field_02[]">Item 1</textarea>
                                  </li> -->
                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>

                    </div>

                    <!-- ================ 4 col ==================== -->
                    <div class="masonry-layout4 " id="4-col-layout">
                        <div class="masonry-layout__panel ">
                            <div class="card field_03 masonry-layout__panel-content bg--seagreen ">
                                <h2 class="field-title">
                                    <!-- Field 3 -->
                                    Products and Services provided
                                </h2>
                                <p class="intro">
                                    Discuss the different types of products and services that your project will provide.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_03" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                      <span class=" handle glyphicon glyphicon-th"></span>
                                      <span class="glyphicon glyphicon-trash remove"></span>
                                      <textarea name="field_03[]">Item 1</textarea>
                                  </li> -->
                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel">
                            <div class="card field_09 masonry-layout__panel-content bg--blue ">
                                <h2 class="field-title">
                                    <!-- Field 9 -->
                                    Impact of Product or Service Failure
                                </h2>
                                <p class="intro">
                                    Negative impacts of failure of your products or services such as technical failure, human failure, etc.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_09" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                      <span class=" handle glyphicon glyphicon-th"></span>
                                      <span class="glyphicon glyphicon-trash remove"></span>
                                      <textarea name="field_09[]">Item 1</textarea>
                                  </li> -->
                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel ">
                            <div class="card field_10 masonry-layout__panel-content bg--green ">
                                <h2 class="field-title">
                                    <!-- Field 10 -->
                                    Impact of Resource Consumption
                                </h2>
                                <p class="intro">
                                    Possible negative impacts of the consumption of resources of your project, e.g. climate impacts, privacy impacts, employment impacts.</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_10" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                      <span class=" handle glyphicon glyphicon-th"></span>
                                      <span class="glyphicon glyphicon-trash remove"></span>
                                      <textarea name="field_10[]">Item 1</textarea>
                                  </li> -->
                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->
                            </div>
                            <!-- end of .card -->
                        </div>
                        <div class="masonry-layout__panel ">
                            <div class="card field_04 masonry-layout__panel-content bg--green1 ">
                                <h2 class="field-title">
                                    <!-- Field 4 -->
                                    Resources Needed
                                </h2>
                                <p class="intro">
                                    The consumption of energy or raw materials, but also about the consumption of human resources for your project</p>
                                <!-- Into text toggler -->
                                <button type="button" class="intro-toggle">
                                    <!-- glyphicon glyphicon-minus-sign -->
                                    <span class="intro-toggle-icon glyphicon glyphicon-minus-sign"></span>
                                    <span class="intro-toggle-text">Hide description</span>
                                </button>
                                <!-- Item list in the field -->
                                <!-- the ul id is used in js code to give the right name attribute to the added cards (user input) -->
                                <ul id="field_04" class="item_list sortable connectedList">
                                    <!-- html format of the added items:  -->
                                    <!-- <li class="added_item">
                                      <span class=" handle glyphicon glyphicon-th"></span>
                                      <span class="glyphicon glyphicon-trash remove"></span>
                                      <textarea name="field_04[]">Item 1</textarea>
                                  </li> -->
                                </ul>
                                <!-- The Box With All User input Things -->
                                <div class="add_box">
                                    <!--  # Add idea link   -->
                                    <a class="add-idea" href="#">
                                        Add an idea
                                    </a>
                                    <!--  # User Input   -->
                                    <div class="user-input">
                                        <label>Your Idea</label><br>
                                        <p>
                                            <textarea class="new_item expandable" rows="2" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="new_item" placeholder="Write an idea here ..."></textarea>
                                        </p>
                                        <p class="chars-count">
                                            <span class="chars">100</span>
                                            characters remaining</p>
                                        <button type="button" class="add_btn">Add</button>
                                    </div>
                                    <!-- end of user input -->
                                </div>
                                <!-- end of add_box-->

                            </div>
                            <!-- end of .card -->
                        </div>
                    </div>
                </div>
                <!-- end of .canvas.box -->
            </div>

                <!-- FORM BUTTON BOX -->
                <?php if (!empty($name))  { ?>
                
                   
                <br>
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <div class="temp-space panel">
                            <div class="border">
                                <div class="panel-heading">
                                    <h4> Temporary</h4>
                                </div>
                            </div>
                            <div class="border">
                                <div class="panel-body">
                                    <p class="intro">If you do not know which canvas use, put your idea in this canvas</p>
                                    <label>Your Idea</label><br>
                                    <p>
                                        <textarea class="new_item expandable" rows="3" maxlength="100" data-limit-rows="true" data-autoresize type="text" name="temp-space" id="temp-space" placeholder="Write an idea here ..."></textarea>
                                    </p>
                                    <!--<a href="#" class="btn btn-default">Add</a>-->
                                    
                                </div> <!-- End of class="panel-body" -->
                            </div> <!-- End of class="border" -->
                        </div> <!-- End of class="panel" -->
                    </div>
                    <div class="col-md-5">
                        <div class="tags">
                            <label for="tags">
                                <h4>Tags: </h4>
                                <input type="text" name="tags" id="tags" title="Enter tags" placeholder="Enter tags..."/>
                            </label>
                            <h4>Visibility Settings: </h4>
                            <label for="Public"><input type="radio" name="privacy" value="Public" id="Public" title="Select if you would like to share canvas to repository" checked="checked"/>Public</label><br><br>
                            <br>
                            <label for="Private"><input type="radio" name="privacy" value="Private" id="Private" title="Select if you would not like to share canvas" />Private</label>
                            <br>
                            <p id="share-with-users">
                                <label for="share-with">Enter the email addresses of users you would like to share with:</label><br><br>
                                <input type="text" id="share-with" name="share-with" value="" placeholder="Enter email addresses..."><br>
                            </p>
                        </div>
                    </div>
                </div> <!-- end of row -->
                <?php } ?>
                   
                
                   

                <div class="row">

                    <div class="imp-exp-btn col-md-4 col-md-offset-4">

                        <!-- form buttons -->


                        <?php if (!empty($name)) { ?>

                            <p class="text-center">
                            <!-- Export JSON and also save the canvas for the registered user -->
                              <button class="json_exp" type="button" name="json_exp">Save This Canvas</button>
                              <br>
                              <br>
                            </p>
				
 
                        <!-- BEGIN SHARE CANVAS -->
                        <p class="text-center">
                          <button class="share_canvas" type="submit" name="share-canvas">Share This Canvas</button>
                        </p>
                        <div class="share_canvas_email text-center">
                          <p>
                            <label>Send this canvas to:</label>
                          </p>
                          <p>
                            <input type="email" name="share-canvas-email" placeholder="type an email adress here..."/>
                          </p>
                          <p class="text-center">
                            <button class="share_canvas_send" type="button" name="share-canvas-send">Send</button>
                          </p>
                        </div>
                       <!-- END SHARE CANVAS -->


                        <?php } else{?>

                          <p class="text-center">
                            <!-- Export JSON and also save the canvas for the registered user -->
                              <a class="login-to-save"  href="../index.html">Sign up or login to save your canvas</a>
				
                          </p>
                        <?php }?>


                        <!-- BEGIN EXPORT PDF -->
                        <p class="text-center">
                          <input class="pdf_exp" type="submit" name="export-pdf" value="Download as PDF">
                        </p>
                        <!-- END EXPORT PDF -->

			
                        
                    </div>

                </div>

            </form>
            <!-- end of .form -->
            <!-- hidden place to show JSON info -->
            <pre id="result" class="text-center">

             </pre>

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
