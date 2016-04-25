<?php
//Homeapge
session_start();
if (!isset($_SESSION['id'])) {
  header('location:../index.php');
  exit(); // <-- terminates the current script
}

function getPost($string){
  if( array_key_exists($string,$_GET)){
    echo replaceSpace($_GET[$string]);
  }
  else{
    echo "";
  }
}
function replaceSpace($string){
  return str_replace("%"," ",$string);
}
?>
<html lang = "en">
<head>
  <meta charset="UTF-8">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="Darkstyle.css">


  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 ">
        <nav class="navbar">
          <ul class="nav navbar-nav">

            <li class="dropdown-toggle"><a href="home.php">Home</a></li>

            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Campus<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Campus/InsertCampus.php">Insert Campus</a></li>
                <li><a href="Campus/LookupCampus.php">Lookup Campus</a></li>
                <li><a href="Campus/DeleteCampus.php">Delete Campus</a></li>
                <li><a href="Campus/UpdateCampus.php">Update Campus</a></li>
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Building<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Building/InsertBuilding.php">Insert Building</a></li>
                <li><a href="Building/LookupBuilding.php">Lookup Building</a></li>
                <li><a href="Building/DeleteBuilding.php">Delete Building</a></li>
                <li><a href="Building/UpdateBuilding.php">Update Building</a></li>
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Room<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Room/InsertRoom.php">Insert Room</a></li>
                <li><a href="Room/LookupRoom.php">Lookup Room</a></li>
                <li><a href="Room/DeleteRoom.php">Delete Room</a></li>
                <li><a href="Room/UpdateRoom.php">Update Room</a></li>
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Equipment<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Equipment/InsertEquipment.php">Insert Equipment</a></li>
                <li><a href="Equipment/LookupEquipment.php">Lookup Equipment</a></li>
                <li><a href="Equipment/DeleteEquipment.php">Delete Equipment</a></li>
                <li><a href="Equipment/UpdateEquipment.php">Update Equipment</a></li>
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Equipment Type<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="EquipmentType/InsertEquipmentType.php">Insert EquipmentType</a></li>
                <li><a href="EquipmentType/LookupEquipmentType.php">Lookup Equipment Type</a></li>
                <li><a href="EquipmentType/DeleteEquipmentType.php">Delete Equipment Type</a></li>
                <li><a href="EquipmentType/UpdateEquipmentType.php">Update Equipment Type</a></li>
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Deploy<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Deploy/Deploy.php">Deploy</a></li>
                <li><a href="Deploy/Lookup.php">Lookup</a></li>
              </ul>
            </li>
            <li class="dropdown-toggle"><a href="logout.php">Logout</a></li>
            <hr>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</head>
<body>
  <div class="container-fluid">
    <div class = "row">
      <div class = "col-md-12 col-md-offset-5">
        <h1 id = "WelcomeMes"> Welcome <?php echo $_SESSION["Username"];?> !</h1>
        <h2 id = "WelcomeMes"> Message of the Day: <?php getPost("motd");?></h2>
        <h2 id = "WelcomeMes"> <?php  getPost("error");?></h2>
      </div>
    </div>
  </div>
</body>
</html>
