
$(document).ready(function(){

    $('.form-response-group').each(function () {
        var groupID = $(this).attr('id');
        var type = $(this).attr('class').split(' ')[1];
        var fieldname;

        if (type === 'paragraph') {
            // fieldname = 'field-response-' + type + '-' + groupID;
            // $(this).find('textarea').attr('name', fieldname);
        }
        if (type === 'choice') {
            // fieldname = 'field-response-' + type + '-' + groupID;
            // $(this).find('textarea').attr('name', fieldname);
        }
    });
});