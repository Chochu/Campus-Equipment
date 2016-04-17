<html>
<head>
  <?php include 'header.php';
  ?>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-login">


          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <!-- login-form -->
                <form id="login-form" action="login.php" method="post" role="form" style="display: block;" onsubmit="return validatelogin()">

                  <div class="form-group">
                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" required>
                  </div>

                  <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                      </div>
                    </div>
                  </div>
                </form>

                <?php //Display message from "Successfully Logout or Account Created Succuessfully"
                if(array_key_exists('msg',$_GET)){
                  if ($_GET['msg'])
                  {
                    echo '<div class="success_message">' . base64_decode(urldecode($_GET['msg'])) . '</div>';
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
