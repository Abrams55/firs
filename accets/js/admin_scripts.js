
jQuery(document).ready(function($){


   $('#send_sub').submit(function (e) {
        e.preventDefault();

        var params = $('#send_sub').serialize();
       long_pooling( params );
   });


    function long_pooling( params ) {
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                params: params,
                action: 'tm_send_sub'
            },
            beforeSend: function() {
                $('.pool').first().html('load');
            },
            success: function(data) {
                $('.pool').first().html('ok');
                $('.pool').first().removeClass('pool');
                if( data ) {
                    long_pooling( data );
                }
            }
        });
    }
});