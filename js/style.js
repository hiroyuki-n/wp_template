
$(function() {
  $('.drawer_button').on('click', function () {
    $('.drawer_button .inner').toggleClass('active');
    $('.sp_nav').toggleClass('active');
  });
  $('.sp_nav a').on('click', function () {
    $('.drawer_button .inner').toggleClass('active');
    $(".sp_nav").toggleClass('active');
  })
});



    $(function() {
        $('a[href^="#"]').click(function() {
            var adjust = 0;
            var speed = 500;
            var href = $(this).attr("href");
            var target = $(href == "#" || href == "" ? 'html' : href);
            var position = target.offset().top + adjust;
            $("html, body").animate({
                scrollTop: position
            }, speed, "swing");
            return false;
        });
    });
