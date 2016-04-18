<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$User = $Pass = $Pass2 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { //If post request was called
  /*
  if statement are use to check if the text field of the html are empty
  if they are, set the error variables to display the error
  else remove special header and set its to the variables
  */
  $User = TrimText($_POST["username"]);
  $Pass = TrimText($_POST["password"]); //currently theres not requirement for password
  $Pass2 = TrimText($_POST["confirm-password"]);

  if ($Pass != $Pass2){
    header('Location: /index.php?msg=' . urlencode(base64_encode("Password doesnt match")));
  }

  //Check if the variable are empty, if they are that means that the html text-danger
  //are empty, This check prevent sql statement from executing if Name, Abb, and CampusID
  //are empty
  if($User != "" && ($Pass == $Pass2) && $Pass != ""){

    // Connection Data
    require 'ProjectOneV2/Credential.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // A higher "cost" is more secure but consumes more processing power
    $cost = 10;

    // Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

    // Prefix information about the hash so PHP knows how to verify it later.
    // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf("$2a$%02d$", $cost) . $salt;

    // Value:
    // $2a$10$eImiTXuWVxfM37uY4JANjQ==

    // Hash the password with the salt
    $hash = crypt($Pass, $salt);

    // Value:
    // $2a$10$eImiTXuWVxfM37uY4JANjOL.oTxqp7WylW7FCzx2Lc7VLmdJIddZq

    $sql = "
    INSERT INTO account(user,pass,salt)
    VALUES
    ('".$User."',
    '".$hash."',
    '".$salt."')";


    // get result of the executed statement
    if ($conn->query($sql) === TRUE) { //if success
      header('Location: /index.php?msg=' . urlencode(base64_encode("Successfully Created an Account"))); //redirect to login page with message
    } else {
      header('Location: /index.php?msg=' . urlencode(base64_encode("There's was an error creating an account, most likely there was an account with that user name")));//redirect to login page with message
    }
  }
}
function TrimText($data) {//remove special char to prevent sql injection
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
