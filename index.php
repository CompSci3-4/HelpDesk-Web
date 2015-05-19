<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<?php require_once("globals.php"); ?>
<html lang="en">
<!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <link rel="stylesheet" href="css/loginStyle.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body>
  <section class="container">
    <div class="body"> </div>
    <div class="login">
      <h1>LJHS Help Desk</h1>
      <form method="post" action="login.php">
        <p>
          <input type="text" name="user" value="" placeholder="Username">
        </p>
        <p>
          <input type="password" name="password" value="" placeholder="Password">
        </p>
        <p class="submit">
          <input type="submit" name="commit" value="Login">
        </p>
      </form>
      <form action="<?php echo $config['root_directory'] . '/registration.html'?>" method="get">
        <input type="submit" value="Sign Up" id="sign_up" />
    </form>
    </div>
  </section>
</body>

</html>