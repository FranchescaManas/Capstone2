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

    
   

    $('#add-btn').click(function(){
        $('#form').append(generateFormFieldGroup());
    });

    var fieldcounter = 1;

    $('#form').append(generateFormFieldGroup());

    $('#form').on('change', '.field-option', function() {
        var fieldGroupId = $(this).closest('.field-group').attr('id');
        var selectedValue = $(this).val();
            
        if(selectedValue == 'choice'){
            var commentCode = '<section class="form-options w-100 my-1">';
            commentCode += '<a href="#" class="form-add-option">';
            commentCode += '<small> Add option or <u>import from excel</u></small>';
            commentCode += '</a></section>';
            
        }
        else if (selectedValue == 'date') {
            
            var fieldname = "field-date" + fieldGroupId;
            var commentCode = '<section class="form-options w-100 my-1">';
            commentCode += '<input type="date" class="w-25 rounded" name="';
            commentCode += fieldname;
            commentCode += '" id="">';
            commentCode += '</section>';
            
        }
        else if (selectedValue == 'time') {
            var fieldname = "field-time" + fieldGroupId;
            var commentCode = '<section class="form-options w-100 my-1">';
            commentCode += '<input type="time" class="w-25 rounded" name="';
            commentCode += fieldname;
            commentCode += '" id="">';
            commentCode += '</section>';
        }
        else if (selectedValue == 'scale') {
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
            commentCode += '<div class="statements mt-5">';
            commentCode += '<p><u>Statements:</u></p>';
            // commentCode += '<input type="text" class="scale-input w-75 mb-1" placeholder="Enter scale statement">';
            commentCode += ' </div>';
            commentCode += '<a href="javascript:void(0);" class="add-scale-statement">';
            commentCode += '<small> Add option or <u>import from excel</u></small>';
            commentCode += '</a>';
            commentCode += '</section>';
            
            $($(this).closest('.field-group')).find('#' + fieldGroupId + '.form-options').replaceWith(commentCode);
            
        }
           
        $('#form').on('change', '.end_select', function() {
            var endSelectValue = parseInt($(this).val());
            var scaleOptions = '';
    
            for (var i = 0; i < endSelectValue; i++) {
                scaleOptions += '<input type="text" class="scale-input w-25 mb-2" name="end_scale_range' + i + '" placeholder="placeholder">';
            }
    
            $(this).closest('.field-group').find('.scale-options').html(scaleOptions);
        });

        $('#form').on('click', '.add-scale-statement', function() {
            var statement_count = $(this).closest('.field-group').find('.scale-statement').length + 1;
    
            var added_statement = '<input type="text" class="scale-statement w-75 mb-1" id="';
            added_statement += 'scale_statement_' + statement_count;
            added_statement += '" placeholder="Enter scale statement">';
    
            var statementsContainer = $(this).closest('.field-group').find('.statements');
            statementsContainer.append(added_statement);
        });
        
        $($(this).closest('.field-group')).find('.form-options').remove();
        $($(this).closest('.field-group')).append(commentCode);
       
    });
    
    
    

});