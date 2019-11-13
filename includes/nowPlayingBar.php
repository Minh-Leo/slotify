<?php
$songQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");
$resultArray = array();

while ($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);

?>

<script>

// Ready?
$(document).ready(function() {
  var newPlaylist = <?php echo $jsonArray; ?>;
  audioElement = new Audio();
  setTrack(newPlaylist[0], newPlaylist, false);
  updateVolumeProgressBar(audioElement.audio);

  $('#nowPlayingBar').on("mousedown touchstart mousemove touchmove", function(e) {
    e.preventDefault();
  })

  // playback
  $('.playbackBar .progressBar').mousedown(function() {
    mouseDown = true;
  });
  $('.playbackBar .progressBar').mousemove(function(e) {
    if (mouseDown == true) {
      //Set time of song, depending on position of mouse
      timeFromOffset(e, this);
    }
  });
  $('.playbackBar .progressBar').mouseup(function(e) {
      timeFromOffset(e, this);
  });

  // volume
  $('.volumeBar .progressBar').mousedown(function() {
    mouseDown = true;
  });
  $('.volumeBar .progressBar').mousemove(function(e) {
    if (mouseDown == true) {
      var percentage = e.offsetX / $(this).width();
      if(percentage >= 0 && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }
    }
  });
  $('.volumeBar .progressBar').mouseup(function(e) {
    var percentage = e.offsetX / $(this).width();
      if(percentage >= 0 && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }
  });

  $(document).mouseup(function() {
    mouseDown = false;
  });
});

function timeFromOffset(mouse, progressBar) {
  var percentage = mouse.offsetX / $(progressBar).width() * 100;
  var seconds = audioElement.audio.duration * (percentage / 100);
  audioElement.setTime(seconds);
}



// put track to playlist
function setTrack(trackId, newPlaylist, play) {
  if(newPlaylist != currentPlaylist) {
    currentPlaylist = newPlaylist;
    shufflePlaylist = currentPlaylist.slice();
    shuffleArray(shufflePlaylist);
  }

  if(shuffle) {
    currentIndex = shufflePlaylist.indexOf(trackId);
  } else {
    currentIndex = currentPlaylist.indexOf(trackId);
  }
  pauseSong();
  $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
    var track = JSON.parse(data);
    $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
      var artist = JSON.parse(data);
      $(".artistName").text(artist.name);
    });
    $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
      var album = JSON.parse(data);
      $(".albumArtwork").attr("src", album.artworkPath);
    });
    $(".trackName").text(track.title);

    audioElement.setTrack(track);
  });
  if(play) {
    audioElement.play();
  }
}

// play & pause button
function playSong() {
  if (audioElement.audio.currentTime == 0) {
    $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
  } else {
  };

  $(".play").hide();
  $(".pause").show();
  audioElement.play();
}
function pauseSong() {
  $(".play").show();
  $(".pause").hide();
  audioElement.pause();
}

// Next & Prev button
function nextSong() {
  if (repeat) {
    audioElement.setTime(0);
    playSong();
    return;
  }

  if(currentIndex == currentPlaylist.length - 1) {
    currentIndex = 0;
  } else {
    currentIndex++;
  }

  var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
  setTrack(trackToPlay, currentPlaylist, true);
  setTimeout(() => {
    playSong();
  }, 100);
}
function prevSong() {
  if (audioElement.audio.currentTime >= 5 || currentIndex == 0) {
    audioElement.setTime(0);
  } else {
    currentIndex--;
    setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    setTimeout(() => {
    playSong();
  }, 100);
  }
}

function setRepeat() {
  repeat = !repeat;
  var imageName = repeat ? "repeat-inactive.png" : "repeat.png";
  var status = repeat ? "Repeat On" : "Repeat Off";
  $(".repeat img").attr("src", "assets/images/icons/"+imageName);
  $(".controlButton.repeat").attr("title", status);
}

function setMute() {
  audioElement.audio.muted = !audioElement.audio.muted;
  var muteIcon = audioElement.audio.muted ? "mute.png" : "volume.png";
  var status = audioElement.audio.muted ? "Mute On" : "Volume";
  $(".volume img").attr("src", "assets/images/icons/"+muteIcon);
  $(".controlButton.volume").attr("title", status);
}

function setShuffle() {
  shuffle = !shuffle;
  var imageName = shuffle ? "shuffle-inactive.png" : "shuffle.png";
  var status = shuffle ? "Shuffle On" : "Shuffle Off";
  $(".shuffle img").attr("src", "assets/images/icons/"+imageName);
  $(".controlButton.shuffle").attr("title", status);

  if(shuffle) {
    shuffleArray(shufflePlaylist);
    currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
  } else {
    currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
  }
}
function shuffleArray(arr) {
  var j, x, i;
  for (i = arr.length; i; i--) {
    j = Math.floor(Math.random() * i);
    x = arr[i - 1];
    arr[i - 1] = arr[j];
    arr[j] = x;
  }
}

</script>

<div id="nowPlayingBar">

        <div id="nowPlayingLeft">
          <div class="content">
            <span class="albumLink">
              <img class="albumArtwork" src="" alt="">
            </span>
            <div class="trackInfo">
              <span class="trackName"></span>
              <span class="artistName"></span>
            </div>
          </div>
        </div>

        <div id="nowPlayingCenter">
          <div class="content playerControls">
            <div class="buttons">
              <button class="controlButton shuffle" title="Shuffle Off" onclick="setShuffle()">
                <img src="assets/images/icons/shuffle.png" alt="Shuffle">
              </button>
              <button class="controlButton prev" title="Previous" onclick="prevSong()">
                <img src="assets/images/icons/prev.png" alt="Previous">
              </button>
              <button class="controlButton play" title="Play" onclick="playSong()">
                <img src="assets/images/icons/play.png" alt="Play">
              </button>
              <button class="controlButton pause" title="Pause" onclick="pauseSong()" style="display: none" >
                <img src="assets/images/icons/pause.png" alt="Pause">
              </button>
              <button class="controlButton next" title="Next" onclick="nextSong()">
                <img src="assets/images/icons/next.png" alt="Next">
              </button>
              <button class="controlButton repeat" title="Repeat Off" onclick="setRepeat()">
                <img src="assets/images/icons/repeat.png" alt="Repeat">
              </button>
            </div>

            <div class="playbackBar">
              <span class="progressTime current">0.00</span>

              <div class="progressBar">
                <div class="progressBarBg">
                  <div class="progress"></div>
                </div>
              </div>

              <span class="progressTime remaining"></span>
            </div>

          </div>
        </div>

        <div id="nowPlayingRight">
          <div class="volumeBar">
            <button class="controlButton volume" title="Volume" onclick="setMute()">
              <img src="assets/images/icons/volume.png" alt="Volume">
            </button>
            <div class="progressBar">
                <div class="progressBarBg">
                  <div class="progress"></div>
                </div>
              </div>
          </div>
        </div>
</div>
