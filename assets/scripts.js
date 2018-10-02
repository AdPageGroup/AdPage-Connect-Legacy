jQuery(document).ready(function($) {
   
    $('.button-connect-campaign').click(function(e) {
       
        e.preventDefault();
        
        $('.modal form input[name="hash"]').val(
            $(this).attr('data-hash')
        );
        
        $('.modals').show();
        
    });
    
    $('.modal form').submit(function(e) {
       
        e.preventDefault();
        
        $('.notification').hide();
        $('.notification-busy').show();
        
        $.ajax({
            type: 'POST',
            url: '/adpgc-connect',
            data: $('.modal form').serialize(),
            dateType: 'JSON',
            success: function(response) {
                
                $('.notification').hide();
                
                if (response.ok == true) {
                    
                    $('.notification-success').show();
                    
                    setTimeout(function() {
                        window.location.replace('/wp-admin/admin.php?page=adpage');
                    }, 2000);
                    
                }
                else {
                    
                    $('.notification-error i').text(response.error);
                    $('.notification-error').show();
                    
                }

            },
            error: function() {

                alert('Could not execute your request. Please try again later!');

            }
        });
        
    });
    
    $('[data-campaign-hash] a.button-delete').click(function(e) {
        
        e.preventDefault();
        
        var campaignHash = $(this).attr('data-hash');
        
        $.ajax({
            type: 'GET',
            url: '/adpgc-disconnect',
            data: {
                hash: campaignHash
            },
            dateType: 'JSON',
            success: function(response) {
                
                if (response.ok == true) {

                    $('[data-campaign-hash="' + campaignHash + '"]').fadeOut(500, function() {
                        $('[data-campaign-hash="' + campaignHash + '"]').remove();
                    });
                    
                }
                else {
                    
                    alert(response.error);
                    
                }

            },
            error: function() {

                alert('Could not execute your request. Please try again later!');

            }
        });
        
    });
    
});