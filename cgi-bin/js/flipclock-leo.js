var clocks = [];
var clockdex;

$(document).ready(function() {
 $('.clock').each(function() {
   clocks.push($(this).FlipClock(3600, {
                 countdown: true,
                 clockFace: 'MinuteCounter',
                 autoStart: false
     }));
  });

  $('.ssb').click(function(e) {
    clockdex = $(this).parent().attr('clock');
    if ($(this).hasClass('start')){
      $(this).html('Stop');
      $(this).removeClass('start').addClass('stop');
      clocks[clockdex].start();
    } else {
      $(this).html('Start');
      $(this).removeClass('stop').addClass('start');
      clocks[clockdex].stop();
    }
  });

  $('.lose').click(function(e) {
    clockdex = $(this).parent().attr('clock');
    var time  = clocks[clockdex].getTime();
    var minutes = $(this).siblings('.mins');
    var seconds = (minutes.val() * 60) -1;
    var newTime = time - seconds;
    if ( newTime < 0){
        newTime = 0;
    }
    clocks[clockdex].setTime(newTime);
  });

  $('.gain').click(function(e) {
    clockdex = $(this).parent().attr('clock');
    var time  = clocks[clockdex].getTime();
    var minutes = $(this).siblings('.mins');
    var seconds = (minutes.val() * 60) -1;
    var newTime = parseFloat(time) + parseFloat(seconds);
    clocks[clockdex].setTime(newTime);
  });
  $('.reset').click(function(e) {
    clockdex = $(this).parent().attr('clock');
    if ($('#ssb').hasClass('stop')){
      $('#ssb').html('Start');
      $('#ssb').removeClass('stop').addClass('start');
    }
    clocks[clockdex].stop()
    clocks[clockdex].setTime(3600);
  });

});
