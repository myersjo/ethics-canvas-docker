<?php
//for the ajax post call
echo 'JSON stringified Object: '.$_POST['JSONstrObj'].' was sent to the php file\n';
//for the ajax post call in stringified object data form
$post_data = $_POST['JSONstrObj'];
$canvas_id_data = $_POST['canvas_id'];

// $filename ='../json/'.$canvas_id_data.'.json';
// $handle = fopen($filename, "w");

if (empty($post_data)) {
    echo 'Hmm... I did NOT get any data posted by AJAX.';
}
if (!empty($post_data)) {
  echo 'Awesome! got the json info :)';
    //$dir = 'YOUR-SERVER-DIRECTORY/files';
    //$file = uniqid().getmypid();
    //$filename = $dir.$file.'.txt';
     // Write to file
    // fwrite($handle, $post_data);
    // Close the file
    //  fclose($handle);

    require_once('../../php/db_utils.php');
    $conn = db_connect(); // Connect to the database

    // Save this canvas
    if(!($result = mysqli_query($conn, "SELECT * FROM canvas_json WHERE canvas_id='$canvas_id_data'"))) {
      echo 400; // Wrong query
      echo " #Wrong query :/ ";
    }
    else if (mysqli_num_rows($result) != 1) { // Canvas has not yet been saved
      if (!mysqli_query($conn, "INSERT INTO canvas_json (canvas_id, canvas_content) VALUES ('$canvas_id_data', $post_data)")) {
        echo mysqli_error($result);
        echo 400; // Wrong query
        echo " #Wrong insert query :/ ";
      }
    }
    else { // Update previously saved canvas
      if (!mysqli_query($conn, "UPDATE canvas_json SET canvas_content='$post_data' WHERE canvas_id='$canvas_id_data'")) {
        echo 400; // Wrong query
        echo " #Wrong update query :/ ";
      }
    }
    // Return canvas_id and save it in the current session
    $_SESSION['canvas_id'] = $canvas_id;
    echo $canvas_id;
}
?>
