<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * FROM inventory";

if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  global $sql;
  $sql = "SELECT * FROM inventory WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";

}

function populateTable(){
  global $sql;
  require 'Credential.php';
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if( array_key_exists('key',$_GET) && array_key_exists('query',$_GET)){
    $sql = "SELECT * FROM inventory WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
  }

  #echo $sql;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $building = $row["Building"];
      $room = $row["Room"];
      $itemname =$row["Item_Name"];
      $itemtype = $row["Item_Type"];
      $assest = $row["Assest"];
      $service = $row["Service"];
      $active = ActiveText($row["Active"]);
      // echo $row["Building"] . '<br>';
      echo "<tr>
      <td>".$id."</td>
      <td>".$building."</td>
      <td>".$room."</td>
      <td>".$itemname."</td>
      <td>".$itemtype."</td>
      <td>".$assest."</td>
      <td>".$service."</td>
      <td>".$active."</td>
      </tr>";
    }
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset="UTF-8">
  <div class="menu">
    <?php include 'header.php'; ?>
    <br><br>
  </div>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <p>
  Search
  <select name="key">
    <option value="Building">Building</option>
    <option value="Room">Room</option>
    <option value="Item_Type">Item_Type</option>
    <option value="Item_Name">Item_Name</option>
    <option value="Assest">Assest</option>
    <option value="Service">Service</option>
  </select>
  Keyword: <input type="text" name="keyword">
  <input type="submit" name="submit" value="Submit">
  </p>
  </form>

  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Result   Use key=(Building|Room|Item_Name|Item_Type|Assest|Service) & query=
        </div>
        <div class="panel-body">
          <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Building</th>
                  <th>Room</th>
                  <th>Item Name</th>
                  <th>Item Type</th>
                  <th>Assest Number</th>
                  <th>Service Tag</th>
                  <th>Active</th>
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
