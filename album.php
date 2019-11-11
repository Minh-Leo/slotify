<?php include "includes/header.php";?>


      <!-- Content main -->

<?php

if (isset($_GET['id'])) {
    $albumId = $_GET['id'];
} else {
    header("Location: index.php");
}

$album = new Album($con, $albumId);

$artist = $album->getArtist();

?>

<div class="entityInfo">
  <div class="leftSection">
    <img src="<?php echo $album->getArtworkPath(); ?>" alt="<?php echo $album->getTitle(); ?>">
  </div>

  <div class="rightSection">
    <h2><?php echo $album->getTitle(); ?></h2>
    <p>By -<?php echo $artist->getName(); ?>-</p>
    <p><?php echo $album->getNumberOfSongs(); ?> Tracks</p>
  </div>
</div>

<div class="tracklistContainer">
  <ul class="tracklist">

  <?php
$songIdArray = $album->getSongIds();

$i = 1;
foreach ($songIdArray as $songId) {
    $albumSong = new Song($con, $songId);
    $albumArtist = $albumSong->getArtist();

    echo "<li class='tracklistRow'>
    <div class='trackCount'>
      <img class='play' src='assets/images/icons/play2.png'>
      <span class='number'>$i</span>
    </div>

    <div class='trackInfo'>
      <span class='trackName'>" . $albumSong->getTitle() . "</span>
      <span class='artisName'>" . $albumArtist->getName() . "</span>
    </div>

    <div class='trackOptions'>
      <img src='assets/images/icons/more.png' alt='' class='optionsButton'>
    </div>

    <div class='trackDuration'>
      <span class='duration'>" . $albumSong->getDuration() . "</span>
    </div>

    </li>";

    $i++;

}
?>
  </ul>
</div>

      <!-- Content end -->

<?php include "includes/footer.php";?>
