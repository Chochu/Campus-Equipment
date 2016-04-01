<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * FROM building"; //sql statement

//If post request was called, (use when search method is called)
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  global $sql;
  $sql = "SELECT * FROM building WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";
}

function replaceSpace($string){//replace space character with % (used when passing var to html link)
  return str_replace(" ","%",$string);
}

//generate row when recieving result back from the sql execution
function populateTable(){

  global $sql;
  require '../Credential.php'; //load Credential for sql login
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //check if there is get method
  if( array_key_exists('key',$_GET) && array_key_exists('query',$_GET)){
    //if there's set sql to get
    $sql = "SELECT * FROM building WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
  }

  //CampusArray is use to get the campus name from the campus id
  $CampusArray = array();
  $str = file_get_contents($JsonCampus); //load campus json
  $json = json_decode($str,true); //decode
  foreach ($json as $value){ //store to json array
    $CampusArray[$value['id']] = $value['Name'];
  }

  //execute sql
  $result = $conn->query($sql);
  //for each row return from the sql
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $Name = $row["Name"];
      $Abb = $row["Abb"];
      $CampusID =$row["CampusID"];
      $AltName = $row["AltName"];
      // set html format row
      echo "<tr>
      <td>".$id."</td>
      <td>".$Name."</td>
      <td>".$Abb."</td>
      <td>".$AltName."</td>
      <td>".$CampusID."</td>
      <td>".$CampusArray[$CampusID]."</td>
      <td><a href = DeleteBuilding.php?id=".$id." onclick=\"return confirm('Are you sure to delete Building id: ".$id."');\"> Delete </a> &nbsp</td>
      <td><a href = UpdateBuilding.php?id=".replaceSpace($id)."&Name=".replaceSpace($Name)."&Abb=".replaceSpace($Abb)."&AltName=".replaceSpace($AltName)."&CampusID=".replaceSpace($CampusID)."> Edit </a> &nbsp</td>
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
                  <th>Name</th>
                  <th>Abb</th>
                  <th>AltName</th>
                  <th>CampusID</th>
                  <th>Campus Name</th>
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
