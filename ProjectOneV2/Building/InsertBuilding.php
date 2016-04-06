<?php
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
$NameE = $AbbE = $CampusIDE = $Altname= "";
$Name = $Abb = $CampusID = "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { //If post request was called
  /*
  if statement are use to check if the text field of the html are empty
  if they are, set the error variables to display the error
  else remove special header and set its to the variables
  */
  if (empty($_POST['name'])) {
    $NameE = "Name is required"; //$NameE is set when the id field is empty
  } else {
    $Name = TrimText($_POST["name"]);//else remove speical character and set it $Name
  }

  if (empty($_POST['abb'])) {
    $AbbE = "Abb is required";
  } else {
    $Abb = TrimText($_POST["abb"]);
  }

  if (empty($_POST['altname'])) {
    //Alt name doesnt have a error variables, so if it is empty, nothing will happen
    $Altname = "";
  } else {
    $Altname = TrimText($_POST["altname"]);
  }

  if($_POST['ddcampusid'] == ""){
    $CampusIDE = "Must Select an Campus";
  }else {
    $CampusID = $_POST['ddcampusid'];
  }

  //Check if the variable are empty, if they are that means that the html text-danger
  //are empty, This check prevent sql statement from executing if Name, Abb, and CampusID
  //are empty
  if($Name != "" && $Abb != "" && $CampusID != ""){

    // Connection Data
    require '../Credential.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    INSERT INTO building(Name, Abb, CampusID, AltName,Active)
    VALUES
    ('".$Name."',
    '".$Abb."',
    '".$CampusID."',
    '".$Altname."','1')";

    // get result of the executed statement
    if ($conn->query($sql) === TRUE) { //if success
      //set result variable
      $str =  "Updated record created successfully";
      //run python Script to update json in Script/Json folder
      exec('python ../Script/UpdateBuildingJson.py');
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

//populate campus dropdown
function listcampusDropdown(){
  require '../Credential.php'; //load the path
  $str = file_get_contents($JsonCampus); //load text from file
  $json = json_decode($str,true);//decode to json var
  foreach ($json as $value){//loop through json
    echo "<option value=\"".$value['id']."\">".$value['Name']."</option>"; //add option value to dropdown
  }
}
?>

<div class="menu">
  <?php include 'header.php'; //load menu
  ?>
  <br><br>
</div>

</head>
<body>

  <h2>Insert to Building Database</h2>
  <p><span class="error">* required field.</span></p>

  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- Name -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="name" name="name" placeholder="Anna Rubin" value="<?php echo $Name;?>">
        <?php echo "<p class='text-danger'>$NameE</p>";?>
      </div>
    </div>
    <!-- Abb -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Abb</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="abb" name="abb" placeholder="AARH" value="<?php echo $Abb;?>">
        <?php echo "<p class='text-danger'>$AbbE</p>";?>
      </div>
    </div>
    <!-- Altname  -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Alt Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="altname" name="altname" placeholder="300 Building" value="<?php echo $Altname;?>">
      </div>
    </div>
    <!-- Campus Dropdown -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Campus</label>
      <div class="col-sm-4">
        <select name="ddcampusid">
          <option value="">...</option>
          <?php listcampusDropdown();?>
        </select>
        <?php echo "<p class='text-danger'>$CampusIDE</p>";?>
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
  echo "<h1>" .  $str . "</h1>"; //use to display result
  ?>
</body>
</html>
