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
  <title>Welcome to Slotify</title>
</head>
<body>
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
      <button type='submit' name='loginButton'>Log In</button>
    </form>

    <form action="" id="loginForm" action='register.php' method='POST'>
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
      <button type='submit' name='registerButton'>Sign Up</button>
    </form>
  </div>
</body>
</html>
