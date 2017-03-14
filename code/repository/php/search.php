  <?php

    // Retrieve user credentials
    $query = $_GET['query'];

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
    // Search canvases by name
    if(!($result = mysqli_query($conn, "SELECT * FROM canvas WHERE canvas_name LIKE \"%$query%\""))) {
      echo 400; // Wrong query
    }
    else {
      // $canvases = mysqli_fetch_all($result);
      while ($row = mysqli_fetch_assoc($result)) {
        $canvas_id = $row["canvas_id"];
        $canvases[$canvas_id] = array(
          "canvas_name" => $row["canvas_name"],
          "user_id" => $row["user_id"],
          "canvas_date" => $row["canvas_date"],
          // "tags" => array(
          // )
        );
      }
      mysqli_free_result($result);
      foreach($canvases as $canvas_id => $canvas) {
        if (($tags = mysqli_query($conn, "SELECT tags.tag_name as tag_name FROM tag_relation INNER JOIN tags ON tag_relation.tag_id=tags.id WHERE tag_relation.canvas_id='$canvas_id'"))) {
          // echo ' here ; ';
          $tagsArr = array();
          while ($tagRow = mysqli_fetch_assoc($tags)) {
            array_push($tagsArr, $tagRow["tag_name"]);
          }
          // $canvases[$canvas_id]["tags"] = mysqli_fetch_array($tags);
          $canvases[$canvas_id]["tags"] = $tagsArr;
        }
        else { 
          // echo ' else here ; ';
          echo mysqli_error($conn);
        }
        mysqli_free_result($tags);
      }
      echo json_encode($canvases);
    }

    // Search canvases by tags
  /*   if(!($result = mysqli_query($conn, "SELECT * FROM tags WHERE tag_name LIKE '%$query%'"))) {
        echo 400; // Wrong query
    }
    else {
        while ($row = mysqli_fetch_assoc(result)) {
            $canvas_id = $row[canvas_id];
            $canvases[$canvas_id] = array(
                "canvas_name" => $row[canvas_name],
                "user_id" => $row[user_id],
                "canvas_date" => $row[canvas_date],
                "tags" => array(
                )
            );
            if ($tags = mysqli_query($conn, "SELECT * FROM tag_relation WHERE canvas_id='$canvas_id'")) {

            }
      }
  }
  */
    db_close($conn); // Close the database
  ?>
