<?php
// define variables and set to empty values
$BuildingE = $RoomE = $Item_NameE = $Item_TypeE = "";
$Building = $Room = $Item_Name = $Item_Type = $Assest_Tag = $Service_Tag = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["building"])) {
    $BuildingE = "Building is required";
  } else {
    $Building = test_input($_POST["building"]);
  }
  if (empty($_POST["room"])) {
    $RoomE = "Room is required";
  } else {
    $Room = test_input($_POST["room"]);
  }
  if (empty($_POST["itemname"])) {
    $Item_NameE = "Item name is required";
  } else {
    $Item_Name = test_input($_POST["itemname"]);
  }
  if (empty($_POST["itemtype"])) {
    $Item_TypeE = "Item type is required";
  } else {
    $Item_Type = test_input($_POST["itemtype"]);
  }
  if (empty($_POST["assest"])) {
    $Assest_Tag = "-1";
  } else {
    $Assest_Tag = test_input($_POST["assest"]);
  }
  if (empty($_POST["service"])) {
    $Service_Tag = "-1";
  } else {
    $Service_Tag = test_input($_POST["service"]);
  }
  #echo $Building . $Room . $Item_Name . $Item_Type .$Assest_Tag.$Service_Tag ;
  if($Building != "" && $Room != "" && $Item_Name != "" && $Item_Type != ""){
    // Connection Data
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nyit";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    INSERT INTO inventory(Building, Room, Item_Name, Item_Type, Assest, Service)
    VALUES
    ('".$Building."',
    '".$Room."',
    '".$Item_Name."',
    '".$Item_Type."',
    '".$Assest_Tag."',
    '".$Service_Tag."')";

    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error : " . $sql . "<br>" . $conn->error;
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>

<html>
<header>
<style>
.error {color: #FF0000;}
</style>

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

</header>
<body>

  <h2>Insert to Database</h2>
  <p><span class="error">* required field.</span></p>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Building: <input type="text" name="building">
    <span class="error">* <?php echo $BuildingE;?></span>
    <br><br>
    Room: <input type="text" name="room">
    <span class="error">* <?php echo $RoomE;?></span>
    <br><br>
    Item Name: <input type="text" name="itemname">
    <span class="error">*<?php echo $Item_NameE;?></span>
    <br><br>
    Item Type: <input type="text" name="itemtype">
    <span class="error">*<?php echo $Item_TypeE;?></span>
    <br><br>
    Assest Tag: <input type="text" name="assest">
    <br><br>
    Service Tag: <input type="text" name="service">
    <br><br>
    Service Tag: <input type="text" name="service">
    <br><br>
    <input type="submit" name="submit" value="Submit">
  </form>
</div>
</body>

</html>
