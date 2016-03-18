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
$IdE = $NameE = $AbbE = $AddressE = $CountryE = $StateE = $ZipE = "";
$Id = $Name = $Abb = $Address = $Country = $State = $Zip = "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["id"])) {
    $IdE = "ID is required";
  } else {
    $Id = TrimText($_POST["id"]);
  }
  if (empty($_POST["name"])) {
    $NameE = "Name is required";
  } else {
    $Name = TrimText($_POST["name"]);
  }
  if (empty($_POST["abb"])) {
    $AbbE = "Abb is required";
  } else {
    $Abb = TrimText($_POST["abb"]);
  }
  if (empty($_POST["address"])) {
    $AddressE = "Address is required";
  } else {
    $Address = TrimText($_POST["address"]);
  }
  if (empty($_POST["state"])) {
    $StateE = "State is required";
  } else {
    $State = TrimText($_POST["state"]);
  }
  if (empty($_POST["zip"])) {
    $ZipE = "Zip code is required";
  } else {
    $Zip = TrimText($_POST["zip"]);
  }
  if (empty($_POST["country"])) {
    $CountryE = "State is Required";
  } else {
    $Country = TrimText($_POST["country"]);
  }
  // $Active = $_POST["active"];
  #echo $Building . $Room . $Item_Name . $Item_Type .$Assest_Tag.$Service_Tag ;
  if($Id != "" && $Name != "" && $Abb != "" && $Address != "" && $Country != "" && $State != "" && $Zip != ""){
    // Connection Data

    require '../Credential.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    UPDATE campus SET
    Name = '".$Name."',
    Abb = '".$Abb."',
    Address = '".$Address."',
    State = '".$Country."',
    Zip = '".$State."',
    Country ='".$Zip."'
    WHERE
    id = ".$Id;

    if ($conn->query($sql) === TRUE) {
      $str =  "Updated record created successfully";
      exec('python ../Script/UpdateCampusJson.py');
    } else {
      $str = "Error : " . $sql . "<br>" . $conn->error;
    }
  }
}

function TrimText($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function getPost($string){
  if( array_key_exists($string,$_GET)){
    echo replaceSpace($_GET[$string]);
  }
  else{
    echo "";
  }
}
function replaceSpace($string){
  return str_replace("%"," ",$string);
}
?>
<meta charset="UTF-8">
<div class="menu">
  <?php include 'header.php'; ?>
  <br><br>
</div>

</head>
<body>

  <h2>Update Campus id: <?php getPost("id"); ?></h2>
  <p><span class="error">* required field.</span></p>

  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- id -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">ID</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="id" name="id" placeholder="0" value="<?php getPost("id");?>">
        <?php echo "<p class='text-danger'>$IdE</p>";?>
      </div>
    </div>
    <!-- Name -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="name" name="name" placeholder="Old Westbury" value="<?php  getPost("Name");?>">
        <?php echo "<p class='text-danger'>$NameE</p>";?>
      </div>
    </div>
    <!-- Abb -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Abb</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="abb" name="abb" placeholder="OW" value="<?php  getPost("Abb");?>">
        <?php echo "<p class='text-danger'>$AbbE</p>";?>
      </div>
    </div>
    <!-- Address  -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Address</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="address" name="address" placeholder="Northern Blvd, Old Westbury" value="<?php  getPost("Address");?>">
        <?php echo "<p class='text-danger'>$AddressE</p>";?>
      </div>
    </div>
    <!-- State -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">State</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="state" name="state"  placeholder="NY" value="<?php  getPost("State");?>">
        <?php echo "<p class='text-danger'>$StateE</p>";?>
      </div>
    </div>
    <!-- Zip -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Zip Code</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="zip" name="zip"  placeholder="11568" value="<?php  getPost("Zip");?>">
        <?php echo "<p class='text-danger'>$ZipE</p>";?>
      </div>
    </div>
    <!-- Country -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Country</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="country" name="country" placeholder="USA" value="<?php  getPost("Country");?>">
        <?php echo "<p class='text-danger'>$CountryE</p>";?>
      </div>
    </div>
    <!-- Active -->
    <!-- <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Active</label>
      <div class="col-sm-4">
        <select name="active">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
    </div> -->
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <input id="submit" name="submit" type="submit" value="Submit" class="btn btn-primary">
      </div>
    </div>

  </form>
  <?php
  echo "<h1>" .  $str . "</h1>";
  ?>


</body>
</html>
