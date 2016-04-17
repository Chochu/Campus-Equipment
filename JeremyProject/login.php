<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$User = $Pass= "";
// https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
if ($_SERVER["REQUEST_METHOD"] == "POST") { //If post request was called
  /*
  if statement are use to check if the text field of the html are empty
  if they are, set the error variables to display the error
  else remove special header and set its to the variables
  */
  $username  = TrimText($_POST["username"]);
  $password = TrimText($_POST["password"]);

  //Check if the variable are empty, if they are that means that the html text-danger
  //are empty, This check prevent sql statement from executing if Name, Abb, and CampusID
  //are empty
  if($username != "" && $password != "" ){
    // Connection Data
    require 'Credential.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM account WHERE user = '".$username."';"; //set query statement

    $result = $conn->query($sql); //execute query


    if ($result->num_rows > 0) {//for each row return from the sql
      if($row = $result->fetch_assoc())// output data of each row in assoc array
      {

        if( $row['pass'] == $password){ //check if the result matched with the store hash password
          $_SESSION["id"] = $row['id']; //create session id
          $_SESSION["Username"] = $row['user']; //and set username
          header('Location: home.php'); //redirect to header , main page
        }
      }
    }
    else{
      header('Location: /index.php?msg=' . urlencode(base64_encode("Incorrect Username and Password Combination"))); //no user was found Incorrect password or username
    }

  }
}
function TrimText($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>
