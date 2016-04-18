<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * FROM product";//sql statement

//replace space character with % (used when passing var to html link)
function replaceSpace($string){
  return str_replace(" ","%",$string);
}
//generate row when recieving result back from the sql execution
function populateTable(){
  global $sql;
  require 'Credential.php';//load Credential for sql login
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  //execute sql
  $result = $conn->query($sql);
    //for each row return from the sql
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $Code = $row["ProductCode"];
      $Desc = $row["ProductDesc"];
      $Price =$row["ProductPrice"];
      // set html format row
      echo "<tr>
      <td>".$Code."</td>
      <td>".$Desc."</td>
      <td>$".$Price."</td>
      <td><a href = DeleteEquipmentType.php?id=".$id." onclick=\"return confirm('Are you sure to delete Equipment type in id: ".$id."');\"> Delete </a> &nbsp</td>
      <td><a href = UpdateEquipmentType.php?Code=".replaceSpace($Code)."&Desc=".replaceSpace($Desc)."&Price=".replaceSpace($Price)."> Edit </a> &nbsp</td>
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

  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Products
        </div>
        <div class="panel-body">
          <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Description</th>
                  <th>Price</th>
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
