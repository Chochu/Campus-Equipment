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

  <script type="text/javascript" src="ProjectOneV2/Script/JSON/buiding.json">
  function configureDropDownLists(ddl1,ddl2) {

    switch (ddl1.value) {
      case '1':
      ddl2.options.length = 0;
      for (i = 0; i < colours.length; i++) {
        createOption(ddl2, colours[i], colours[i]);
      }
      break;
      case '10':
      ddl2.options.length = 0;
      for (i = 0; i < shapes.length; i++) {
        createOption(ddl2, shapes[i], shapes[i]);
      }
      break;
      case '13':
      ddl2.options.length = 0;
      for (i = 0; i < names.length; i++) {
        createOption(ddl2, names[i], names[i]);
      }
      break;
      default:
      ddl2.options.length = 0;
      break;
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
