<?php
 /* Receives the email of the user, the name of the canvas and the date
    and stores it in the database with a randomly-generated canvas_id,
    that is returned.                                                */
 
 session_start();
 $params = array();
 parse_str($_POST['save_canvas'], $params);

 if(!array_key_exists('email_save_canvas', $params) OR
    !array_key_exists('name_save_canvas', $params) OR
    !array_key_exists('date_save_canvas', $params) OR
    !array_key_exists('visibility', $params)) {
   echo 400; // Missing parameters
   echo ' missing params; ';
 }

 else {
   require_once('../../php/db_utils.php');
   $conn = db_connect(); // Connect to the database

   if(isset($_SESSION['canvas_id'])) {
     // Canvas already exists. Return canvas_id to overwrite JSON file.
     $canvas_id = $_SESSION['canvas_id'];
     $visibility = $params['visibility'];
     $isPublic = ($visibility === "Public")?"1":"0";
     if(!($result = mysqli_query($conn, "UPDATE canvas SET is_public='$isPublic' WHERE canvas_id='$canvas_id'"))) {
       echo 400; // Wrong query
       echo " Wrong update canvas visibility query ";
     }
     echo $_SESSION['canvas_id'];
   }

   else { // New canvas in the database

     // Retrieve user credentials
     $email = $params['email_save_canvas'];
     $canvas_name = $params['name_save_canvas'];
     $date = $params['date_save_canvas'];
     $visibility = $params['visibility'];

     $isPublic = ($visibility === "Public")?"1":"0";


     // Check if the username already exists
     if(!($result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$email'"))) {
       echo 400; // Wrong query
     }
     else if(mysqli_num_rows($result) != 1) { // User not registered or duplicated
       echo 401;
     }
     else { // User registered
       // Save this canvas
       $canvas_id = generateRandomString();
       if(!mysqli_query($conn, "INSERT INTO canvas(canvas_id, user_id, canvas_name, canvas_date, is_public) VALUES ('$canvas_id', '$email', '$canvas_name', '$date', '$isPublic')")) {
         echo 400; // Wrong query
         echo " #Wrong insert canvas query :/ ";
       }
       else { // Return canvas_id and save it in the current session
         $_SESSION['canvas_id'] = $canvas_id;
         echo $canvas_id;
       }
     }
   }
}


/* Generate a random string of a specific length to be used as canvas_id */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
