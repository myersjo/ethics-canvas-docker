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
}
    // Close the file
    //  fclose($handle);

    require_once('../../php/db_utils.php');
    $conn = db_connect(); // Connect to the database

    // Check if the username already exists

    // Save this canvas
    if(!mysqli_query($conn, "INSERT INTO canvas_json (canvas_id, canvas_content) VALUES ('$canvas_id_data', '$post_data')")) {
      echo 400; // Wrong query
      echo " #Wrong query :/ ";
    }
    else { // Return canvas_id and save it in the current session
      $_SESSION['canvas_id'] = $canvas_id;
      echo $canvas_id;
    }
?>
