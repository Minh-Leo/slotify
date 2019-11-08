<!DOCTYPE html>

<?php

include "includes/config.php";
include "includes/classes/Account.php";
include "includes/classes/Constants.php";
$account = new Account($con);

include "includes/handlers/register-handler.php";
include "includes/handlers/login-handler.php";

function getInputValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="assets/css/register.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="assets/js/register.js"></script>
  <title>Welcome to Slotify</title>
</head>
<body>
  <?php
if (isset($_POST['registerButton'])) {
    echo "<script>
                $(document).ready(function() {

                  $('#loginForm').hide();
                  $('#registerForm').show();
                })
              </script>";
} else {
    echo "<script>
      $(document).ready(function() {

        $('#loginForm').show();
        $('#registerForm').hide();
      })
    </script>";
}
?>


  <div id="background">

    <div id="loginContainer">
      <div id="inputContainer">
        <form action="" id="loginForm" action='register.php' method='POST'>
          <h2>Login to your account</h2>
          <p>
            <?php echo $account->getError(Constants::$loginFailed); ?>
            <label for="loginUsername">Username</label>
            <input type="text" id='loginUsername' name='loginUsername' placeholder='e.g JohnDoe' value='<?php getInputValue('loginUsername')?>' required>
          </p>
          <p>
            <label for="loginPassword">Password</label>
            <input type="password" id='loginPassword' name='loginPassword' value='<?php getInputValue('loginPassword')?>' required>
          </p>
          <button type='submit' name='loginButton'>LOG IN</button>

          <div class="hasAccountText">
            <span id="hideLogin">Don't have an account yet? Sign up here.</span>
          </div>
        </form>

        <form action="" id="registerForm" action='register.php' method='POST'>
          <h2>Create your free account</h2>
          <p>
            <?php echo $account->getError(Constants::$usernameCharacters); ?>
            <?php echo $account->getError(Constants::$usernameTaken); ?>
            <label for="username">Username</label>
            <input type="text" id='username' name='username' placeholder='e.g JohnDoe' value='<?php getInputValue('username')?>' required>
          </p>
          <p>
            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
            <label for="firstname">Firstname</label>
            <input type="text" id='firstname' name='firstname' placeholder='e.g John' value='<?php getInputValue('firstname')?>' required>
          </p>
          <p>
            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
            <label for="lastname">Lastname</label>
            <input type="text" id='lastname' name='lastname' placeholder='e.g Doe' value='<?php getInputValue('lastname')?>' required>
          </p>
          <p>
            <?php echo $account->getError(Constants::$emailInvalid); ?>
            <?php echo $account->getError(Constants::$emailTaken); ?>
            <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
            <label for="email">Email</label>
            <input type="email" id='email' name='email' placeholder='e.g JohnDoe@gmail.com' value='<?php getInputValue('email')?>' required>
          </p>
          <p>
            <label for="email2">Confirm Email</label>
            <input type="email" id='email2' name='email2' placeholder='e.g JohnDoe@gmail.com' value='<?php getInputValue('email2')?>' required>
          </p>

          <p>
            <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
            <?php echo $account->getError(Constants::$passwordCharacters); ?>
            <?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
            <label for="password">Password</label>
            <input type="password" id='password' name='password'  required>
          </p>
          <p>
            <label for="password2">Confirm Password</label>
            <input type="password" id='password2' name='password2'  required>
          </p>
          <button type='submit' name='registerButton'>SIGN UP</button>

          <div class="hasAccountText">
            <span id="hideRegister">Already have an account? Log in here.</span>
          </div>
        </form>
      </div>

      <div id="loginText">
        <h1>Get great music, right now!</h1>
        <h2>Listen to over thousand songs, for free</h2>
        <ul>
          <li>Discover great music that suits your taste.</li>
          <li>Create and customize your own playlist.</li>
          <li>Access everywhere, with or without Internet.</li>
        </ul>
      </div>

    </div>
  </div>



</body>
</html>
