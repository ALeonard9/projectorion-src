$(document).ready(function() { // begin document ready

    $('#list-items').sortable({
    axis: 'y',
    update: function() {
    var start_rank = $( "#rank" ).val();
    var prep = "&rank=".concat(start_rank)
    var table = $( "#table" ).val();
    var prep1 = "&table=".concat(table)
    var data_to_send = $('#list-items').sortable("serialize");
    var adam = data_to_send.concat( prep+prep1 );
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "../ajax/reorder.ajax.php",
        data: adam
        });
    }
    });

}); // end document ready
