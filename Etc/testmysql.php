<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 ?>

<html>
<header>
  <div class="menu">
     <?php include 'header.php'; ?>
   </div>
</header>
</html>

<?php


// Connection Data
$servername = "localhost";
$username = "Test";
$password = "";
$dbname = "leagueoflegend";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM champion;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["title"] . "<br>";
    }
} else {
    echo "0 results";
}

//this will show us what's i nthe table so if there is something and it shows we know it works try it.

$Building = "Harry";
$Room= "301";
$Item_Name ="OW-HSH-301-TS";
$Item_Type = "PC";
$Assest_Tag = "12342-3412";
$Service_Tag = "12312312";

// $query = "
// INSERT INTO 'inventory'(Building, Room,Item_Name,Item_Type,Assest_Tag,Service_Tag)
// VALUES
// ('".$Building."',
// '".$Room."',
// '".$Item_Name."',
// '".$Item_Type."',
// '".$Assest_Tag."',
// '".$Service_Tag."')";

// if(mysqli_query($mysqli, $query)){
//   $last_id = mysqli_insert_id($mysqli);
//   echo "Schema Created successfully: ". $last_id;
// }else {
//   echo "failed: " . $mysqli -> error;
// }
$conn->close();
?>
