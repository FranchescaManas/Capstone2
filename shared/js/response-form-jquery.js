
$(document).ready(function(){
    // console.log(targetID);
    function adjustButton(){
        var submit_btn = $('#form').find('#response-submit');
        submit_btn.css('width', '70%');
        $('#form').append(submit_btn);
    }

    var currentSection = null;
    var currentDateTime = moment().format('YYYY-MM-DD HH:mm:ss');
    
    $('.form-response-group').each(function(){
        if($(this).hasClass('section')){
            currentSection = $(this);
        } else if (currentSection !== null){
            currentSection.append($(this));
        }
        adjustButton();
    })
    
    $('#response-submit').click(function() {
    
        var formData = {
            form_id: formID,
            user_id: userID,
            target_id: targetID,
            submission_date: currentDateTime,
            response: []
        };
    
        $('.form-response-group').each(function() {
            // console.log($(this).attr('class'));
    
            
            var questionType = $(this).hasClass('choice')
                ? 'choice'
                : $(this).hasClass('paragraph')
                ? 'paragraph'
                : $(this).hasClass('dropdown')
                ? 'dropdown'
                : $(this).hasClass('date')
                ? 'date'
                : $(this).hasClass('time')
                ? 'time'
                : $(this).hasClass('textbox')
                ? 'textbox'
                : $(this).hasClass('scale')
                ? 'scale'
                : null;

            if (questionType) {
                formData.response.push({
                    question_type: questionType,
                    question_id: $(this).attr('id'),
                    response_value: getResponseValue($(this))
                });
                
            }
            
        });
    
        
        // console.log(JSON.stringify(formData));
        $.ajax({
            type: 'POST',
            url: './event-listener.php', // URL to your PHP script
            data: { 
                data: JSON.stringify(formData),
                action: JSON.stringify({ 'action': 'insert response', 'role': role })
            },
            success: function(response) {
                // console.log(response);
                var cleanedResponse = response.replace(/\s/g, '');
                console.log(cleanedResponse);
                // Handle the response from the server if needed
                if(cleanedResponse === 'success'){
                    window.location.href = '../forms/form-complete.php';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle errors here
            }
        });
    });
    
    function getResponseValue(groupElement) {
        var response = {};
    
        if (groupElement.hasClass('choice')) {
            response.selected_choice = groupElement.find('input[type="radio"]:checked').val();
        } else if (groupElement.hasClass('paragraph')) {
            response.paragraph_response = groupElement.find('textarea').val();
        } else if (groupElement.hasClass('dropdown')) {
            response.selected_option = groupElement.find('select').val();
        } else if (groupElement.hasClass('date')) {
            response.date_response = groupElement.find('input[type="date"]').val();
        } else if (groupElement.hasClass('time')) {
            response.time_response = groupElement.find('input[type="time"]').val();
        } else if (groupElement.hasClass('scale')) {
            response.scale_responses = getScaleResponses(groupElement);
        } else if (groupElement.hasClass('textbox')) {
            response.textbox_response = groupElement.find('input[type="text"]').val();
        }
    
        return response;
    }
    
    function getScaleResponses(scaleElement) {
        var scaleResponses = {};
    
        scaleElement.find('.scale-td.scale-statement').each(function() {
            var statement = $(this).text().trim();
            var response = scaleElement.find('input[type="radio"]:checked', $(this).closest('.scale-tr')).val();
            scaleResponses[statement] = response;
        });
    
        return scaleResponses;
    }
    
});