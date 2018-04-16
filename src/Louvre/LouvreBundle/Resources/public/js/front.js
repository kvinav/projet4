$(function () {

    var listmenuheader = $("#listmenuheader");
    listmenuheader.hide();

    $(".menu").on('click', function() {
        listmenuheader.toggle(200);

    });


});