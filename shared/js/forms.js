$(document).ready(function() {
    var userRole = $('.user-role').text();
    $('.kebab-options').hide();
    $('.kebab-icon').click(function() {
        var kebabOptions = $(this).parent().find('.kebab-options');
        kebabOptions.toggle();
    });
    
    var access = formAccessData;
    $('.form-card').each(function() {
        var formId = $(this).attr('id');
        console.log(access[formId]);

        if (access[formId] === 'can modify') {
            $(this).find('.kebab-menu').show();
            console.log('show');
        }else{
            $(this).find('.kebab-menu').hide();

        }
    });
    

    $('button[name="delete"]').click(function() {
        var confirmDelete = confirm("are your sure you want to delete this form?");

        if(confirmDelete){
            var deleteButtonValue = $(this).val();
            $.ajax({
                type: 'POST',
                url: '../shared/forms/event-listener.php', // URL to your PHP script
                data: { 
                    data: JSON.stringify(deleteButtonValue),
                    action: JSON.stringify({ 'action': 'delete form', 'role': userRole })
                },
                success: function(response) {
                    var cleanedResponse = response.replace(/\s/g, '');
                    console.log(cleanedResponse);
                    if(cleanedResponse === 'success'){
                        alert('form deleted');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

       
    });

    $('#save-permission').click(function(){
        var selectedFormID = $('#form-select').val();
        var canAccess = $('#canAccess').prop('checked');
        var canViewResults = $('#canViewResults').prop('checked');
        var canModify = $('#canModify').prop('checked');
        // var role = $(this).val();
        var respondents = [];

        $("input[name='respondents[]']:checked").each(function () {
            respondents.push($(this).val());
        });

        var permissionData = {
            formID: selectedFormID,
            can_access: canAccess,
            can_view_results: canViewResults,
            can_modify: canModify,
            respondents: respondents
        };

        $.ajax({
            type: 'POST',
            url: '../shared/forms/event-listener.php', // URL to your PHP script
            data: {
                data: JSON.stringify(permissionData),
                action: JSON.stringify({ 'action': 'update permission', 'role': userRole, 'formID': selectedFormID })
            },
            success: function(response) {
                console.log(response);
                
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle errors here
            }
        });
    });
    

});