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
  /*   $canvases = array(
      "canvas_id" => array (
        "canvas_name" => 'Test 2',
        "user_id" => 'jord@live.ie',
        "canvas_date" => '2017-01-02',
        "tags" => array(
          'test',
          'testing'
        )
      )
    );
  */
  $canvases;

    /***************************
    * Search canvases by name *
    ****************************
    */
    if(!($result = mysqli_query($conn, "SELECT * FROM canvas WHERE canvas_name LIKE \"%$query%\" AND is_public=TRUE"))) {
      echo 400; // Wrong query
    }
    else if (mysqli_num_rows($result) > 0) {
      // get details from canvas table
      while ($row = mysqli_fetch_assoc($result)) {
        $canvas_id = $row["canvas_id"];
        $canvases[$canvas_id] = array(
          "canvas_name" => $row["canvas_name"],
          "user_id" => $row["user_id"],
          "canvas_date" => $row["canvas_date"]
        );
      }
      mysqli_free_result($result);
      // get tags for each canvas from tag_relation table
      foreach($canvases as $canvas_id => $canvas) {
        if (($tags = mysqli_query($conn, "SELECT tags.tag_name as tag_name FROM tag_relation INNER JOIN tags ON tag_relation.tag_id=tags.id WHERE tag_relation.canvas_id='$canvas_id'"))) {
          $tagsArr = array();
          while ($tagRow = mysqli_fetch_assoc($tags)) {
            array_push($tagsArr, $tagRow["tag_name"]);
          }
          $canvases[$canvas_id]["tags"] = $tagsArr;
        }
        else {
          echo 400; // Query error
        }
        mysqli_free_result($tags);
      }
    }

    /***************************
    * Search canvases by tag   *
    ****************************
    */
    $sql = "SELECT DISTINCT tag_relation.canvas_id as canvas_id FROM tag_relation INNER JOIN tags ON tag_relation.tag_id=tags.id WHERE tags.tag_name LIKE '%$query%'";
     if(!($result = mysqli_query($conn, $sql))) {
        echo 400; // Wrong query
    }
    else if (mysqli_num_rows($result) > 0){
      // get canvas_id's from tag_relation table
      while ($row = mysqli_fetch_assoc($result)) {
        $canvas_id = $row["canvas_id"];

        if(!array_key_exists($canvas_id, $canvases)) {  // if canvas not already in $canvases[]
          if(!($details = mysqli_query($conn, "SELECT * FROM canvas WHERE canvas_id='$canvas_id' AND is_public=TRUE"))) { // get canvas details if canvas public
            echo 400; // Wrong query
          } 
          else if (mysqli_num_rows($details) > 0) {  // add details to $canvases[]
            if ($detailsRow = mysqli_fetch_assoc($details)) {
              $canvases[$canvas_id] = array(
                "canvas_name" => $detailsRow["canvas_name"],
                "user_id" => $detailsRow["user_id"],
                "canvas_date" => $detailsRow["canvas_date"]
              );
            }
          }
          mysqli_free_result($details);
        }
      }
      mysqli_free_result($result);
      // get tags for each canvas from tag_relation table
      foreach($canvases as $canvas_id => $canvas) {
        if(count($canvas[tags]) <= 0) {
          if (($tags = mysqli_query($conn, "SELECT tags.tag_name as tag_name FROM tag_relation INNER JOIN tags ON tag_relation.tag_id=tags.id WHERE tag_relation.canvas_id='$canvas_id'"))) {
            $tagsArr = array();
            while ($tagRow = mysqli_fetch_assoc($tags)) {
              array_push($tagsArr, $tagRow["tag_name"]);
            }
            $canvases[$canvas_id]["tags"] = $tagsArr;
          }
          else {
            echo 400; // Query error
          }
        }
        mysqli_free_result($tags);
      }
    }
    echo json_encode(array($canvases));
    db_close($conn); // Close the database
  ?>
