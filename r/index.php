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
            <li><a href="#">Home</a></li><br>
            <li><a href="catalog.php">Browse through our catalog</a></li><br>
            <li><a href="#">Quick Order an album</a></li><br>
            <li><a href="register.php">Join our email</a></li><br>
            <li><a href="#">Contact customer service</a></li><br>
          </ul>

      </div>

      <div class="col-md-6">
        <td width="404" valign="top"> <h1>Welcome to Fresh Corn Records!</h1> <?php session_start(); echo $_SESSION['id'];?> <p> Thanks for visiting. Make yourself at home. Feel free to browse through our musical catalog. When you do, you can listen to samples from the albums on our site, or you can download selected sound files and listen to them later. We think our catalog contains some great music, and we hope you like it as much as we do. </p> <p> If you find an album that you like, we hope that you'll use this site to order it. Most of the albums we carry aren't available anywhere else! </p> </td>
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
