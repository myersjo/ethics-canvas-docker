  <?php
  /* Retrieves the data from the database for the search box*/

    // Retrieve query entered by user in the search box
    $query;
    if (isset($_GET['query'])) {
      $query = $_GET['query'];
    }
    else if (isset($_GET['term'])) {
      $query = $_GET['term'];
    }

    require_once('../../php/db_utils.php');
    $conn = db_connect(); // Connect to the database
  /*   $keywords = array(
        facebook,
        snapchat,
        test,
        testing
    );
  */
  $keywords;

    /********************************
    * Get keywords from canvas name *
    *********************************
    */
    if(!($result = mysqli_query($conn, "SELECT canvas_name FROM canvas WHERE canvas_name LIKE \"%$query%\" AND is_public=TRUE"))) {
      echo 400; // Wrong query
    }
    else if (mysqli_num_rows($result) > 0) {
      // get details from canvas table
      while ($row = mysqli_fetch_assoc($result)) {
        $keywords[] = $row["canvas_name"];
      }
      mysqli_free_result($result);
    }

    /********************************
    * Get keyowrds from tag names   *
    *********************************
    */
    $sql = "SELECT tag_name FROM tags WHERE tag_name LIKE '%$query%'";
     if(!($result = mysqli_query($conn, $sql))) {
        echo 400; // Wrong query
    }
    else if (mysqli_num_rows($result) > 0){
      // get canvas_id's from tag_relation table
      while ($row = mysqli_fetch_assoc($result)) {
        $keywords[] = $row["tag_name"];
      }
    }
    echo json_encode(array($canvases));
    db_close($conn); // Close the database
  ?>
