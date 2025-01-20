(function ($) {
    $(document).ready(function(){
       $('#linktoLoginAt-booknow').click(function(){
        $('#booknow-forms-login-bg').fadeIn(300);
       })
       $('#booknow-forms-login-closebutton').click(function(){
        $('#booknow-forms-login-bg').fadeOut(400);
       })
       
    });
})(jQuery);