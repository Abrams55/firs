jQuery(document).ready(function($){

    $('#mn_sub').submit(function(e){
        e.preventDefault();

        var data = $(this).serialize();

        console.log(data);
        $.ajax({
            type: 'POST',
            url: mn_ajax.url,
            data: {
                params: data,
                nonce: mn_ajax.nonce,
                action: 'add_subscribers',
            },
            nonce: '',
            beforeSend: function(){

            },
            success: function(data){
                $('.res').html(data.msg);
            },
            error: function(){

            }
        });
    });

});