<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$id = $idE = "";
$sql = "";
$result = "";

if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  if (empty($_POST["id"])) {
    $idE = "Cannot delete entry without id number";
  } else {
    $id = TrimText($_POST["id"]);
  }
  if($id != ""){
    global $sql;
    $sql = "DELETE FROM room WHERE id=" . $_POST['id'] .";";
  }
  deleteRow();
}
if( array_key_exists('id',$_GET)){
  $id = $_GET['id'];
  $sql = "DELETE FROM room WHERE id=" . $_GET['id']. ";";
  deleteRow();
}
function deleteRow(){
  global $sql;
  global $id;
  global $result;
  require '../Credential.php';
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($conn->query($sql) === TRUE) {
    $result =  "Successfully deleted Room ID: " .$id ;
  } else {
    $result = "Error : " . $sql . "<br>" . $conn->error;
  }

}
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
     include 'header.php'; ?>
    <br><br>
  </div>

</head>
<body>
  <h2>Delete Room</h2>
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
