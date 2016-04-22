<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Variables
$id = $idE = "";
$sql = "";
$result = "";

//If post request was called
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  /*
  if statement are use to check if the text field of the html are empty
  if they are, set the error variables to display the error
  else remove special header and set its to the variables
  */
  if (empty($_POST["id"])) {   //If id field is empty
    $idE = "Cannot delete entry without id number"; //Set $idE
  } else {
    $id = TrimText($_POST["id"]); //Set $id
  }

  if($id != ""){//if $id is not empty
    global $sql;
    $sql = "DELETE FROM equipmenttype WHERE id=" . $_POST['id'] .";"; //set sql command
  }
  deleteRow(); //execute the code
}
if( array_key_exists('id',$_GET)){ //if the method is get
  $id = $_GET['id']; //set id
  $sql = "DELETE FROM equipmenttype WHERE id=" . $_GET['id']. ";"; //set sql command
  deleteRow(); //execute code
}
function deleteRow(){
  global $sql;
  global $id;
  global $result;
  require '../Credential.php'; //load credential
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) { //check connection
    die("Connection failed: " . $conn->connect_error);
  }

  if ($conn->query($sql) === TRUE) { //if success
    //set result variable
    $result =  "Successfully deleted Equipment type ID: " .$id ;
    //run python Script to update json in Script/Json folder
    exec('python ../Script/UpdateEquipTypeJson.py');
  } else {
    $result = "Error : " . $sql . "<br>" . $conn->error;
  }

}
function TrimText($data) { //remove special character
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <div class="menu">
    <?php
    include '../header.php'; ?>
    <br><br>
  </div>

</head>
<body>
  <div class="container">
    <h2>Delete Equipment Type</h2>
    <div class="row">

      <!-- id -->
      <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">ID</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="id" name="id" placeholder="ID Number" value="<?php echo $id;?>">
            <?php echo "<p class='text-danger'>$idE</p>";?>
          </div>
        </div>
        <!-- Submit Buttom -->
        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input id="submit" name="submit" type="submit" value="Delete" class="btn btn-query">
          </div>
        </div>

      </form>
      <?php
      echo "<h1>" .  $result . "</h1>";
      ?>
    </div>
  </div>

</body>
</html>
