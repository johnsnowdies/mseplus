$(document).ready(function(){
    $.pjax.defaults.timeout = 5000;
    var updateInterval = 10000; //Fetch data ever x milliseconds
    
    function updateGridView(){
        $.pjax.reload({container:'#stocks'});
    }

    setInterval(updateGridView, updateInterval);
    
    //http://localhost:3221/core/currency?name=SGD
    $('#stock-currency').on('change', function() {
        var selected = this.value;
        $.get("/core/currency", {"name": selected},function(){
            updateGridView()
        });
    });
});

$(document).on('pjax:error', function(event, xhr) {
    console.log(xhr.responseText);
    event.preventDefault();
});