<?php
//for the ajax post call
echo 'JSON stringified Object: '.$_POST['JSONstrObj'].' was sent to the php file\n';
//for the ajax post call in stringified object data form
$post_data = $_POST['JSONstrObj'];
$canvas_id_data = $_POST['canvas_id'];

$filename ='../json/'.$canvas_id_data.'.json';
$handle = fopen($filename, "w");

if (empty($post_data)) {
    echo 'Hmm... I did NOT get any data posted by AJAX.';
}
if (!empty($post_data)) {
  echo 'Awesome! got the json info :)';
    //$dir = 'YOUR-SERVER-DIRECTORY/files';
    //$file = uniqid().getmypid();
    //$filename = $dir.$file.'.txt';
     // Write to file
    fwrite($handle, $post_data);
}
    // Close the file
     fclose($handle);
?>
