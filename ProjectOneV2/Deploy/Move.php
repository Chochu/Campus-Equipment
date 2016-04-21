<?php
/*
$_Get - Someone is requesting Data from your application
$_Post - Someone is pushing (inserting/updating/deleting) data from your application
*/
header('location: Deploy.php');
exit();
?>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<?php

// define variables and set to empty values
$RoomNumE = $BuildingIDE = $CampusIDE = "";
$RoomNum = $type = $BuildingID = $CampusID = $Altname = "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['room'])) {
    $RoomNumE = "Room Number is required";
  } else {
    $RoomNum = TrimText($_POST["room"]);
  }
  // if (empty($_POST['type'])) {
  //   $type = "No ";
  // } else {
  //   $type = TrimText($_POST["abb"]);
  // }
  if (empty($_POST['altname'])) {
    $Altname = "";
  } else {
    $Altname = TrimText($_POST["altname"]);
  }
  if($_POST['ddcampusid'] == ""){
    $CampusIDE = "Must Select an Campus";
  }else {
    $CampusID = $_POST['ddcampusid'];
  }
  if($_POST['ddbuildingid'] == ""){
    $BuildingIDE = "Must Select an Campus";
  }else {
    $BuildingID = $_POST['ddbuildingid'];
  }

  #echo $Building . $Room . $Item_Name . $Item_Type .$Assest_Tag.$Service_Tag ;
  if($RoomNum != "" && $BuildingID != "" && $CampusID != ""){
    // Connection Data

    require '../Credential.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    INSERT INTO room(RoomNumber, AltName, BuildingID, CampusID)
    VALUES
    ('".$RoomNum."',
    '".$Altname."',
    '".$BuildingID."',
    '".$CampusID."')";


    if ($conn->query($sql) === TRUE) {
      $str =  "Updated record created successfully";
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

function JsontoDropdown($datapath){
  $str = file_get_contents($datapath);
  $json = json_decode($str,true);
  foreach ($json as $value){
    echo "<option value=\"".$value['id']."\">".$value['Name']."</option>";
  }
}
?>
<meta charset="UTF-8">
<div class="menu">
  <?php include '../header.php'; ?>
  <br><br>
</div>

</head>
<body>

  <h2>Insert to Room Database</h2>


  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- Name -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Room Number</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="room" name="room" placeholder="130" value="<?php echo $RoomNum;?>">
        <?php echo "<p class='text-danger'>$RoomNumE</p>";?>
      </div>
    </div>
    <!-- Altname  -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Alt Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="altname" name="altname" placeholder="Lecture Hall" value="<?php echo $Altname;?>">
      </div>
    </div>
    <!-- Campus Dropdown -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Campus</label>
      <div class="col-sm-4">
        <select name="ddcampusid">
          <option value="">...</option>
          <?php JsontoDropdown('../campus.json');?>
        </select>
        <?php echo "<p class='text-danger'>$CampusIDE</p>";?>
      </div>
    </div>
    <!-- Building Dropdown -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Building</label>
      <div class="col-sm-4">
        <select name="ddbuildingid">
          <option value="">...</option>
          <?php JsontoDropdown('../building.json');?>
        </select>
        <?php echo "<p class='text-danger'>$CampusIDE</p>";?>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <input id="submit" name="submit" type="submit" value="Submit" class="btn btn-query">
      </div>
    </div>

  </form>
  <?php
  echo "<h1>" .  $str . "</h1>";
  ?>


</body>
</html>
