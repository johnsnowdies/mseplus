$(document).ready(function () {
    $('.navbar-minimalize').click(function () {
        $.get("/core/sidebar");
    });
});