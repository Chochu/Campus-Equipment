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

          <!-- Tab [login][Register] -->
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <a href="#" class="active" id="login-form-link">Login</a>
              </div>
              <div class="col-xs-6">
                <a href="#" id="register-form-link">Register</a>
              </div>
            </div>
            <hr>
          </div>

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

                <!-- register-form -->
                <form id="register-form" action="register.php" method="post" role="form" style="display: none;" onsubmit="return validateregister()">

                  <div class="form-group"> 
                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" required>
                  </div>

                  <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
                  </div>

                  <div class="form-group">
                    <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" required>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <!-- disable button to prevent registertion -->
                        <input type="submit" disabled="true" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                        <p>Registertion is disable at this time </p>
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
  <script>
  //click event use for changing login form to register-form
  $(function() {
    $('#login-form-link').click(function(e) {
      $("#login-form").delay(100).fadeIn(100);
      $("#register-form").fadeOut(100);
      $('#register-form-link').removeClass('active');
      $(this).addClass('active');
      e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
      $("#register-form").delay(100).fadeIn(100);
      $("#login-form").fadeOut(100);
      $('#login-form-link').removeClass('active');
      $(this).addClass('active');
      e.preventDefault();
    });
  }
);

</script>
</body>
</html>
