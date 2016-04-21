<?php
/*
$_Get - Someone is requesting Data from your application
$_Post - Someone is pushing (inserting/updating/deleting) data from your application
*/
?>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<?php

// define variables and set to empty values
$IdE = $MakeE = $ModelE = $TypeE = "";
$Id = $Make = $Model = $Type = $Description = "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//If post request was called
  /* similar structure to Insert Building, with an extra field called id
  if statement are use to check if the text field of the html are empty
  if they are, set the error variables to display the error
  else remove special header and set its to the variables
  */
  if (empty($_POST["id"])) {
    $IdE = "ID is required";
  } else {
    $Id = TrimText($_POST["id"]);
  }
  if (empty($_POST["make"])) {
    $MakeE = "Make is required";
  } else {
    $Make = TrimText($_POST["make"]);
  }
  if (empty($_POST["model"])) {
    $ModelE = "Model is required";
  } else {
    $Model = TrimText($_POST["model"]);
  }
  if (empty($_POST["type"])) {
    $TypeE = "Type is required";
  } else {
    $Type = TrimText($_POST["type"]);
  }

  //Check if the variable are empty, if they are that means that the html text-danger
  //are empty, This check prevent sql statement from executing if Name, Abb, and CampusID
  //are empty
  if($Make != "" && $Model != "" && $Type != ""){
    // Connection Data

    require '../Credential.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $Description = $conn -> real_escape_string($_POST["description"]);

    $sql = "
    UPDATE equipmenttype SET
    Make = '".$conn -> real_escape_string($Make)."',
    Model = '".$conn -> real_escape_string($Model)."',
    Type = '".$conn -> real_escape_string($Type)."',
    Description ='".$Description."'
    WHERE
    id = ".$Id;

    // get result of the executed statement
    if ($conn->query($sql) === TRUE) {//if success
      //set result variable
      $str =  "Updated record created successfully";
      //run python Script to update json in Script/Json folder
      exec('python ../Script/UpdateEquipTypeJson.py');
    } else {
      $str = "Error : " . $sql . "<br>" . $conn->error;
    }
  }
}

//remove special char to prevent sql injection
function TrimText($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function loadDescrip($id){
  if( array_key_exists($id,$_GET)){
    require '../Credential.php'; //load Credential for Sql login
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $exe = "SELECT Description FROM equipmenttype where id =".$_GET[$id].";";

    //execute sql
    $result = $conn->query($exe);
    //for each row return from the sql
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      echo $row['Description'];
    }
  }


}
//Used for set the value of the html text from get request,
//User doesnt have retype everything out
function getPost($string){
  if( array_key_exists($string,$_GET)){
    echo replaceSpace($_GET[$string]);
  }
  else{
    echo "";
  }
}

//replace % with space
function replaceSpace($string){
  return str_replace("%"," ",$string);
}
?>
<meta charset="UTF-8">
<div class="menu">
  <?php include '../header.php'; ?>
  <br><br>
</div>

</head>
<body>

  <h2>Update Equipment Type id: <?php getPost("id"); ?></h2>


  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- id -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">ID</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="id" name="id" placeholder="0" value="<?php getPost("id");?>">
        <?php echo "<p class='text-danger'>$IdE</p>";?>
      </div>
    </div>
    <!-- Make -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Make</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="make" name="make" placeholder="Dell" value="<?php getPost("Make");?>">
        <?php echo "<p class='text-danger'>$MakeE</p>";?>
      </div>
    </div>
    <!-- Model -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Model</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="model" name="model" placeholder="Optiplex 7010" value="<?php getPost("Model");?>">
        <?php echo "<p class='text-danger'>$ModelE</p>";?>
      </div>
    </div>
    <!-- Type  -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Type</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="type" name="type" placeholder="PC" value="<?php getPost("Type");?>">
        <?php echo "<p class='text-danger'>$TypeE</p>";?>
      </div>
    </div>
    <!-- Description -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Description</label>
      <div class="col-sm-4">
        <textarea name="description" rows="5" cols="40" id="description" name="description"><?php loadDescrip("Description");?></textarea>
      </div>
    </div>

    <!-- Sumbit Button -->
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <input id="submit" name="submit" type="submit" value="Submit" class="btn btn-query">
      </div>
    </div>

  </form>
  <?php
  echo "<h1>" .  $str . "</h1>";//use to display result
  ?>


</body>
</html>
