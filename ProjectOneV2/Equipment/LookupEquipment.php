<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT nyit.equipment.*,nyit.deploy.CurrentRoomID,nyit.deploy.CurrentBuildingID,nyit.deploy.CurrentCampusID,nyit.deploy.DateInstall FROM nyit.equipment LEFT JOIN nyit.deploy on nyit.equipment.id = nyit.deploy.EquipID  where nyit.deploy.PastRoomID is null;";//sql statement

//If post request was called, (use when search method is called)
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  global $sql;
  $sql = "SELECT * FROM (SELECT nyit.equipment.*,nyit.deploy.CurrentRoomID,nyit.deploy.CurrentBuildingID,nyit.deploy.CurrentCampusID,nyit.deploy.DateInstall FROM nyit.equipment LEFT JOIN nyit.deploy on nyit.equipment.id = nyit.deploy.EquipID where nyit.deploy.PastRoomID is null) AS table1 WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";

}

function replaceSpace($string){//replace space character with % (used when passing var to html link)
  return str_replace(" ","%",$string);
}

//generate row when recieving result back from the sql execution
function populateTable(){

  global $sql;
  require '../Credential.php';//load Credential for sql login
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //check if there is get method
  if( array_key_exists('key',$_GET) && array_key_exists('query',$_GET)){
    //if there's set sql to get nyit.deploy.PastRoomID is null AND
    $sql = "SELECT * FROM (SELECT nyit.equipment.*,nyit.deploy.CurrentRoomID,nyit.deploy.CurrentBuildingID,nyit.deploy.CurrentCampusID,nyit.deploy.DateInstall FROM nyit.equipment LEFT JOIN nyit.deploy on nyit.equipment.id = nyit.deploy.EquipID where nyit.deploy.PastRoomID is null)AS table1 WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
  }
  //EquipmentArray is use to get the campus name from the campus id
  $EquipmentArray = array();
  $EquipmentDescription = array();
  $Campus = array();   //Campus Array
  $Building = array();  //Building Array
  $Room = array();  //Room Array

  $str = file_get_contents($JsonEquipment);//load Equipment json
  $json = json_decode($str,true);//decode
  foreach ($json as $value){//store to json array
    $EquipmentArray[$value['id']] = $value['Make']. ' ' . $value['Model'];
    $EquipmentDescription[$value['id']] = $value['Description'];
  }
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

  //execute sql
  $result = $conn->query($sql);
  //for each row return from the sql
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $Name = $row["Name"];
      $Asset = $row["Asset"];
      $Serial =$row["Serial"];
      $Active = $row["Active"];
      $CurrentRoomID ="";
      $CurrentCampusID = "";
      $CurrentBuildingID = "";
      $DateInstall = "";
      $equipmenttype = $row["equipmenttype"];
      if($row["CurrentRoomID"] != null){
        $CurrentRoomID = $Room[$row["CurrentRoomID"]];
        $CurrentCampusID = $Campus[$row["CurrentCampusID"]];
        $CurrentBuildingID =$Building[$row["CurrentBuildingID"]];
        $DateInstall = $row["DateInstall"];
      }


      // echo $row["Building"] . '<br>';
      echo "<tr>
      <td>".$id."</td>
      <td>".$Name."</td>
      <td>".$Asset."</td>
      <td>".$Serial."</td>
      <td>".$equipmenttype."</td>
      <td><a href='#' data-toggle='popover' title='Description' data-content='".$EquipmentDescription[$equipmenttype]."'>".$EquipmentArray[$equipmenttype]."</a></td>
      <td>".$DateInstall."</td>
      <td>".$CurrentCampusID."</td>
      <td>".$CurrentBuildingID."</td>
      <td>".$CurrentRoomID."</td>
      <td><a href = ../Deploy/lookup.php?EquipID=".$id."> Lookup </a> &nbsp</td>
      <td><a href = ../Deploy/Deploy.php?id=".$id."> Move </a> &nbsp</td>
      <td><a href = DeleteEquipment.php?id=".$id." onclick=\"return confirm('Are you sure to deactivate equipment id: ".$id."');\"> Delete </a> &nbsp</td>
      <td><a href = UpdateEquipment.php?id=".replaceSpace($id)."&Name=".replaceSpace($Name)."&Asset=".replaceSpace($Asset)."&Serial=".replaceSpace($Serial)."&Active=".replaceSpace($Active)."> Edit </a> &nbsp</td>
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
    <script>
    $(document).ready(function(){
      $('[data-toggle="popover"]').popover();
    });
    </script>
    <br><br>
  </div>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <p>
      Search
      <select name="key">
        <option value="Name">Name</option>
        <option value="equipmenttype">Equipment Type ID</option>
        <option value="Asset">Asset</option>
        <option value="Serial">Serial</option>
        <option value="CuurentCampusID">Campus</option>
        <option value="CuurentBuildingID">Building</option>
        <option value="CuurentRoomID">Room</option>
        <option value="DateInstall">Date: YYYY-MM-DD</option>
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
                  <th>Name</th>
                  <th>Asset</th>
                  <th>Serial</th>
                  <th>Equipment Type ID</th>
                  <th>Equipement Type</th>
                  <th>Date Install</th>
                  <th>Campus</th>
                  <th>Building</th>
                  <th>Room</th>
                  <th>History</th>
                  <th>Move</th>
                  <th>Delete</th>
                  <th>Edit</th>
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
