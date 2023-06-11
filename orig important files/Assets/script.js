$( document ).ready(function() {
    // Scanning of IDs
    $('#field_input').on('input', function() {
        var inputValue = document.getElementById('field_input').value;
        var rfid= /^\d{10}$/; // Example pattern: xxxxxxxxxxx
        var sn= /^\d{4}-\d{5}$/; // Example pattern: xxxx-xxxxxx

        if (rfid.test(inputValue)) {
            console.log('rfid pattern');
            $('#rfid_tag').val(inputValue);
            $("#id_submit").click();
        }else if (sn.test(inputValue)){
            console.log('student number pattern');
            $('#student_number').val(inputValue);
            $("#id_submit").click();
        }
    });
    
    // Table Content Periodic Reload
    setInterval(function(){
        $("#tableDiv").load(window.location.href + " #tableContent" );
    }, 3000);

    //Dynamic Tag Number System
    function getColumnValues(columnIndex) {
        let values = [];
        $('#active-table tbody tr').each(function() {
          let cellValue = $(this).find('td').eq(columnIndex).text();
          values.push(cellValue);
        });
        return values;
    }

    var valuesToRemove = getColumnValues(1); // Array containing values of the tag column
    $.each(valuesToRemove, function(index, value) {
        // Remove options with matching values
        $('#tag_number option[value="' + value + '"]').remove();
    });
    
    //Constant Field
    var constantField = setInterval(function(){$('#field_input').focus();}, 1000);
    //Admin Options
    $('#admin').on('click', function() {
        clearInterval(constantField);
        $('#passwordField').show();
        $('#passwordInput').focus();
        $('#nav-toggle').prop('checked', false);
    });
    
    $('#passwordField input').on('input', function() {
        var password = $('#passwordInput').val();
        
        // Perform password verification here
        if (password === 'pass') {
            $('#passwordField').hide();
            $('#admin').hide();
            $('#adminOptions').show();
            setInterval(function(){$('#field_input').focus();}, 1000);
        }
    });
});