<?php
/*
$_Get - Someone is requesting Data from your application
$_Post - Someone is pushing (inserting/updating/deleting) data from your application
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<?php

// define variables and set to empty values
$MakeE = $ModelE = $TypeE = "";
$Make = $Model = $Type = $Description = "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//If post request was called
  /*
  if statement are use to check if the text field of the html are empty
  if they are, set the error variables to display the error
  else remove special header and set its to the variables
  */
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

    $sql = "
    INSERT INTO equipmenttype(Make, Model, Type, Description)
    VALUES
    ('".$Make."',
    '".$Model."',
    '".$Type."',
    '".$Description."')";

    // get result of the executed statement
    if ($conn->query($sql) === TRUE) {//if success
      //set result variable
      $str =  "New record created successfully";
      //run python Script to update json in Script/Json folder
      exec('python ../Script/UpdateCampusJson.py');
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
?>
<meta charset="UTF-8">
<div class="menu">
  <?php include 'header.php';  //load menu?>
  <br><br>
</div>

</head>
<body>

  <h2>Insert to Campus Database</h2>
  <p><span class="error">* required field.</span></p>

  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- Make -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="name" name="name" placeholder="Old Westbury" value="<?php echo $Name;?>">
        <?php echo "<p class='text-danger'>$NameE</p>";?>
      </div>
    </div>
    <!-- Model -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Abb</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="abb" name="abb" placeholder="OW" value="<?php echo $Abb;?>">
        <?php echo "<p class='text-danger'>$AbbE</p>";?>
      </div>
    </div>
    <!-- Type  -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Address</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="address" name="address" placeholder="Northern Blvd, Old Westbury" value="<?php echo $Address;?>">
        <?php echo "<p class='text-danger'>$AddressE</p>";?>
      </div>
    </div>
    <!-- Description -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">State</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="state" name="state"  placeholder="NY" value="<?php echo $State;?>">
        <?php echo "<p class='text-danger'>$StateE</p>";?>
      </div>
    </div>
    
    <!-- Sumbit Button -->
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <input id="submit" name="submit" type="submit" value="Submit" class="btn btn-primary">
      </div>
    </div>

  </form>
  <?php
  echo "<h1>" .  $str . "</h1>";//use to display result
  ?>


</body>
</html>
