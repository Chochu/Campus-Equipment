<?php
//Homeapge
session_start();
if (!isset($_SESSION['id'])) {
  header('location:../index.php');
  exit(); // <-- terminates the current script
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
  <style>

  body {
    background: url(Images/background.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
  }
  #WelcomeMes{
    color: #DD4814;

  }


  .nav .navbar-nav{
    text-align: center;
    display: inline-block;
  }


  .dropdown:hover{ // hover glow for nav bar
    margin-top: -2px;
    margin-bottom: -2px;
    margin-left: -2px;
    margin-right: -2px;
    display: block;
    border:1px solid #E05A2B;
  }


  .dropdown > a{
    width: 162px;
    text-align: center;
    border-left: 1px solid #151515;
    border-right: 1px solid #4D4D4D;
  }
  hr{
    margin-top: 0px;
    margin-bottom: 0px;
    clear: both;
    border: 0;
    height: 2px;
    background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
    background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    background-image: linear-gradient(to left,rgba(21,21,21,0),rgba(224,90,43,25),rgba(0,0,0,0));
  }
  </style>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1">
        <nav class="navbar navbar-inverse">

          <ul class="nav navbar-nav">

            <li class="dropdown"><a href="home.php">Home</a></li>

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
                <li><a href="../Building/UpdateBuilding.php">Update Building</a></li>
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Room<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Room/InsertRoom.php">Insert Room</a></li>
                <li><a href="../Room/LookupRoom.php">Lookup Room</a></li>
                <li><a href="../Room/DeleteRoom.php">Delete Room</a></li>
                <li><a href="../Room/UpdateRoom.php">Update Room</a></li>
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
                <li><a href="Deploy/Retired.php">Retired</a></li>
                <li><a href="Deploy/Move.php">Move</a></li>
              </ul>
            </li>
            <li class="dropdown"><a href="../logout.php">Logout</a></li>

          </ul>

          <hr>
        </div>
      </div>
    </nav>
  </div>
</head>
<body>
  <div class="container-fluid">
    <div class = "row">
      <div class = "col-md-12 col-md-offset-5">
        <h1 id = "WelcomeMes"> Welcome <?php echo $_SESSION["Username"]?> !</h1>
        <h5 id = "WelcomeMes"> Message of the Day: </h5>
      </div>
    </div>
  </div>
</body>
</html>
