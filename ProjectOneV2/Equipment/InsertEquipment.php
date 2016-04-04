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
$EquipmentTypeIDE = $NameE = $ActiveE= "";
$Name = $EquipmentTypeID = $Asset = $Serial = $Active =  "";
$str = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['EquipModel'])) {
    $EquipmentTypeIDE = "Equipment Type ID is required";
  } else {
    $EquipmentTypeID = TrimText($_POST["EquipModel"]);
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
  $Asset = TrimText($_POST["Asset"]);
  $Serial = TrimText($_POST["Serial"]);

  if($EquipmentTypeID != ""){
    // Connection Data

    require '../Credential.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
    INSERT INTO equipment(Name, equipmenttype, Asset, Serial, Active)
    VALUES
    ('".$Name."',
    '".$EquipmentTypeID."',
    '".$Asset."',
    '".$Serial."',
    '".$Active."')";


    if ($conn->query($sql) === TRUE) {
      $id = $conn->insert_id;
      echo '<script type="text/javascript">';
      echo 'alert("Update Successfully");';
      echo 'window.location.href = "../Deploy/Deploy.php?id='.$id.'";';
      echo '</script>';
    } else {
      $str = "Error : " . $sql . "<br>" . $conn->error;
    }
  }
}

function TrimText($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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
<meta charset="UTF-8">
<div class="menu">
  <?php include 'header.php'; ?>
  <br><br>
</div>

</head>
<body>

  <h2>Insert to Equipment Database</h2>
  <p><span class="error">* required field.</span></p>

  <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- Name -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $Name;?>">
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
        <input type="text" class="form-control" id="Asset" name="Asset" value="<?php echo $Asset;?>">
      </div>
    </div>
    <!-- Serial -->
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Serial</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="Serial" name="Serial" value="<?php echo $Serial;?>">
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Active</label>
      <div class="col-sm-4">
        <input type="radio" name="active" value="1"> Yes
        <input type="radio" name="active" value="0"> No
      </div>
    </div>
    <div id = "deploy" class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <input id="submit" name="submit" type="submit" value="Submit" class="btn btn-primary">
      </div>
    </div>

  </form>
  <?php
  echo "<h1>" .  $str . "</h1>";
  ?>
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
