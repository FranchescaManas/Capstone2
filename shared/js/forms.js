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
                    // console.log(response);
                    var cleanedResponse = response.replace(/\s/g, '');
                    console.log(cleanedResponse);
                    // Handle the response from the server if needed
                    if(cleanedResponse === 'success'){
                        alert('form deleted');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    // Handle errors here
                }
            });
        }
    });
    $('#save-permission').click(function () {
        var selectedFormID = $('#form-select').val();
        var canAccess = $('#canAccess').prop('checked');
        var canViewResults = $('#canViewResults').prop('checked');
        var canModify = $('#canModify').prop('checked');
        var respondents = [];
    
        $("input[name='respondents[]']:checked").each(function () {
            respondents.push($(this).val());
        });
    
        var permissionData = {
            formID: selectedFormID,
            can_access: canAccess,
            can_view_results: canViewResults,
            can_modify: canModify,
            role: role
        };
    
        updatePermission(permissionData);
    });
});