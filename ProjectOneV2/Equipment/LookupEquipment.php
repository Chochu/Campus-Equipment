<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * FROM equipment";//sql statement

//If post request was called, (use when search method is called)
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  global $sql;
  $sql = "SELECT * FROM equipment WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";
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
    //if there's set sql to get
    $sql = "SELECT * FROM equipment WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
  }
  //EquipmentArray is use to get the campus name from the campus id
  $EquipmentArray = array();
  //BuildingArray
  $str = file_get_contents($JsonEquipment);//load campus json
  $json = json_decode($str,true);//decode
  foreach ($json as $value){//store to json array
    $EquipmentArray[$value['id']] = $value['Make']. ' ' . $value['Model'];
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
      $equipmenttype = $row["equipmenttype"];
      // echo $row["Building"] . '<br>';
      echo "<tr>
      <td>".$id."</td>
      <td>".$Name."</td>
      <td>".$Asset."</td>
      <td>".$Serial."</td>
      <td>".$equipmenttype."</td>
      <td>".$EquipmentArray[$equipmenttype]."</td>
      <td>".$Active."</td>
      <td><a href = DeleteEquipment.php?id=".$id." onclick=\"return confirm('Are you sure to delete Room id: ".$id."');\"> Delete </a> &nbsp</td>
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
    <br><br>
  </div>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <p>
      Search
      <select name="key">
        <option value="Name">Name</option>
        <option value="equipmenttype">equipmenttype</option>
        <option value="Asset">Asset</option>
        <option value="Serial">Serial</option>
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
                  <th>Active</th>
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
