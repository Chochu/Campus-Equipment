<?php
/*
$_Get - Someone is requesting Data from your application
$_Post - Someone is pushing (inserting/updating/deleting) data from your application
*/
?>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<?php

// define variables and set to empty values
$IdE = $RoomNumE = $BuildingIDE = $CampusIDE = "";
$Id = $RoomNum = $type = $BuildingID = $CampusID = $Altname = "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//If post request was called
  /* similar structure to Insert Building, with an extra field called id
  if statement are use to check if the text field of the html are empty
  if they are, set the error variables to display the error
  else remove special header and set its to the variables
  */

  if (empty($_POST["id"])) {
    $IdE = "ID is required";
  } else {
    $Id = TrimText($_POST["id"]);
  }
  if (empty($_POST['room'])) {
    $RoomNumE = "Name is required";
  } else {
    $RoomNum = TrimText($_POST["room"]);
  }
  if (empty($_POST['altname'])) {
    $Altname = "";//Alt name doesnt have a error variables, so if it is empty, nothing will happen
  } else {
    $Altname = TrimText($_POST["altname"]);
  }
  if($_POST['ddcampusid'] == ""){
    $CampusIDE = "Must Select an Campus";
  }else {
    $CampusID = $_POST['ddcampusid'];
  }
  if($_POST['ddbuildingid'] == ""){
    $BuildingIDE = "Must Select an Campus";
  }else {
    $BuildingID = $_POST['ddbuildingid'];
  }

  //Check if the variable are empty, if they are that means that the html text-danger
  //are empty, This check prevent sql statement from executing if Name, Abb, and CampusID
  //are empty
  if($RoomNum != "" && $BuildingID != "" && $CampusID != ""){
    // Connection Data
    require '../Credential.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    UPDATE room SET
    RoomNumber = '".$RoomNum."',
    AltName = '".$Altname."',
    BuildingID = '".$BuildingID."',
    CampusID = '".$CampusID."'
    WHERE
    id = ".$Id;

    // get result of the executed statement
    if ($conn->query($sql) === TRUE) {//if success
      //set result variable
      $str =  "Updated record created successfully";
      //run python Script to update json in Script/Json folder
      exec('python ../Script/UpdateRoomJson.py');
    } else {
      $str = "Error : " . $sql . "<br>" . $conn->error;
    }
  }
}
//populate campus dropdown
function listcampusDropdown(){
  require '../Credential.php';//load the path
  $str = file_get_contents($JsonCampus); //load text from file
  $json = json_decode($str,true);//decode to json var
  foreach ($json as $value){//loop through json
     echo "<option value=\"".$value['id']."\">".$value['Name']."</option>";//add option value to dropdown
  }
}
//remove special char to prevent sql injection
function TrimText($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//Used for set the value of the html text from get request,
//User doesnt have retype everything out
function getPost($string){
  if( array_key_exists($string,$_GET)){
    echo replaceSpace($_GET[$string]);
  }
  else{
    echo "";
  }
}
//replace % with space
function replaceSpace($string){
  return str_replace("%"," ",$string);
}
?>
<meta charset="UTF-8">
<div class="menu">
  <?php include 'header.php'; ?>
  <br><br>
</div>

</head>
<body>

  <h2>Update Room id: <?php getPost("id"); ?></h2>
  <p><span class="error">* required field.</span></p>

  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- id -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">ID</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="id" name="id" placeholder="0" value="<?php getPost("id");?>">
        <?php echo "<p class='text-danger'>$IdE</p>";?>
      </div>
    </div>
    <!-- Room Number -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Room Number</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="room" name="room" placeholder="130" value="<?php  getPost("Room");?>">
        <?php echo "<p class='text-danger'>$RoomNumE</p>";?>
      </div>
    </div>
    <!-- Alt Name  -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Alt Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="altname" name="altname" placeholder="Lecture Hall" value="<?php  getPost("Alt");?>">
      </div>
    </div>
    <!-- Campus Dropdown -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Campus</label>
      <div class="col-sm-4">
        <select name="ddcampusid" onchange="configureDropDownLists(this,document.getElementById('ddbuildingid'))">
          <option value="">...</option>
          <?php listcampusDropdown();?>
        </select>
        <?php echo "<p class='text-danger'>$CampusIDE</p>";?>
      </div>
    </div>
    <!-- Building Dropdown -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Building</label>
      <div class="col-sm-4">
        <select name="ddbuildingid" id="ddbuildingid">
          <option value="">...</option>
        </select>
        <?php echo "<p class='text-danger'>$CampusIDE</p>";?>
      </div>
    </div>
    <div class="form-group">
      <!-- Submit Button -->
      <div class="col-sm-10 col-sm-offset-2">
        <input id="submit" name="submit" type="submit" value="Submit" class="btn btn-primary">
      </div>
    </div>

  </form>
  <?php
  echo "<h1>" .  $str . "</h1>";
  ?>

  <script>
  var gBuildingjson;
  var BuildingArr = [];
  $.ajax({ //http://stackoverflow.com/questions/7346563/loading-local-json-file
         url: "../Script/JSON/building.json",
             //force to handle it as text
         dataType: "text",
              success: function (dataTest) {

                  //data downloaded so we call parseJSON function
                  //and pass downloaded data
                  var Buildingjson = $.parseJSON(dataTest);
                  gBuildingjson = Buildingjson;
                  //now json variable contains data in json format
                  //let's display a few items
                  $.each(Buildingjson, function (i, jsonObjectList) {
                    //console.log(jsonObjectList['id']);
                    BuildingArr.push([jsonObjectList['id'],jsonObjectList['Name'],jsonObjectList['CampusID']]);
                   });
               }
    });


  function configureDropDownLists(ddcampusid,ddbuildingid) {
    ddbuildingid.options.length = 0;
    for (var arrayID in BuildingArr){
      if (BuildingArr[arrayID][2] == ddcampusid.value){
        createOption(ddbuildingid, BuildingArr[arrayID][1], BuildingArr[arrayID][0]);
      }
    }
  }

  function createOption(ddbuildingid, text, value) {
    var opt = document.createElement('option');
    opt.value = value;
    opt.text = text;
    ddbuildingid.options.add(opt);
  }
  </script>


</body>
</html>
