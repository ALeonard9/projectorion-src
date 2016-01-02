$(document).ready(function() { // begin document ready

    $('#list-items').sortable({
    axis: 'y',
    update: function() {
    var data_to_send = $('#list-items').sortable("serialize");
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "../ajax/reorder.ajax.php",
        data: data_to_send
        });
    }
    });

    $('li').on('mouseover',function() {
    $(this).css(
        {
            'backgroundColor' : 'rgb(204, 255, 204);',
            'color' : 'white'
        }
    );
    }).on('mouseout' ,function() {
        $('li').css(
            {
                'backgroundColor' : '',
                'color' : ''
            }
        )
    });

}); // end document ready
