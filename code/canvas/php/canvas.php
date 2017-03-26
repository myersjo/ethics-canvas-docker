<?php
//for the ajax post call
echo 'JSON stringified Object: '.$_POST['JSONstrObj'].' was sent to the php file\n';
//for the ajax post call in stringified object data form
$post_data = $_POST['JSONstrObj'];
$canvas_id_data = $_POST['canvas_id'];
$share_with_str = $_POST['share_with'];
$tags_str = $_POST['tags'];

$share_with = explode(" ", $share_with_str);
$tags = explode(" ", $tags_str);

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
      if (!mysqli_query($conn, "INSERT INTO canvas_json (canvas_id, canvas_content) VALUES ('$canvas_id_data', '$post_data')")) {
        echo " Post Data: ".$post_data;
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
    foreach($tags as $tag) {
      if(!($tag_insert_result = mysqli_query($conn, "INSERT INTO tags(tag_name) VALUES ('$tag') ON DUPLICATE KEY UPDATE tag_name = VALUES(tag_name)"))) {
        echo 400; // Wrong query
        echo " #Wrong insert tag query :/ ";
      }
      mysqli_free_result($tag_insert_result);
      if(!($tag_id_result = mysqli_query($conn, "SELECT id FROM tags WHERE tag_name='$tag'"))) {
        echo 400; // Wrong query
        echo " #Wrong select tag id query :/ ";
      } else if (mysqli_num_rows($tag_id_result) > 0) {
        $tagRow = mysqli_fetch_assoc($tag_id_result);
        $tag_id = $tagRow['id'];
        echo "Tag ID: ";
        echo $tag_id;
        echo "Canvas ID: ";
        echo $canvas_id_data;
        if(!($tag_rel_result = mysqli_query($conn, "INSERT INTO tag_relation(tag_id, canvas_id) VALUES('$tag_id', '$canvas_id_data') ON DUPLICATE KEY UPDATE tag_id=VALUES(tag_id), canvas_id=VALUES(canvas_id)"))) {
          echo 400; // Wrong query
          echo " #Wrong insert tag relation query :/ ";
        }
        mysqli_free_result($tag_rel_result);
      }
      mysqli_free_result($tag_id_result);
    }
    foreach($users as $user) {
      if(!($get_user_result = mysqli_query($conn, "SELECT username FROM user WHERE username='$user'"))) {
        echo 400; // Wrong query
        echo " #Wrong select user username query :/ ";
      } else if (mysqli_num_rows($get_user_result) == 0) {
        echo 401; // User doesn't exist
        echo "$user";
      } else {
        if(!($ins_user_rel_result = mysqli_query($conn, "INSERT INTO user_canvas_visibility(user_id, canvas_id) VALUES('$user', '$canvas_id_data') ON DUPLICATE KEY UPDATE user_id=VALUES(user_id), canvas_id=VALUES(canvas_id)"))) {
          echo 400; // Wrong query
          echo " #Wrong insert visibility query :/ ";
        }
        mysqli_free_result($ins_user_rel_result);
      }
      mysqli_free_result($get_user_result);
    }

    // Return canvas_id and save it in the current session
    $_SESSION['canvas_id'] = $canvas_id_data;
    echo $canvas_id_data;
}
?>
