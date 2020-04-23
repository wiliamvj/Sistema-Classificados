$(".medium-9").hover(function() {
    $(this).css("background", "#eee");
    $(this).find('h3').css("text-decoration", "underline");

}, function() {
    $(this).css("background", "#fff");
    $(this).find('h3').css("text-decoration", "none");
});

