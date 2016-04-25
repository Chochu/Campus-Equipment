<?php
//populate campus dropdown
function listcampusDropdown(){
  require '../Credential.php';//load the path
  $str = file_get_contents($JsonCampus); //load text from file
  $json = json_decode($str,true);//decode to json var
  foreach ($json as $value){//loop through json
    echo "<option value=\"".$value['id']."\">".$value['Name']."</option>";//add option value to dropdown
  }
}

//remove special char to prevent sql injection
function TrimText($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//this function is use for set the value of the html text from "get request"
//User doesnt have retype everything out
function getPost($string){
  if( array_key_exists($string,$_GET)){
    echo replacepercent($_GET[$string]);
  }
  else{
    echo "";
  }
}

//replace space character with % (used when passing var to html link)
function replacepercent($string){
  return str_replace("%"," ",$string);
}

function replaceSpace($string){
  return str_replace(" ","%",$string);
}

function isRanked($page){
  require 'Credential.php';
  $sql = "SELECT $page FROM nyit.groupp where id = (select rank from nyit.account where user = '".$_SESSION['Username']."');";
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $result = $conn->query($sql); //executed statement

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // get result of the executed statement
    if ($row[$page] == '0') { //if the user group privilege is 0
      return "<script>window.location = \"../home.php?error=Error:%Not%Enough%Privilege\";</script>";
    }
    elseif ($row[$page] == '1') {
      return;
    }
    else{
      return "<script>window.location = \"../home.php?error=Error:Cannot%Find%Privilege%Level\";</script>";
    }
  }
}
?>
