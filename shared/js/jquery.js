$(document).ready(function() {

    function generateFormFieldGroup() {


        return $('<div>', {
            class: 'field-group', 
            id: fieldcounter++
        }).append(
            $('<section>', {
                class: 'w-100'
            }).append(
                $('<input>', {
                    type: 'text',
                    class: 'field-question rounded',
                    placeholder: 'Question'
                }),
                $('<select>', {
                    name: 'field-option',
                    class: 'field-option rounded'
                }).append(
                    $('<option>', {
                        value: 'short-paragraph',
                        text: 'Short Paragraph'
                    }),
                    $('<option>', {
                        value: 'date',
                        text: 'Date'
                    }),
                    $('<option>', {
                        value: 'time',
                        text: 'Time'
                    }),
                    $('<option>', {
                        value: 'choice',
                        text: 'Multiple Choice'
                    }),
                    $('<option>', {
                        value: 'dropdown',
                        text: 'Dropdown'
                    }),
                    $('<option>', {
                        value: 'scale',
                        text: 'Linear Scale'
                    }),
                    $('<option>', {
                        value: 'page',
                        text: 'Page'
                    }),
                    $('<option>', {
                        value: 'section',
                        text: 'Section'
                    })
                )
            )
        );
    }

   
    var fieldcounter = 1;
    
    // Generates default formgroup/question box when the page first loads
    $('#form').append(generateFormFieldGroup());

    // generatese new form-group/question box when add button is clicked on the side bar
    $('#add-btn').click(function(){
        $('#form').append(generateFormFieldGroup());
    });


    // changes or add content in the form-group/question box each time the user changes the question type
    $('#form').on('change', '.field-option', function() {

        // finds the id of the clicked field-group
        var fieldGroupId = $(this).closest('.field-group').attr('id');
        // gets the value of the question type dropdown
        var selectedValue = $(this).val();
        
        // content change depending on the selected value of the question type dropdown
        if(selectedValue == 'choice'){
            // if multiple choice: create a section consisting a button for the user to add and customize the choices
            var commentCode = '<section class="form-options w-100 my-1" id="form-options' + fieldGroupId +'">';
            commentCode += '<div class="form-option-container" id="form-option-container';
            commentCode += fieldGroupId + '"></div>';
            commentCode += '<a href="#" class="form-add-option">';
            commentCode += '<small> Add option or <u>import from excel</u></small>';
            commentCode += '</a></section>';
            
            var option_count = 0;
            
        }
        else if (selectedValue == 'date') {
            // if date: create a date type input
            var fieldname = "field-date" + fieldGroupId;
            var commentCode = '<section class="form-options w-100 my-1">';
            commentCode += '<input type="date" class="w-25 rounded" name="';
            commentCode += fieldname;
            commentCode += '" id="">';
            commentCode += '</section>';
            
        }
        else if (selectedValue == 'time') {
            // if date: create a time type input
            var fieldname = "field-time" + fieldGroupId;
            var commentCode = '<section class="form-options w-100 my-1">';
            commentCode += '<input type="time" class="w-25 rounded" name="';
            commentCode += fieldname;
            commentCode += '" id="">';
            commentCode += '</section>';
        }
        else if (selectedValue == 'section') {
            // if section: add 'field-section' in the class and 'field-section_GROUPID' to make the name unique for all generated sections
            var replaceCode = '<input type="text" class="field-question field-section rounded" name="';
            replaceCode += 'field-section_' + fieldGroupId + '" placeholder="Section Name">'
            $($(this).closest('section')).find('.field-question').replaceWith(replaceCode);
        }
        else if (selectedValue == 'page') {
            // if section: add 'field-page' in the class and 'field-page_GROUPID' to make the name unique for all generated pages
            var replaceCode = '<input type="text" class="field-question field-page rounded" name="';
            replaceCode += 'field-page_' + fieldGroupId + '" placeholder="Page" disabled>'
            $($(this).closest('section')).find('.field-question').replaceWith(replaceCode);
        }
        else if (selectedValue == 'scale') {
            // if scale: creates a section that adds the needed input fields for customizing the scale
            var fieldname = "field-scale" + fieldGroupId;
            var commentCode = '<section class="form-options w-100 my-1">';
            commentCode += '<div class="d-flex w-100">';
            commentCode += '<aside class="scale-range d-flex flex-row me-5">';
            commentCode += '<select name="startselect" class="rounded" id="start_select">';
            commentCode += '<option value="1">1</option>';
            commentCode += '</select>';
            commentCode += ' <p> to </p>';
            commentCode += '<select name="startselect" class="end_select">';
            commentCode += ' <option value="1">1</option>';
            commentCode += ' <option value="2">2</option>';
            commentCode += '<option value="3">3</option>';
            commentCode += '<option value="4">4</option>';
            commentCode += '<option value="5">5</option>';
            commentCode += '</select>';
            commentCode += '</aside>';
            commentCode += '<aside class="d-flex flex-column w-100 ml-3">';
            commentCode += '<p>Scale Labels:</p>';
            commentCode += '<div class="scale-options d-flex flex-column flex-wrap" ';
            commentCode += 'id="' + fieldGroupId + '">';
            commentCode += '</div>';
            commentCode += '</aside>';
            commentCode += '</div>';
            commentCode += '<div class="statements mt-5" id="';
            commentCode += fieldGroupId + '">';
            commentCode += '<p><u>Statements:</u></p>';
            commentCode += '</div>';
            commentCode += '<a href="javascript:void(0);" class="add-scale-statement">';
            commentCode += '<small> Add option or <u>import from excel</u></small>';
            commentCode += '</a>';
            commentCode += '</section>';

            var statement_count = 0;
            
        }
        
        $($(this).closest('.field-group')).find('.form-options').remove();
        $($(this).closest('.field-group')).append(commentCode);
        // $($(this).closest('.field-group')).find('#' + fieldGroupId + '.form-options').replaceWith(commentCode);
        
        // creates scale statement inputs every time they click the 'add statement' text
        $('#form').on('click', '.add-scale-statement', function() {
            
            // TODO: find the bug that sometimes duplicates generating scale statement input
            var added_statement = '<input type="text" class="scale-statement w-75 mb-1" id="';
            added_statement += 'scale_statement_' + statement_count++;
            added_statement += '" placeholder="Enter scale statement">';
            
            $(this).closest('.field-group').find('#' + fieldGroupId + '.statements').append(added_statement);

        });
        // creates scale statement inputs every time they click the 'add option' text
        $('#form').on('click', '.form-add-option', function() {
            // alert('lkfjslkd');
            var added_option = '<input type="text" class="form-option-input w-75 mb-1" name="';
            added_option += 'form_option_input_' + option_count++;
            added_option += '" placeholder="Enter option ' + option_count + '">';
            // var selector = '.form-options > #form-option-container' + $(this).closest('.field-group').attr('id');
            $(this).closest('.field-group').find('#form-options' + fieldGroupId +' > .form-option-container').append(added_option);
           
           
        });
        
        
        // generates scale label text boxes depending on the number chosen from the end_scale
        $('#form').on('change', '.end_select', function() {
            var endSelectValue = parseInt($(this).val());
            var scaleOptions = '';
    
            for (var i = 0; i < endSelectValue; i++) {
                scaleOptions += '<input type="text" class="scale-input w-25 mb-2" name="end_scale_range' + i + '" placeholder="placeholder">';
            }
    
            $(this).closest('.field-group').find('.scale-options').html(scaleOptions);
        });

    

        
       
    });
    
    
    

});