
$(document).ready(function(){
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
            form_id: 1,
            user_id: 1,
            submission_date: currentDateTime,
            sections: []
        };
    
        var currentSectionData = null;
    
        $('.form-response-group').each(function() {
            var isSection = $(this).hasClass('section');
    
            if (isSection) {
                if (currentSectionData) {
                    formData.sections.push(currentSectionData);
                }
                currentSectionData = {
                    section_id: $(this).attr('id'),
                    question: []
                };
            } else {
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
                    : $(this).hasClass('scale')
                    ? 'scale'
                    : null;
    
                if (questionType) {
                    currentSectionData.question.push({
                        question_type: questionType,
                        question_id: $(this).attr('id'),
                        response: getResponseValue($(this))
                    });
                }
            }
        });
    
        if (currentSectionData) {
            formData.sections.push(currentSectionData);
        }
    
        // console.log(JSON.stringify(formData));
        $.ajax({
            type: 'POST',
            url: 'functions.php', // URL to your PHP script
            data: { 
                data: JSON.stringify(formData),
                action: JSON.stringify({ 'action': 'insert', 'role': 'student' })
            },
            success: function(response) {
                // console.log(response);
                var cleanedResponse = response.replace(/\s/g, '');
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
            response.text_response = groupElement.find('textarea').val();
        } else if (groupElement.hasClass('dropdown')) {
            response.selected_option = groupElement.find('select').val();
        } else if (groupElement.hasClass('date')) {
            response.date_response = groupElement.find('input[type="date"]').val();
        } else if (groupElement.hasClass('time')) {
            response.time_response = groupElement.find('input[type="time"]').val();
        } else if (groupElement.hasClass('scale')) {
            response.scale_responses = getScaleResponses(groupElement);
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