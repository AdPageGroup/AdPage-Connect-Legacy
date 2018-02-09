jQuery(document).ready(function($) {
    
    $('.connect_campaign').click(function(e) {
    
        e.preventDefault();
        
        $('.connect-set form input[name="hash"]').val($(this).attr('data-hash'));
        
        $('.connect-set').show();
    
    });
    
    $('.connect-set form input[name="path"]').keyup(function() {
    
        $('.connect-domain').html(siteDomain + '/' + $('.connect-set form input[name="path"]').val());
    
    });

});