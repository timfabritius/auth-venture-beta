<?php
  include('classes/DB.php');

  $errors = '';

  if (isset($_POST['createaccount'])) {
          $username = $_POST['username'];
          $password = $_POST['password'];
          $email = $_POST['email'];

          if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                  if (strlen($username) >= 3 && strlen($username) <= 32) {

                          if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

                                  if (strlen($password) >= 6 && strlen($password) <= 60) {

                                  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                  if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

                                          DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
                                          Header('Location: login.php');
                                  } else {
                                          $errors .= '<div class="alert alert-danger" role="alert">Email is already used!</div>';
                                  }
                          } else {
                                          $errors .= '<div class="alert alert-danger" role="alert">Invalid email!</div>';
                                  }
                          } else {
                                  $errors .= '<div class="alert alert-danger" role="alert">Invalid password!</div>';
                          }
                          } else {
                                  $errors .= '<div class="alert alert-danger" role="alert">Invalid username!</div>';
                          }
                  } else {
                          $errors .= '<div class="alert alert-danger" role="alert">Invalid username!</div>';
                  }

          } else {
                  $errors .= '<div class="alert alert-danger" role="alert">User already exists!</div>';
          }
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Tim Fabritius">
    <title>Auth Venture</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="login-dark">
        <form action="create-account.php" method="post">
            <h2 class="sr-only">Registeration Form</h2>
            <div class="errors">
              <?php if(isset($errors)){
                echo $errors;
              } ?>
            </div>
            <div class="illustration"><i><img src="logo.png" id="logoimg" alt="logo"></i></div>
            <div class="form-group"><input class="form-control" type="text" name="username" required="" placeholder="Username" maxlength="32" minlength="3"></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><button name="createaccount" class="btn btn-primary btn-block" type="submit">Create Account</button>
            <a class="btn btn-danger btn-block" role="button" href="login.php">Cancel</a></div>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
