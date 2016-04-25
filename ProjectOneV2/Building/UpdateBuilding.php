<html>
<head>
<div class="menu">
  <?php include '../header.php'; ?>
  <br><br>
</div>

<?php
require '../Credential.php';
include "../globalphpfunction.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo isRanked("gUpdate");


// define variables and set to empty values
$IdE = $NameE = $AbbE = $CampusIDE = $Altname= "";
$Id = $Name = $Abb = $CampusID = "";
$str = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") { //If post request was called
  /* similar structure to Insert Building, with an extra field called id
  if statement are use to check if the text field of the html are empty
  if they are, set the error variables to display the error
  else remove special header and set its to the variables
  */
  if (empty($_POST["id"])) {
    $IdE = "ID is required"; //idE is set when the id field is empty
  } else {
    $Id = TrimText($_POST["id"]); //else remove speical character and set it Id
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
    require '../Credential.php';//load Credential for sql login
    // Connection Data
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

    // get result of the executed statement
    if ($conn->query($sql) === TRUE) {//if success
      //set result variable
      $str =  "Updated record created successfully";
      //run python Script to update json in Script/Json folder
      exec('python ../Script/UpdateBuildingJson.py');
    } else {
      $str = "Error : " . $sql . "<br>" . $conn->error; //
    }
  }
}


?>
</head>
<body>
  <div class="container">
    <h2>Update Building id: <?php getPost("id"); ?></h2>
    <div class="row">

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
    </div>
  </div>

</body>
</html>
