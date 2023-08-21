$(document).ready(function() {
    $('.kebab-options').hide();
    $('.kebab-icon').click(function() {
        var kebabMenu = $(this).parent();
        var kebabOptions = kebabMenu.find('.kebab-options');
        kebabOptions.toggle();
    });
});