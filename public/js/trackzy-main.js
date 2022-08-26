/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

$(document).ready(function () {
    // flash card fade out
    jQuery("#flash-alert").delay(3500).fadeOut("slow");

    // loading for invite form
    $(".loading-btns").on("click", function () {
        $('#invite-loader').css('display', 'block');
    });

    var angle = 0;
    setInterval(function () {
        angle += 3;
        $("#invite-loader").animate(angle);
    }, 50);

    // list rows fading in for users list
    $("tbody tr").each(function (i) {
        $(this).delay(80 * i).fadeIn(500);
    });
    // smooth scroll for anchors
    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 500);
    });

    // bouncing anchor arrow
    function bounce() {
        $('.smooth-anchor i').animate({'top': 20}, {
            duration: 800,
            complete: function () {
                $('.smooth-anchor i').animate({top: 0}, {
                    duration: 500,
                    complete: bounce
                });
            }
        });
    }
    bounce();
});