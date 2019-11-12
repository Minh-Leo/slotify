var currentPlaylist = [];
var audioElement;

function formatTime(sec) {
  var time = Math.round(sec);
  var minutes = Math.floor(time / 60);
  var seconds = time - minutes * 60;

  var extraZero = seconds < 10 ? "0" : "";

  return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
  $(".progressTime.current").text(formatTime(audio.currentTime));
  $(".progressTime.remaining").text(
    formatTime(audio.duration - audio.currentTime)
  );

  var progress = (audio.currentTime / audio.duration) * 100;
  $(".playbackBar .progress").css("width", progress + "%");
}

function Audio() {
  this.currentlyPlaying;
  this.audio = document.createElement("audio");

  this.audio.addEventListener("canplay", function() {
    $(".progressTime.remaining").text(formatTime(this.duration));
  });
  this.audio.addEventListener("timeupdate", function() {
    if (this.duration) {
      updateTimeProgressBar(this);
    }
  });

  this.setTrack = function(track) {
    this.currentlyPlaying = track;
    this.audio.src = track.path;
  };

  this.play = function() {
    this.audio.play();
  };

  this.pause = function() {
    this.audio.pause();
  };
}
