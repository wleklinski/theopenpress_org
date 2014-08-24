$(function() {
  FastClick.attach(document.body);

  $('.nav-toggle').on('click', function() {
    $('html').toggleClass('nav-open');
  });
});
