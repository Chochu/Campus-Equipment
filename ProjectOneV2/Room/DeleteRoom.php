<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$id = $idE = ""; //id = holds id, idE = holds the error for id
$sql = ""; //sql statement
$result = ""; //holds result string

//If post request was called (use for when it's load from LookupBuilding)
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  if (empty($_POST["id"])) {//if the id field is enter
    $idE = "Cannot delete entry without id number";//set error for idE
  } else {
    $id = TrimText($_POST["id"]);//remove special chars
  }
  if($id != ""){
    global $sql;
    $sql = "DELETE FROM room WHERE id=" . $_POST['id'] .";";//set sql statement
  }
  deleteRow();//execute statment
}
//if this page was load from LookupCampus with get request, set sql and execute it
if( array_key_exists('id',$_GET)){
  $id = $_GET['id'];
  $sql = "DELETE FROM room WHERE id=" . $_GET['id']. ";";
  deleteRow();
}
//function to connect to sql and execute statement
function deleteRow(){
  global $sql;
  global $id;
  global $result;
  require '../Credential.php'; //load credential to database
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // get result of the executed statement
  if ($conn->query($sql) === TRUE) {//if success
    //set result variable
    $result =  "Successfully deleted Room ID: " .$id ;
    //run python Script to update json in Script/Json folder
    exec('python ../Script/UpdateRoomJson.py');
  } else {
    $result = "Error : " . $sql . "<br>" . $conn->error;
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



<!DOCTYPE html>
<html lang="en">
<head>
  <div class="menu">
    <?php
    include 'header.php';//load menu ?>
    <br><br>
  </div>

</head>
<body>
  <h2>Delete Room</h2>
  <!-- Id field -->
  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">ID</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="id" name="id" placeholder="ID Number" value="<?php echo $id;?>">
        <?php echo "<p class='text-danger'>$idE</p>";?>
      </div>
    </div>
    <!-- Sumbit Buttom -->
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <input id="submit" name="submit" type="submit" value="Delete" class="btn btn-primary">
      </div>
    </div>

  </form>
  <?php
  echo "<h1>" .  $result . "</h1>";//use to display result
  ?>
</body>
</html>
