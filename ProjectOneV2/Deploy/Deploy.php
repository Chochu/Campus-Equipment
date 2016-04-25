<html>
<head>
  <meta charset="UTF-8">
  <div class="menu">
    <?php include '../header.php'; ?>
    <br><br>
  </div>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require '../Credential.php';
  include "../globalphpfunction.php";

  echo isRanked("gInsert");

  $str = $id = "";

  if( array_key_exists('id',$_GET)){
    $id = $_GET['id'];
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $EquipID = TrimText($_POST["id"]);
    $CampusID = TrimText($_POST["ddcampusid"]);
    $BuildingID = TrimText($_POST["ddbuildingid"]);
    $RoomID = TrimText($_POST["ddroomid"]);

    if($EquipID != ""){
      // Connection Data
      require '../Credential.php';//load Credential for sql login
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM nyit.deploy WHERE EquipID = " .$EquipID . " AND PastRoomID IS NULL;"
      ;
      $result = $conn->query($sql);
      $str = $sql;
      //if that equipment is already deploy
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $sql = "
        UPDATE deploy SET
        DateInstall = '".date("Y-m-d")."',
        CurrentCampusID = '".$CampusID."',
        CurrentBuildingID = '".$BuildingID."',
        CurrentRoomID = '".$RoomID."',
        PastCampusID = '".$row['CurrentCampusID']."',
        PastBuildingID = '".$row['CurrentBuildingID']."',
        PastRoomID = '".$row['CurrentRoomID']."',
        DateRemove = '".$row['DateInstall']."'
        WHERE
        EquipID = ".$EquipID;
        $str =  "Updated record Updated successfully";
      }else{//if not deploy
        $sql = "
        INSERT INTO deploy(EquipID, CurrentCampusID, CurrentBuildingID, CurrentRoomID, DateInstall)
        VALUES
        ('".$EquipID."',
        '".$CampusID."',
        '".$BuildingID."',
        '".$RoomID."',
        '".date("Y-m-d")."')";
        $str =  "Updated record created successfully";
      }
      if ($conn->query($sql) === TRUE) {//if success
        //update DeployID, this hold which row in the deploy row holds the current location of the equipment
        $returnID = $conn->insert_id;
        $sql = "UPDATE `nyit`.`equipment` SET `DeployID` = ".$returnID." WHERE `id` = ".$EquipID.";";
        $conn->query($sql);
      } else {
        $str = "Error : " . $sql . "<br>" . $conn->error;
      }
    }
  }

  ?>
</head>
<body>
  <div class="container">
    <h2>Deploy</h2>
    <div class="row">

      <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <!-- id -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Equipment ID</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="id" name="id" placeholder="0" value="<?php echo $id;?>" required>
          </div>
        </div>
        <!-- Drop Down -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Campus</label>
          <div class="col-sm-4">
            <select name="ddcampusid" id="ddcampusid" onchange="configureDropDownLists(this,document.getElementById('ddbuildingid'))" required>
              <option value="">...</option>
              <?php listcampusDropdown();?>
            </select>
          </div>
        </div>

        <!-- Building Dropdown -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Building</label>
          <div class="col-sm-4">
            <select name="ddbuildingid" id="ddbuildingid" onchange="configureDropDownLists(this,document.getElementById('ddroomid'))" required>
              <option value="">...</option>
            </select>
          </div>
        </div>

        <!-- Room Dropdown -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Room</label>
          <div class="col-sm-4">
            <select name="ddroomid" id="ddroomid" required>
              <option value="">...</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input id="submit" name="submit" type="submit" value="Submit" class="btn btn-query">
          </div>
        </div>

      </form>
      <?php
      echo "<h1>" .  $str . "</h1>";
      ?>
    </div>
  </div>
  <script>
  var BuildingArr = [];
  var RoomArr = [];
  $.ajax({ //http://stackoverflow.com/questions/7346563/loading-local-json-file
    url: "../Script/JSON/building.json",
    //force to handle it as text
    dataType: "text",
    success: function (dataTest) {
      //data downloaded so we call parseJSON function
      //and pass downloaded data
      var Buildingjson = $.parseJSON(dataTest);
      //now json variable contains data in json format
      //let's display a few items
      $.each(Buildingjson, function (i, jsonObjectList) {
        //console.log(jsonObjectList['id']);
        BuildingArr.push([jsonObjectList['id'],jsonObjectList['Name'],jsonObjectList['CampusID']]);
      });
    }
  });
  $.ajax({ //http://stackoverflow.com/questions/7346563/loading-local-json-file
    url: "../Script/JSON/room.json",
    //force to handle it as text
    dataType: "text",
    success: function (dataTest) {
      //data downloaded so we call parseJSON function
      //and pass downloaded data
      var Roomjson = $.parseJSON(dataTest);
      //now json variable contains data in json format
      //let's display a few items
      $.each(Roomjson, function (i, jsonObjectList) {
        //console.log(jsonObjectList['id']);
        RoomArr.push([jsonObjectList['id'],jsonObjectList['RoomNumber'],jsonObjectList['BuildingID']]);
      });
    }
  });


  function configureDropDownLists(ddcampusid,ddbuildingid) {//Function called when dropdown value change
    ddbuildingid.options.length = 0;
    if (ddbuildingid.name == "ddbuildingid"){
      for (var arrayID in BuildingArr){
        if (BuildingArr[arrayID][2] == ddcampusid.value){
          createOption(ddbuildingid, BuildingArr[arrayID][1], BuildingArr[arrayID][0]);
        }
      }
    }
    if(ddbuildingid.name == "ddroomid"){
      for (var arrayID in RoomArr){
        if (RoomArr[arrayID][2] == ddcampusid.value){
          createOption(ddbuildingid, RoomArr[arrayID][1], RoomArr[arrayID][0]);
        }
      }
    }
  }

  function createOption(ddbuildingid, text, value) {//add option to dropdown
    var opt = document.createElement('option');
    opt.value = value;
    opt.text = text;
    ddbuildingid.options.add(opt);
  }
  </script>

</body>
</html>
