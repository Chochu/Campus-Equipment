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
$IdE = $NameE = $AbbE = $CampusIDE = $Altname= "";
$Id = $Name = $Abb = $CampusID = "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["id"])) {
    $IdE = "ID is required";
  } else {
    $Id = TrimText($_POST["id"]);
  }
  if (empty($_POST['name'])) {
    $NameE = "Name is required";
  } else {
    $Name = TrimText($_POST["name"]);
  }
  if (empty($_POST['abb'])) {
    $AbbE = "Abb is required";
  } else {
    $Abb = TrimText($_POST["abb"]);
  }
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
  // $Active = $_POST["active"];
  #echo $Building . $Room . $Item_Name . $Item_Type .$Assest_Tag.$Service_Tag ;
  if($Name != "" && $Abb != "" && $CampusID != ""){
    // Connection Data

    require '../Credential.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    UPDATE building SET
    Name = '".$Name."',
    Abb = '".$Abb."',
    CampusID = '".$CampusID."',
    AltName = '".$Altname."'
    WHERE
    id = ".$Id;

    if ($conn->query($sql) === TRUE) {
      $str =  "Updated record created successfully";
      exec('python ../Script/UpdateBuildingJson.py');
    } else {
      $str = "Error : " . $sql . "<br>" . $conn->error;
    }
  }
}
function listcampusDropdown(){
  require '../Credential.php';
  $str = file_get_contents($JsonCampus);
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

  <h2>Update Building id: <?php getPost("id"); ?></h2>
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
        <input type="text" class="form-control" id="name" name="name" placeholder="Anna Rubin" value="<?php  getPost("Name");?>">
        <?php echo "<p class='text-danger'>$NameE</p>";?>
      </div>
    </div>
    <!-- Abb -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Abb</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="abb" name="abb" placeholder="AARH" value="<?php  getPost("Abb");?>">
        <?php echo "<p class='text-danger'>$AbbE</p>";?>
      </div>
    </div>
    <!-- Alt Name  -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Alt Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="altname" name="altname" placeholder="300 Building" value="<?php  getPost("AltName");?>">
      </div>
    </div>
    <!-- Drop Down -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Campus</label>
      <div class="col-sm-4">
        <select name="ddcampusid">
          <option value="">...</option>
          <?php listcampusDropdown();?>
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
