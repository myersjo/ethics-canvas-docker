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
   elseif(mysqli_num_rows($result) == 0) {
     echo 'No results ; ';
   }
   else {
     echo mysqli_num_rows($result);
     while ($row = mysqli_fetch_assoc(result)) {
       $canvas_id = $row[canvas_id];
       echo "canvas_id: $canvas_id ; canvases json: ";
       $canvases[$canvas_id] = array(
         "canvas_name" => $row[canvas_name],
         "user_id" => $row[user_id],
         "canvas_date" => $row[canvas_date],
         "tags" => array(
         )
       );
       if ($tags = mysqli_query($conn, "SELECT * FROM tag_relation WHERE canvas_id='$canvas_id'")) {
         while ($tagRow = mysqli_fetch_assoc(tags)) {
         	$canvases[$canvas_id][tags] = array(
            $tagRow[tag_name]
          );
         }
       }
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
  echo 'finished';
   mysqli_free_result($result);
   db_close($conn); // Close the database
?>
