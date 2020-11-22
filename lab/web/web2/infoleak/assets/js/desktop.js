//Remove elements when mobile
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  $('.desktop').attr('id', 'hide');
} else {
  $('.mobile').attr('id', 'hide');
}
$(window).resize(function() {
  if ($(window).width() < 760){
    $('.mobile').removeAttr('id');
    $('.desktop').attr('id', 'hide');
  } else {
    $('.desktop').removeAttr('id');
    $('.mobile').attr('id', 'hide');
  };
});
