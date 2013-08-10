$( "#new-problem" ).click(function() {
    $("#up-header").hide(800);
    $("#problem-create").show(1000);
});

$( "submit-problem" ).click(function() {
    $(".problem-create").hide(1000);
});