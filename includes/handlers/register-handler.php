<?php

function sanitizeFormPassword($inputText)
{
    $inputText = strip_tags($inputText);
    return $inputText;
}

function sanitizeFormUsername($inputText)
{
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    return $inputText;
}

function sanitizeFormString($inputText)
{
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}

if (isset($_POST['registerButton'])) {
    // sign up was pressed

    // fix Notice Undefined index 'username'
    // $username = "";
    // if (isset($_POST['username'])) {
    //     $username = sanitizeFormUsername($_POST['userName']);
    // }
    $username = sanitizeFormUsername($_POST['username']);
    $firstname = sanitizeFormString($_POST['firstname']);
    $lastname = sanitizeFormString($_POST['lastname']);
    $email = sanitizeFormString($_POST['email']);
    $email2 = sanitizeFormString($_POST['email2']);
    $password = sanitizeFormPassword($_POST['password']);
    $password2 = sanitizeFormPassword($_POST['password2']);

    $wasSuccessful = $account->register($username, $firstname, $lastname, $email, $email2, $password, $password2);

    if ($wasSuccessful == true) {
        $_SESSION['userLoggedIn'] = $username;

        header("Location: index.php");
    }
}
