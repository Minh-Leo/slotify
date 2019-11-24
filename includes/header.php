<?php
include "includes/config.php";
include "includes/classes/Artist.php";
include "includes/classes/Album.php";
include "includes/classes/Song.php";

// To log out manually include this
// session_destroy();

if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
    echo "<script>userLoggedIn = '$userLoggedIn';</script>";
} else {
    header("Location: register.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/css/index.css">
  <title>Slotify Music</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src='assets/js/script.js'></script>
</head>
<body>


  <div id="mainContainer">

    <div id="topContainer">
      <?php include "includes/navBarContainer.php";?>

      <div id="mainViewContainer">
        <div id="mainContent">