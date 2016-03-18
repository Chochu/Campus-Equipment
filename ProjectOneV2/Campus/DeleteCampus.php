<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Variables
$id = $idE = "";
$sql = "";
$result = "";

//Post
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  if (empty($_POST["id"])) {   //If id field is empty
    $idE = "Cannot delete entry without id number"; //Set $idE
  } else {
    $id = TrimText($_POST["id"]); //Set $id
  }

  if($id != ""){//if $id is not empty
    global $sql;
    $sql = "DELETE FROM Campus WHERE id=" . $_POST['id'] .";"; //set sql command
  }
  deleteRow(); //execute the code
}
if( array_key_exists('id',$_GET)){ //if the method is get
  $id = $_GET['id']; //set id
  $sql = "DELETE FROM Campus WHERE id=" . $_GET['id']. ";"; //set sql command
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

  if ($conn->query($sql) === TRUE) { //result of the execution
    $result =  "Successfully deleted Campus ID: " .$id ;
    exec('python ../Script/UpdateCampusJson.py');
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
     include 'header.php'; ?>
    <br><br>
  </div>

</head>
<body>
  <h2>Delete Campus</h2>
  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">ID</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="id" name="id" placeholder="ID Number" value="<?php echo $id;?>">
        <?php echo "<p class='text-danger'>$idE</p>";?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <input id="submit" name="submit" type="submit" value="Delete" class="btn btn-primary">
      </div>
    </div>

  </form>
  <?php
  echo "<h1>" .  $result . "</h1>";
  ?>
</body>
</html>
