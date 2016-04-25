<html>
<head>
  <meta charset="UTF-8">
  <div class="menu">
    <?php include '../header.php'; ?>
    <br><br>
  </div>

  <?php
  require '../Credential.php';
  include "../globalphpfunction.php";
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  echo isRanked("gUpdate");

  // define variables and set to empty values
  $IdE = $EquipmentTypeIDE = $NameE = $ActiveE= "";
  $Id =  $EquipmentTypeID = $Asset = $Serial = $Active =  "";
  $str = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['EquipID'])) {
      $EquipmentTypeIDE = "Equipment Type ID is required";
    } else {
      $EquipmentTypeID = TrimText($_POST["EquipID"]);
    }
    if (empty($_POST['name'])) {
      $NameE = "Equipment Type ID is required";
    } else {
      $Name = TrimText($_POST["name"]);
    }
    if (empty($_POST['active'])) {
      $ActiveE = "Please pick one";
    } else {
      $Active = TrimText($_POST["active"]);
    }
    $Asset =TrimText($_POST["Asset"]);
    $Serial = TrimText($_POST["Serial"]);

    if($EquipmentTypeID != ""){

      require '../Credential.php';

      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "
      UPDATE equipment SET
      Name = '".$Name."',
      equipmenttype = '".$EquipmentTypeID."',
      Asset = '".$Asset."',
      Serial = '".$Serial."',
      Active = '".$Active."'
      WHERE
      id = ".$Id;

      if ($conn->query($sql) === TRUE) {
        $str =  "Updated record created successfully";
      } else {
        $str = "Error : " . $sql . "<br>" . $conn->error;
      }
    }

  }

  function JsontoDropdown($datapath){
    $TypeArray = array();
    $str = file_get_contents($datapath);
    $json = json_decode($str,true);
    foreach ($json as $value){
      array_push($TypeArray,$value['Type']);
      //echo "<option value=\"".$value['id']."\">".$value['Make']. " " .$value['Model']."</option>";
    }
    $TypeArray = array_unique($TypeArray,SORT_REGULAR);
    foreach ($TypeArray as $value) {
      echo "<option value=\"".$value."\">".$value."</option>";
    }

  }

  ?>
</head>
<body>
  <div class="container">
    <h2>Update Equipement id: <?php getPost("id"); ?></h2>
    <div class="row">
      <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <!-- id -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">ID</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="id" name="id" placeholder="0" value="<?php getPost("id");?>">
            <?php echo "<p class='text-danger'>$IdE</p>";?>
          </div>
        </div>
        <!-- Name -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="name" name="name" value="<?php  getPost("Name");?>">
            <?php echo "<p class='text-danger'>$NameE</p>";?>
          </div>
        </div>
        <!-- Type Dropdown -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Type</label>
          <div class="col-sm-4">
            <!-- Configure Model dropdown based on the option user select on this dropdown -->
            <select name="EquipType" onchange="configureDropDownLists(this,document.getElementById('EquipModel'))">
              <option value="">...</option>
              <?php JsontoDropdown('../Script/JSON/EquipType.json');?>
            </select>
            <?php echo "<p class='text-danger'>$NameE</p>";?>
          </div>
        </div>
        <!-- Model Dropdown -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Model</label>
          <div class="col-sm-4">
            <select name="EquipModel" id = "EquipModel">
              <option value="">...</option>
            </select>
            <?php echo "<p class='text-danger'>$NameE</p>";?>
          </div>
        </div>
        <!-- Asset -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Asset</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="Asset" name="Asset" value="<?php  getPost("Asset");?>">
          </div>
        </div>
        <!-- Serial -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Serial</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="Serial" name="Serial" value="<?php getPost("Serial");?>">
          </div>
        </div>
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Active</label>
          <div class="col-sm-4">
            <input type="radio" name="active" value="1"> <font color=#DD4814 >Yes </font>
            <input type="radio" name="active" value="0"> <font color=#DD4814 >No  </font>
            <?php echo "<p class='text-danger'>$ActiveE</p>";?>
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
  <Script>
  var EquipmentTypeArray = [];
  $.ajax({ //http://stackoverflow.com/questions/7346563/loading-local-json-file
    url: "../Script/JSON/EquipType.json",
    //force to handle it as text
    dataType: "text",
    success: function (dataTest) {

      //data downloaded so we call parseJSON function
      //and pass downloaded data
      var EquipTypeJson = $.parseJSON(dataTest);
      //now json variable contains data in json format
      //let's display a few items
      $.each(EquipTypeJson, function (i, jsonObjectList) {
        //console.log(jsonObjectList['id']);
        EquipmentTypeArray.push([jsonObjectList['id'],jsonObjectList['Type'],jsonObjectList['Model']]);
        console.log(jsonObjectList['Type']);
      });
    }
  });

  function configureDropDownLists(EquipType,EquipModel) {//Function called when dropdown value change
    EquipModel.options.length = 0;
    for (var arrayID in EquipmentTypeArray){
      if (EquipmentTypeArray[arrayID][1] == EquipType.value){
        createOption(EquipModel, EquipmentTypeArray[arrayID][2], EquipmentTypeArray[arrayID][0]);
      }
    }
  }
  function createOption(EquipModel, text, value) {//add option to dropdown
    var opt = document.createElement('option');
    opt.value = value;
    opt.text = text;
    EquipModel.options.add(opt);
  }
  </Script>

</body>
</html>
