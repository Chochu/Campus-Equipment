<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * FROM room";

if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  global $sql;
  $sql = "SELECT * FROM room WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";

}
function replaceSpace($string){
  return str_replace(" ","%",$string);
}

function populateTable(){

  global $sql;
  require '../Credential.php';
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if( array_key_exists('key',$_GET) && array_key_exists('query',$_GET)){
    $sql = "SELECT * FROM room WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
  }
  $CampusArray = array();
  $BuildingArray = array();
  $str = file_get_contents('../campus.json');
  $json = json_decode($str,true);
  foreach ($json as $value){
    $CampusArray[$value['id']] = $value['Name'];
  }
  $str = file_get_contents('../building.json');
  $json = json_decode($str,true);
  foreach ($json as $value){
    $BuildingArray[$value['id']] = $value['Name'];
  }
  #echo $sql;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $RoomNum = $row["RoomNumber"];
      $Altname = $row["AltName"];
      $BuildingID =$row["BuildingID"];
      $CampusID = $row["CampusID"];
      // echo $row["Building"] . '<br>';
      echo "<tr>
      <td>".$id."</td>
      <td>".$RoomNum."</td>
      <td>".$Altname."</td>
      <td>".$BuildingID."</td>
      <td>".$BuildingArray[$BuildingID]."</td>
      <td>".$CampusID."</td>
      <td>".$CampusArray[$CampusID]."</td>
      <td><a href = DeleteRoom.php?id=".$id." onclick=\"return confirm('Are you sure to delete Building id: ".$id."');\"> Delete </a> &nbsp</td>
      <td><a href = UpdateRoom.php?id=".replaceSpace($id)."&Name=".replaceSpace($RoomNum)."&Abb=".replaceSpace($Altname)."&AltName=".replaceSpace($BuildingID)."&CampusID=".replaceSpace($CampusID)."> Update </a> &nbsp</td>
      </tr>";
    }
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html lang = "en">
<head>
  <div class="menu">
    <?php include 'header.php'; ?>
    <br><br>
  </div>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <p>
      Search
      <select name="key">
        <option value="Name">Name</option>
        <option value="Abb">Abb</option>
        <option value="CampusID">Campus ID</option>
        <option value="AltName">Alt Name</option>
      </select>
      Keyword: <input type="text" name="keyword">
      <input type="submit" name="submit" value="Submit">
    </p>
  </form>

  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Result
        </div>
        <div class="panel-body">
          <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Room Number</th>
                  <th>Alt Name</th>
                  <th>Building ID</th>
                  <th>Building Name</th>
                  <th>Campus ID</th>
                  <th>Campus Name</th>
                  <th>Delete</th>
                  <th>Update</th>
                </tr>
              </thead>
              <tbody>
                <?php
                populateTable();
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>
</html>
