<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * FROM equipmenttype";//sql statement

//If post request was called, (use when search method is called)
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  global $sql;
  $sql = "SELECT * FROM equipmenttype WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";

}

//replace space character with % (used when passing var to html link)
function replaceSpace($string){
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
    $sql = "SELECT * FROM equipmenttype WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
  }

  //execute sql
  $result = $conn->query($sql);
    //for each row return from the sql
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $Make = $row["Make"];
      $Model = $row["Model"];
      $Type =$row["Type"];
      $Description = $row["Description"];
      // set html format row
      echo "<tr>
      <td>".$id."</td>
      <td>".$Make."</td>
      <td>".$Model."</td>
      <td>".$Type."</td>
      <td>".$Description."</td>
      <td><a href = DeleteEquipmentType.php?id=".$id." onclick=\"return confirm('Are you sure to delete Equipment type in id: ".$id."');\"> Delete </a> &nbsp</td>
      <td><a href = UpdateEquipmentType.php?id=".replaceSpace($id)."&Make=".replaceSpace($Make)."&Model=".replaceSpace($Model)."&Type=".replaceSpace($Type)."&Description=".replaceSpace($id)."> Update </a> &nbsp</td>
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
        <option value="Make">Make</option>
        <option value="Model">Model</option>
        <option value="Type">Type</option>
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
                  <th>Make</th>
                  <th>Model</th>
                  <th>Type</th>
                  <th>Description</th>
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
