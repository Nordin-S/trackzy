$(document).ready(function () {
    // flash card fade out
    jQuery("#flash-alert").delay(2500).fadeOut("slow");

    $("#invite").on("click", function(){
        $('#invite-loader').css('display', 'block');
    });

    var angle = 0;
    setInterval(function () {
        angle += 3;
        $("#invite-loader").animate(angle);
    }, 50);

    // list rows fading in
    $("tbody tr").each(function (i) {
        $(this).delay(0 * i).fadeIn(500);
    });
});