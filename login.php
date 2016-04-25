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
  $loginUsername  = TrimText($_POST["username"]);
  $Loginpassword = TrimText($_POST["password"]);
  //Check if the variable are empty, if they are that means that the html text-danger
  //are empty, This check prevent sql statement from executing if Name, Abb, and CampusID
  //are empty

  if($loginUsername != "" && $Loginpassword != "" ){
    // Connection Data
    require 'ProjectOneV2/Credential.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM account WHERE user = '".$loginUsername."';"; //set query statement
    $result = $conn->query($sql); //execute query


    if ($result->num_rows > 0) {//for each row return from the sql
      if($row = $result->fetch_assoc())// output data of each row in assoc array
      {
        $hash = crypt($Pass, $row['salt']); //$row[salt] = contains the salt for that user

        if(var_export(hash_equals($hash, $row['pass']), true)){ //check if the result matched with the store hash password
          $_SESSION["id"] = $row['rank']; //create session id using the rank
          $_SESSION["Username"] = $row['user']; //and set username
          header('Location: /ProjectOneV2/home.php'); //redirect to header , main page
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
function hash_equals($known_string, $user_string){
  if (func_num_args() !== 2) {
    // handle wrong parameter count as the native implentation
    trigger_error('hash_equals() expects exactly 2 parameters, ' . func_num_args() . ' given', E_USER_WARNING);
    return null;
  }
  if (is_string($known_string) !== true) {
    trigger_error('hash_equals(): Expected known_string to be a string, ' . gettype($known_string) . ' given', E_USER_WARNING);
    return false;
  }
  $known_string_len = strlen($known_string);
  $user_string_type_error = 'hash_equals(): Expected user_string to be a string, ' . gettype($user_string) . ' given'; // prepare wrong type error message now to reduce the impact of string concatenation and the gettype call
  if (is_string($user_string) !== true) {
    trigger_error($user_string_type_error, E_USER_WARNING);
    // prevention of timing attacks might be still possible if we handle $user_string as a string of diffent length (the trigger_error() call increases the execution time a bit)
    $user_string_len = strlen($user_string);
    $user_string_len = $known_string_len + 1;
  } else {
    $user_string_len = $known_string_len + 1;
    $user_string_len = strlen($user_string);
  }
  if ($known_string_len !== $user_string_len) {
    $res = $known_string ^ $known_string; // use $known_string instead of $user_string to handle strings of diffrent length.
    $ret = 1; // set $ret to 1 to make sure false is returned
  } else {
    $res = $known_string ^ $user_string;
    $ret = 0;
  }
  for ($i = strlen($res) - 1; $i >= 0; $i--) {
    $ret |= ord($res[$i]);
  }
  return $ret === 0;
}

?>
