<?php


/* Connect to the MySQL database */
function db_connect() {

  include('config.php');
  if(isset($db_host, $db_username, $db_password, $db_name)) {
    // Create connection to database
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
      echo 4004; // Unsuccessful connection to database
    }
  }
  else { // Connection variables not set
    echo 4005; // Respond with bad-request code
  }

  return $conn;
}


/* Closes the connection to the database */
function db_close($conn) {
  $conn->close();
}

?>
