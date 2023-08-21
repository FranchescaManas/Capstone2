$(document).ready(function() {
    var userRole = $('.user-role').text();

    if(userRole === 'superadmin' || userRole ==='admin'){
        $('.kebab-options').hide();
        $('.kebab-icon').click(function() {
            var kebabMenu = $(this).parent();
            var kebabOptions = kebabMenu.find('.kebab-options');
            kebabOptions.toggle();
        });
    }else{
        $('.kebab-menu').hide();
    }


   
});