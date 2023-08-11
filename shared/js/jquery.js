$(document).ready(function () {

    function generateFormFieldGroup(selectedValue = 'paragraph') {
        var formGroup = $('<div>', {
            class: 'field-group',
            id: fieldcounter++
        }).append(
            $('<section>', { class: 'w-100' }).append(
                $('<input>', {
                    type: 'text',
                    class: 'field-question rounded',
                    placeholder: 'Question'
                }),
                $('<select>', {
                    name: 'field-option',
                    class: 'field-option rounded'
                }).append(
                    $("<option>", { value: "paragraph", text: "Short Paragraph" }),
                    $("<option>", { value: "date", text: "Date" }),
                    $("<option>", { value: "time", text: "Time" }),
                    $("<option>", { value: "choice", text: "Multiple Choice" }),
                    $("<option>", { value: "dropdown", text: "Dropdown" }),
                    $("<option>", { value: "scale", text: "Linear Scale" }),
                    $("<option>", { value: "page", text: "Page" }),
                    $("<option>", { value: "section", text: "Section" })
                ).val(selectedValue)
            )
        );

        if (selectedValue === 'choice' || selectedValue === 'dropdown') {
            appendChoiceOptions(formGroup, selectedValue);

        } else if (selectedValue === 'date' || selectedValue === 'time') {
            appendDateOrTimeInput(formGroup, selectedValue);
        } else if (selectedValue === 'section' || selectedValue === 'page' || selectedValue === 'paragraph') {
            appendSectionOrPageInput(formGroup, selectedValue);
        } else if (selectedValue === 'scale') {
            appendScaleOptions(formGroup);
        }
        renameField(formGroup, selectedValue);


        

        return formGroup;
    }

    function renameField(formGroup, selectedValue){
        var fieldID = formGroup.attr('id');
        var fieldname = 'input-field-'+ selectedValue + '-'+ fieldID;
        formGroup.find('.field-question').attr('name', fieldname);
    }

    function appendChoiceOptions(formGroup, selectedValue) {
        renameField(formGroup, selectedValue);
        formGroup.find('.field-question').attr('placeholder', 'Enter Question');

        var formOptions = $('<section>', {
            class: 'form-options w-100 my-1',
            id: 'form-options' + fieldcounter
        });
        formOptions.append(
            $('<div>', {
                class: 'form-option-container',
                id: 'form-option-container' + fieldcounter
            }),
            $('<a>', { href: '#', class: 'add-option' }).append(
                $('<small>').html(' Add option or <u>import from excel</u>')
            )
        );
        formGroup.append(formOptions);
    }

    function appendDateOrTimeInput(formGroup, selectedValue) {
        renameField(formGroup, selectedValue);
        var formOptions = $('<section>', { class: 'form-options w-100 my-1' });
        formOptions.append(
            $('<input>', {
                type: selectedValue,
                class: 'w-25 rounded'
            })
        );
        formGroup.append(formOptions);
    }

    function appendSectionOrPageInput(formGroup, selectedValue) {
        renameField(formGroup, selectedValue);
        var inputElement;
        if (selectedValue === 'paragraph') {
            inputElement = $('<input>', {
                type: 'text',
                class: 'field-question field-paragraph rounded',
                name: 'field-paragraph_' + fieldcounter,
                placeholder: 'Enter Question'
            });
        } else {
            var inputType = selectedValue === 'section' ? 'field-section' : 'field-page';
            inputElement = $('<input>', {
                type: 'text',
                class: 'field-question ' + inputType + ' rounded',
                name: 'field-' + selectedValue + '_' + fieldcounter,
                placeholder: selectedValue === 'section' ? 'Section Name' : 'Page',
                disabled: selectedValue === 'page'
            });
        }
        formGroup.find('.field-question').replaceWith(inputElement);
    }

    function appendScaleOptions(formGroup) {
        var fieldGroupId = formGroup.attr('id'); // Get the fieldGroupId
        formGroup.find('.field-question').attr('placeholder', 'Enter Scale Category');
        
        var formOptions = $('<section>', { class: 'form-options w-100 my-1' });
    
        var scaleContainer = $('<div>', { class: 'd-flex w-100' });
        var scaleRange = $('<aside>', { class: 'scale-range d-flex flex-row me-5' });
        scaleRange.append(
            $('<select>', { name: 'startselect', class: 'rounded', id: 'start_select' }).append(
                $('<option>', { value: '1', text: '1' })
            ),
            $('<p>').text(' to '),
            $('<select>', { name: 'endselect', class: 'end_select' }).append(
                $('<option>', { value: '1', text: '1' }),
                $('<option>', { value: '2', text: '2' }),
                $('<option>', { value: '3', text: '3' }),
                $('<option>', { value: '4', text: '4' }),
                $('<option>', { value: '5', text: '5' })
            )
        );
        scaleContainer.append(scaleRange);
    
        var scaleLabels = $('<aside>', { class: 'd-flex flex-column w-100 ml-3' });
        scaleLabels.append(
            $('<p>').text('Scale Labels:'),
            $('<div>', { class: 'scale-options d-flex flex-column flex-wrap', id: fieldcounter })
            // You can append more scale-specific elements here if needed
        );
        scaleContainer.append(scaleLabels);
    
        formOptions.append(scaleContainer);
    
        // Generate a unique id for statementsContainer using the fieldGroupId
        var statementsContainerId = 'statements_' + fieldGroupId;
        var statementsContainer = $('<div>', { class: 'statements mt-5', id: statementsContainerId });
        statementsContainer.append($('<p>').html('<u>Statements:</u>'));
        formOptions.append(statementsContainer);
    
        formOptions.append(
            $('<a>', { href: 'javascript:void(0);', class: 'add-scale-statement' }).append(
                $('<small>').html(' Add option or <u>import from excel</u>')
            )
        );
    
        formGroup.append(formOptions);
    }

    function adjustButton(){
        var submit_btn = $('#form').find('#form-submit');
        submit_btn.css('width', '70%');
        $('#form').append(submit_btn);
    }
    

    var fieldcounter = 1;
    var statement_count = 1;
    var option_count = 1;
    var page_count = 1;
    var section_count = 1;

    // Generates default formgroup/question box when the page first loads
    $('#form').append(generateFormFieldGroup('paragraph'));
    adjustButton();

    $('#form').on('change', '.field-option', function () {

        $($(this).closest('.field-group')).find('.form-options').remove();

        // var fieldGroupId = $(this).closest('.field-group').attr('id');
        var selectedValue = $(this).val();
        var formGroup = $(this).closest('.field-group');

        if (selectedValue === 'choice' || selectedValue === 'dropdown') {
            appendChoiceOptions(formGroup, selectedValue);
        } else if (selectedValue === 'date' || selectedValue === 'time') {
            appendDateOrTimeInput(formGroup, selectedValue);
        } else if (selectedValue === 'section' || selectedValue === 'page' || selectedValue === 'paragraph') {
            appendSectionOrPageInput(formGroup, selectedValue);
            renameField(formGroup, selectedValue)
        } else if (selectedValue === 'scale') {
            appendScaleOptions(formGroup);
        }

    });


    // generatese new form-group/question box when add button is clicked on the side bar
    $('#add-btn').click(function () {
        $('#form').append(generateFormFieldGroup('paragraph'));
        adjustButton();

    });
    $('#choice-btn').click(function () {
        $('#form').append(generateFormFieldGroup('choice'));
        adjustButton();

    });
    $('#date-btn').click(function () {
        $('#form').append(generateFormFieldGroup('date'));
        adjustButton();

    });
    $('#time-btn').click(function () {
        $('#form').append(generateFormFieldGroup('time'));
        adjustButton();

    });
    $('#page-btn').click(function () {
        $('#form').append(generateFormFieldGroup('page'));
        adjustButton();

    });
    $('#section-btn').click(function () {
        $('#form').append(generateFormFieldGroup('section'));
        adjustButton();

    });
    $('#text-btn').click(function () {
        $('#form').append(generateFormFieldGroup('paragraph'));
        adjustButton();

    });

    // GENERATING OF INPUT FIELDS ON RESPECTIVE QUESTION TYPE FIELD-GROUP

    $(document).on('click', '.add-scale-statement', function() {
        var fieldGroupId = $(this).closest('.field-group').attr('id');
    
        // Calculate the current statement count based on the existing statements
        var currentStatementCount = $('#' + fieldGroupId + ' .form-options .statements input.scale-statement').length + 1;
    
        var added_statement = $('<input>', {
            type: 'text',
            class: 'scale-statement w-75 mb-1',
            name: 'scale_statement_' + statement_count,
            placeholder: 'Enter scale statement ' + currentStatementCount
        });
        statement_count++;
    
        // Find the statements container within the same field-group and append the input element
        $(this).closest('.form-options').find('.statements').append(added_statement);
    });

    $(document).on('click', '.add-option', function() {
        var fieldGroupId = $(this).closest('.field-group').attr('id');
    
    //     // Calculate the current statement count based on the existing statements
        var currentOptionCount = $('#' + fieldGroupId + ' .form-options .form-option-container input.add-option-input').length + 1;
    
        var added_option = $('<input>', {
            type: 'text',
            class: 'add-option-input w-75 mb-1',
            name: 'add_option_input' + option_count++,
            placeholder: 'Enter option ' + currentOptionCount
        });
        option_count++;
    
    //     // Find the statements container within the same field-group and append the input element
        $(this).closest('.form-options').find('.form-option-container').append(added_option);
    });

    // Uncommented code for adding form options
    $('#form').on('click', '.form-add-option', function () {
        var fieldGroupId = $(this).closest('.field-group').attr('id');
    
        var added_option = $('<input>', {
            type: 'text',
            class: 'form-option-input w-75 mb-1',
            name: 'form_option_input_' + option_count++,
            placeholder: 'Enter option ' + option_count
        });
    
        $('#' + fieldGroupId + ' .form-option-container').append(added_option);
    });

    // Uncommented code for generating scale label text boxes
    $('#form').on('change', '.end_select', function () {
        var endSelectValue = parseInt($(this).val());
        var scaleOptions = '';

        for (var i = 0; i < endSelectValue; i++) {
            scaleOptions += '<input type="text" class="scale-input w-25 mb-2" name="end_scale_range' + i + '" placeholder="placeholder">';
        }

        $(this).closest('.field-group').find('.scale-options').html(scaleOptions);
    });

    

    // function submitFormData(formData) {
    //     $.ajax({
    //         type: 'POST',
    //         url: 'functions.php', // Change this to the correct path of your functions.php file
    //         data: formData, // Serialized form data
    //         success: function (response) {
    //             // Process the response as needed
    //             console.log(response);

    //             // Redirect after successful form submission
    //             // window.location.href = '../forms/functions.php'; // Change this to the desired location
    //         },
    //         error: function () {
    //             console.log('An error occurred.');
    //         }
    //     });
    // }

    $('#form-submit').click(function (e) {
        // e.preventDefault(); // Prevent the default form submission

        // var formData = $('#form').serialize(); // Serialize the form data
        // submitFormData(formData); // Call the function to submit form data via AJAX


        $('.field-group').each(function() {

            var selectedValue = $(this).find('.field-option').val();
            var groupID = $(this).attr('id');
            var fieldname = 'input-field-' + selectedValue + '-' + groupID;
            // var question, type, options, order, page = null;
            var option = null;
            var section = null;

            if(selectedValue == 'paragraph'){
                var inputValue = $(this).find('.field-paragraph').val();
            }
            else if(selectedValue === 'section'){
                var inputValue = $(this).find('.field-section').val()
            }
            else if(selectedValue === 'page'){
                var inputValue = $(this).find('.field-page').val()
            }else{
                var inputValue = $(this).find('.field-question').val()
            }
            
            var formData = {
                sectionID : section,
                question : inputValue,
                type :selectedValue,
                options : option,
                order : groupID
                // page :''
                // insert page here
            }
            console.log(formData)
        });
    });

    
});

    
