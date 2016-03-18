<?php
/*
$_Get - Someone is requesting Data from your application
$_Post - Someone is pushing (inserting/updating/deleting) data from your application
*/
include 'header.php';
function JsontoDropdown($datapath){
  $str = file_get_contents($datapath);
  $json = json_decode($str,true);
  foreach ($json as $value){
    echo "<option value=\"".$value['id']."\">".$value['Name']."</option>";
  }
}

?>
<html>
<body>
  <select id="ddl" onchange="configureDropDownLists(this,document.getElementById('ddl2'))">
    <option value=""></option>
    <?php JsontoDropdown('ProjectOneV2/Script/JSON/campus.json');?>
  </select>

  <select id="ddl2">
  </select>

  <script>
  var gBuildingjson;
  var BuildingArr = [];
  $.ajax({ //http://stackoverflow.com/questions/7346563/loading-local-json-file
         url: "ProjectOneV2/Script/JSON/building.json",
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


  function configureDropDownLists(ddl1,ddl2) {
    ddl2.options.length = 0;
    for (var arrayID in BuildingArr){
      if (BuildingArr[arrayID][2] == ddl1.value){
        createOption(ddl2, BuildingArr[arrayID][1], BuildingArr[arrayID][0]);
      }
    }
  }

  function createOption(ddl, text, value) {
    var opt = document.createElement('option');
    opt.value = value;
    opt.text = text;
    ddl.options.add(opt);
  }
  </script>

</body>
</html>
