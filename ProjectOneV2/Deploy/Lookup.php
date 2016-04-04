<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "";
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  global $sql;
  $sql = "SELECT * FROM nyit.deploy WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";

}
function replaceSpace($string){
  return str_replace(" ","%",$string);
}

function populateTable(){

  global $sql;
  if($sql != ""){
    require '../Credential.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    if( array_key_exists('key',$_GET) && array_key_exists('query',$_GET)){
      $sql = "SELECT * FROM nyit.deploy WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
    }

    $Campus = array();   //Campus Array
    $Building = array();  //Building Array
    $Room = array();  //Room Array
    $str = file_get_contents($JsonCampus);//load campus json
    $json = json_decode($str,true);//decode
    foreach ($json as $value){//store to json array
      $Campus[$value['id']] = $value['Name'];
    }
    $str = file_get_contents($JsonBuilding);//load building json
    $json = json_decode($str,true);//decode
    foreach ($json as $value){//store to json array
      $Building[$value['id']] = $value['Name'];
    }
    $str = file_get_contents($JsonRoom);//load room json
    $json = json_decode($str,true);//decode
    foreach ($json as $value){//store to json array
      $Room[$value['id']] = $value['RoomNumber'];
    }
    #echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $id = $row["EquipID"];
        $CurrentRoomID =  $Room[$row["CurrentRoomID"]];
        $CurrentCampusID =  $Campus[$row["CurrentCampusID"]];
        $CurrentBuildingID = $Building[$row["CurrentBuildingID"]];
        $DateInstall =  $row["DateInstall"];
        $PastRoomID =   "";
        $PastCampusID =   "";
        $PastBuildingID =  "";
        $PastDateInstall =  "";
        if( $row["PastRoomID"] != null)
        {
          $PastRoomID =  $Room[$row["PastRoomID"]];
          $PastCampusID = $Campus[$row["PastCampusID"]] ;
          $PastBuildingID =  $Building[$row["PastBuildingID"]];
          $PastDateInstall =  $row["DateRemove"];
        }
        // echo $row["Building"] . '<br>';
        echo "<tr>
        <td>".$id."</td>
        <td>".$DateInstall."</td>
        <td>".$CurrentCampusID."</td>
        <td>".$CurrentBuildingID."</td>
        <td>".$CurrentRoomID."</td>
        <td>".$PastDateInstall."</td>
        <td>".$PastCampusID."</td>
        <td>".$PastBuildingID."</td>
        <td>".$PastRoomID."</td>
        <td><a href = DeleteRoom.php?id=".$id." onclick=\"return confirm('Are you sure to delete Building id: ".$id."');\"> Delete </a> &nbsp</td>
        </tr>";
      }
    }

    $conn->close();
  }
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
        <option value="EquipID">Equip ID</option>
        <option value="DateInstall">Install Date: YYYY-MM-DD</option>
        <option value="CampusID">Date ID</option>
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
                  <th>Equipment ID</th>
                  <th>Install Date</th>
                  <th>Current Campus</th>
                  <th>Current Building</th>
                  <th>Current Room</th>
                  <th>Install Date</th>
                  <th>Past Campus</th>
                  <th>Past Building</th>
                  <th>Past Room</th>
                  <th>Move</th>
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
