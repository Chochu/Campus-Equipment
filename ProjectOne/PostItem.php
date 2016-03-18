<!-- https://bootstrapbay.com/blog/working-bootstrap-contact-form/ -->
<!DOCTYPE HTML>
<html>
<head>

<style>
.error {color: #FF0000;}
</style>
<?php

// define variables and set to empty values
$BuildingE = $RoomE = $Item_NameE = $Item_TypeE = "";
$Building = $Room = $Item_Name = $Item_Type = $Assest_Tag = $Service_Tag = "";
$str = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["building"])) {
    $BuildingE = "Building is required";
  } else {
    $Building = test_input($_POST["building"]);
  }
  if (empty($_POST["room"])) {
    $RoomE = "Room is required";
  } else {
    $Room = test_input($_POST["room"]);
  }
  if (empty($_POST["itemname"])) {
    $Item_NameE = "Item name is required";
  } else {
    $Item_Name = test_input($_POST["itemname"]);
  }
  if (empty($_POST["itemtype"])) {
    $Item_TypeE = "Item type is required";
  } else {
    $Item_Type = test_input($_POST["itemtype"]);
  }
  if (empty($_POST["assest"])) {
    $Assest_Tag = "-1";
  } else {
    $Assest_Tag = test_input($_POST["assest"]);
  }
  if (empty($_POST["service"])) {
    $Service_Tag = "-1";
  } else {
    $Service_Tag = test_input($_POST["service"]);
  }
  $Active = $_POST["active"];

  #echo $Building . $Room . $Item_Name . $Item_Type .$Assest_Tag.$Service_Tag ;
  if($Building != "" && $Room != "" && $Item_Name != "" && $Item_Type != ""){
    // Connection Data

    require 'Credential.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    INSERT INTO inventory(Building, Room, Item_Name, Item_Type, Assest, Service, Active)
    VALUES
    ('".$Building."',
    '".$Room."',
    '".$Item_Name."',
    '".$Item_Type."',
    '".$Assest_Tag."',
    '".$Service_Tag."',
    '".$Active."')";


    if ($conn->query($sql) === TRUE) {
      $str =  "New record created successfully";
    } else {
      $str = "Error : " . $sql . "<br>" . $conn->error;
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>
<meta charset="UTF-8">
<div class="menu">
  <?php include 'header.php'; ?>
  <br><br>
</div>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
<body>



  <h2>PHP Form Validation Example</h2>
  <p><span class="error">* required field.</span></p>

  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- Building -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Building</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="building" name="building" placeholder="HSH" value="<?php echo $Building;?>">
        <?php echo "<p class='text-danger'>$BuildingE</p>";?>
      </div>
    </div>
    <!-- Room -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Room</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="room" name="room" placeholder="130" value="<?php echo $Room;?>">
        <?php echo "<p class='text-danger'>$RoomE</p>";?>
      </div>
    </div>
    <!-- Item_name -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Item Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="itemname" name="itemname" placeholder="OW-HSH-130-TS" value="<?php echo $Item_Name;?>">
        <?php echo "<p class='text-danger'>$Item_NameE</p>";?>
      </div>
    </div>
    <!-- Item_type -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Item Type</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="itemtype" name="itemtype" placeholder="PC" value="<?php echo $Item_Type;?>">
        <?php echo "<p class='text-danger'>$Item_TypeE</p>";?>
      </div>
    </div>
    <!-- Assest -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Assest</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="assest" name="assest"  placeholder="Leaving it blank will result in -1" value="<?php echo $Assest_Tag;?>">
      </div>
    </div>
    <!-- Assest -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Service</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="service" name="service"  placeholder="Leaving it blank will result in -1" value="<?php echo $Service_Tag;?>">
      </div>
    </div>

    <!-- Active -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Active</label>
      <div class="col-sm-4">
        <select name="active">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
    </div>

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
<!--
<form class="form-horizontal" role="form" method="post" action="index.php">
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Name</label>
<div class="col-sm-10">
<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="">
</div>
</div>
<div class="form-group">
<label for="email" class="col-sm-2 control-label">Email</label>
<div class="col-sm-10">
<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
</div>
</div>
<div class="form-group">
<label for="message" class="col-sm-2 control-label">Message</label>
<div class="col-sm-10">
<textarea class="form-control" rows="4" name="message"></textarea>
</div>
</div>
<div class="form-group">
<label for="human" class="col-sm-2 control-label">2 + 3 = ?</label>
<div class="col-sm-10">
<input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
</div>
</div>
<div class="form-group">
<div class="col-sm-10 col-sm-offset-2">
<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
</div>
</div>
<div class="form-group">
<div class="col-sm-10 col-sm-offset-2">
<! Will be used to display an alert to the user>
</div>
</div>
</form> -->
