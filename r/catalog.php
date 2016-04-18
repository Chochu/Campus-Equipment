<html>
<head>
  <?php include 'header.php';
  ?>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
  body{
    background-color: #74828F;
  }
  #banner{
    display:block;
    margin:auto;
  }
  #DPbutton{

    margin: 0 auto;
  }
  a{
    color: #C25B56;
  }
  ul{
    list-style-type: none;
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
  <br><br><br>
    <div class="row">
      <div class="col-md-2" style="margin:10px;"><br><br>

          <ul>
            <li><a href="index.php">Home</a></li><br>
            <li><a href="catalog.php">Browse through our catalog</a></li><br>
            <li><a href="#">Quick Order an album</a></li><br>
            <li><a href="register.php">Join our email</a></li><br>
            <li><a href="#">Contact customer service</a></li><br>
          </ul>

      </div>

      <div class="col-md-6">
        <ul>
          <li>86(the band)</li><br>
          <li><a href="displayProduct.php?productCode=8601">True Life Songs and Pictures</a></li><br>
          <li>Paddlefoot</li><br>
          <li><a href="displayProduct.php?productCode=pf01">Paddlefoot (the first album)</a></li><br>
          <li><a href="displayProduct.php?productCode=pf02">Paddlefoot (the second album)</a></li><br>
          <li>Joe Rut</li><br>
          <li><a href="displayProduct.php?productCode=jr01">Genuine Wood Grained Finish</a></li><br>

        </ul>

      </div>

      <div class="col-md-2">
        <h1>New release:</h1>
        <img src="Image/bb.jpg" width="80" height="80">
        <br>
        <h4>86 (the band)<br> True Life Songs and Pictures</h4> <p>A refreshing mix of rock, country, and bluegrass that will have you stomping your foot and crying in your beer in no time.</p>
      </div>


    </div>


  </div>

</body>
</html>
