<html>
<head>
  <?php include 'header.php';
  ?>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
  body{
    background-color: #566573;
  }
  #banner{
    display:block;
    margin:auto;
  }
  #DPbutton{

    margin: 0 auto;
  }

  </style>
</head>
<body>
  <div class="container-fluid">

    <div class="row">
      <div>
        <img id = "banner" src = "Image/banner.jpg" alt = "Banner"/>
      </div>
    </div>

    <div class="row">
      <div class="col-md-1 col-md-offset-2">
        <h1> Products </h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <a href="process.php" class="btn btn-default" id = "DPbutton">Process Invoices</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <a href="Maintain.php" class="btn btn-default" id = "DPbutton">Display Reports</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <a href="Maintain.php" class="btn btn-default" id = "DPbutton">Maintain Products</a>
      </div>
    </div>
  </div>

</body>
</html>
