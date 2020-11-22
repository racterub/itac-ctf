$(function() {
  // Disable the page until loaded.
  $(window).on('load', function() {
    $('load').remove();
  });
  //scrolling effect
  $.scrollIt({
    topOffset: -85
  });
});
//parallax effect
$('.section100').parallax({ imageSrc: 'assets/img/home-fit.jpg' });
//navbar controller
$(window).scroll(function() {
  if ($(document).scrollTop() >= $(window).height()/6) {
    $('.navbar').addClass('act2').removeClass('act1');
  } else {
    $('.navbar').addClass('act1').removeClass('act2');
  }
});
// hide bar on phone - no functional right now
/*
window.onload = function(){
    setTimeout(function(){
        window.scrollTo(0, 1);
    }, 100);
}
*/
