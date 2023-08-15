
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
    
        console.log(JSON.stringify(formData));
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
    
    // function insertFormResponses($jsonData) {
    //     $data = json_decode($jsonData, true);
    
    //     foreach ($data['sections'] as $section) {
    //         $sectionId = $section['section_id'];
            
    //         foreach ($section['question'] as $question) {
    //             $questionId = $question['question_id'];
    //             $responseType = $question['question_type'];
                
    //             switch ($responseType) {
    //                 case 'date':
    //                     $responseValue = $question['response']['date_response'];
    //                     break;
    //                 case 'choice':
    //                     $responseValue = $question['response']['selected_choice'];
    //                     break;
    //                 case 'paragraph':
    //                     $responseValue = $question['response']['text_response'];
    //                     break;
    //                 case 'dropdown':
    //                     $responseValue = $question['response']['selected_option'];
    //                     break;
    //                 case 'time':
    //                     $responseValue = $question['response']['time_response'];
    //                     break;
    //                 case 'scale':
    //                     $scaleResponses = $question['response']['scale_responses'];
    //                     $responseValue = json_encode($scaleResponses);
    //                     break;
    //                 default:
    //                     $responseValue = null;
    //                     break;
    //             }
                
    //             // Insert the response into the form_response table
    //             // Replace this with your actual database insert code
    //             // Example: mysqli_query($conn, "INSERT INTO form_response (form_id, section_id, question_id, response_value, response_type) VALUES ('$formId', '$sectionId', '$questionId', '$responseValue', '$responseType')");
    //         }
    //     }
    // }
    
    // $jsonData = '{"form_id":1,"user_id":1,"submission_date":"2023-08-15 12:20:59","sections":[{"section_id":"1","question":[{"question_type":"date","question_id":"3","response":{"date_response":"2023-08-29"}},{"question_type":"choice","question_id":"2","response":{"selected_choice":"Sample Choice 1"}},{"question_type":"paragraph","question_id":"1","response":{"text_response":"sadada"}},{"question_type":"dropdown","question_id":"5","response":{"selected_option":"Sample dropdown 2"}}]},{"section_id":"2","question":[{"question_type":"time","question_id":"4","response":{"time_response":"00:24"}},{"question_type":"scale","question_id":"6","response":{"scale_responses":{"sample statement1":"labeloption2","sample statement2":"labeloption2","sample statement 3":"labeloption2"}}}]}]}';
    
    // insertFormResponses($jsonData);
    
});