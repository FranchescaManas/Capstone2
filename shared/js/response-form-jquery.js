
$(document).ready(function(){
    var currentSection = null;
    $('.form-response-group').each(function(){
        if($(this).hasClass('section')){
            currentSection = $(this);
        } else if (currentSection !== null){
            currentSection.append($(this));
        }
    })
});