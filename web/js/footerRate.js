$(document).ready(function(){
    var prevPane = 'SGD';

    $('#footer-' + prevPane).fadeIn();

    $('#footer-currency-selector').on('change', function() {
        var selected = this.value;

        $('#footer-' + prevPane).fadeOut(300, function(){
            $('#footer-' + selected).fadeIn();
        });
        prevPane = selected;
         
    });
});
