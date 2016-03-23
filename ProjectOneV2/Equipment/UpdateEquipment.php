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
$IdE = $EquipmentTypeIDE = $NameE = $ActiveE= "";
$Id =  $EquipmentTypeID = $Asset = $Serial = $Active =  "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST['EquipID'])) {
    $EquipmentTypeIDE = "Equipment Type ID is required";
  } else {
    $EquipmentTypeID = TrimText($_POST["EquipID"]);
  }
  if (empty($_POST['name'])) {
    $NameE = "Equipment Type ID is required";
  } else {
    $Name = TrimText($_POST["name"]);
  }
  if (empty($_POST['active'])) {
    $ActiveE = "Please pick one";
  } else {
    $Active = TrimText($_POST["active"]);
  }
  $Asset =TrimText($_POST["Asset"]);
  $Serial = TrimText($_POST["Serial"]);

  if($EquipmentTypeID != ""){

    require '../Credential.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    UPDATE equipment SET
    Name = '".$Name."',
    equipmenttype = '".$EquipmentTypeID."',
    Asset = '".$Asset."',
    Serial = '".$Serial."',
    Active = '".$Active."'
    WHERE
    id = ".$Id;

    if ($conn->query($sql) === TRUE) {
      $str =  "Updated record created successfully";
    } else {
      $str = "Error : " . $sql . "<br>" . $conn->error;
    }
  }

}
function listcampusDropdown(){
  $str = file_get_contents('campus.json');
  $json = json_decode($str,true);
  foreach ($json as $value){
    echo "<option value=\"".$value['id']."\">".$value['Name']."</option>";
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
function JsontoDropdown($datapath){
  $str = file_get_contents($datapath);
  $json = json_decode($str,true);
  foreach ($json as $value){
    echo "<option value=\"".$value['id']."\">".$value['Make']. " " .$value['Model']."</option>";
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

  <h2>Update Equipement id: <?php getPost("id"); ?></h2>
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
        <input type="text" class="form-control" id="name" name="name" value="<?php  getPost("Name");?>">
        <?php echo "<p class='text-danger'>$NameE</p>";?>
      </div>
    </div>
    <!-- Equip Type Dropdown -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Equip Type</label>
      <div class="col-sm-4">
        <select name="EquipID">
          <option value="">...</option>
          <?php JsontoDropdown('../Script/JSON/EquipType.json');?>
        </select>
        <?php echo "<p class='text-danger'>$NameE</p>";?>
      </div>
    </div>
    <!-- Asset -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Asset</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="Asset" name="Asset" value="<?php  getPost("Asset");?>">
      </div>
    </div>
    <!-- Serial -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Serial</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="Serial" name="Serial" value="<?php getPost("Serial");?>">
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Active</label>
      <div class="col-sm-4">
        <input type="radio" name="active" value="1"> Yes
        <input type="radio" name="active" value="0"> No
        <?php echo "<p class='text-danger'>$ActiveE</p>";?>
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
