$( document ).ready(function() {

    // Function: Fetch Data for Table
    function fetchData() {
        $.ajax({
            url: 'db-requests/fetch_data.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#dynamicTable tbody').empty();

                $.each(response, function(index, data) {
                    let row = $('<tr>');
                    if($('#actionHead').is(':visible')){
                        row.append($('<td>').html("<a class='edit' href='tag_edit.php?log_id="+data.log_id+"&student_number="+data.student_number+"&tag_number="+data.tag_number+"'> <span class='las la-edit'></span></a> <a class='end' href='db-requests/end_charging_session.php?student_number="+data.student_number+"&log_id="+data.log_id+"&time_in="+data.time_in+"'> <span class='las la-undo'></span></a>"));
                    }else{
                        row.append($('<td>').html("<a class='edit' href='tag_edit.php?log_id='"+data.log_id+"'&student_number='"+data.student_number+"'&tag_number='"+data.tag_number+"'> <span class='las la-edit'></span></a> <a class='end' href='db-requests/end_charging_session.php?student_number="+data.student_number+"&log_id="+data.log_id+"&time_in="+data.time_in+"'> <span class='las la-undo'></span></a>").attr('style','display:none;'));
                    }
                    if($('#rfidHead').is(':visible')){
                        row.append($('<td>').text(data.rfid_tag));
                    }else{
                        row.append($('<td>').text(data.rfid_tag).attr('style','display:none;'));
                    }
                    if($('#snHead').is(':visible')){
                        row.append($('<td>').text(data.student_number));
                    }else{
                        row.append($('<td>').text(data.student_number).attr('style','display:none;'));
                    }
                    row.append($('<td>').text(data.time_in));
                    row.append($('<td>').text(data.tag_number));
                    row.append($('<td>').text(data.first_name+" "+data.last_name));
                    row.append($('<td>').text(data.college));

                    $.ajax({
                        url: 'db-requests/fetch_remaining_charge.php',
                        method: 'POST',
                        data: {
                            student_number: data.student_number,
                        },
                        success: function(response) {
                            let currentTime = new Date().getTime();
                            let offset = response * 60000; 
                            let offsetTime = new Date(data.time_in).getTime() + offset;
                            let timeDifferenceRemaining = offsetTime - currentTime;
                            let hoursR = Math.floor(timeDifferenceRemaining / (1000 * 60 * 60));
                            let minutesR = Math.floor((timeDifferenceRemaining % (1000 * 60 * 60)) / (1000 * 60));
                            let secondsR = Math.floor((timeDifferenceRemaining % (1000 * 60)) / 1000);
                            row.append($('<td>').text(hoursR.toString().padStart(2, '0') + ':' +
                            minutesR.toString().padStart(2, '0') + ':' +
                            secondsR.toString().padStart(2, '0')));

                            let timeIn= new Date(data.time_in).getTime();
                            let timeDifferenceElapsed = currentTime - timeIn;
                            let hoursE = Math.floor(timeDifferenceElapsed / (1000 * 60 * 60));
                            let minutesE = Math.floor((timeDifferenceElapsed % (1000 * 60 * 60)) / (1000 * 60));
                            let secondsE = Math.floor((timeDifferenceElapsed % (1000 * 60)) / 1000);
                            row.append($('<td>').text(hoursE.toString().padStart(2, '0') + ':' +
                            minutesE.toString().padStart(2, '0') + ':' +
                            secondsE.toString().padStart(2, '0')));
                        },
                        error: function(xhr, status, error) {
                            console.error('Request failed with status ' + status);
                        }
                    });

                    $('#dynamicTable tbody').append(row);
                });
                
                // Update Tag System
                var valuesToRemove = getColumnValues(4); // Array containing values of the tag column
                $.each(valuesToRemove, function(index, value) {
                    // Remove options with matching values
                    $('#tag_number option[value="' + value + '"]').remove();
                });
            },
            error: function(xhr, status, error) {
            console.log('Error:', error);
            }
        });
    }
    // Update Table
    fetchData();
    setInterval(fetchData, 950);
    
    //Function: Dynamic Tag Number System
    function getColumnValues(columnIndex) {
        let values = [];
        $('#dynamicTable tbody tr').each(function() {
            let cellValue = $(this).find('td').eq(columnIndex).text();
            values.push(cellValue);
        });
        return values;
    }

    
    // Scanning of IDs Conditions
    $('#field_input').on('input', function() {
        let inputValue = document.getElementById('field_input').value;
        let rfid= /^\d{10}$/; // Example pattern: xxxxxxxxxxx
        let sn= /^\d{4}-\d{5}$/; // Example pattern: xxxx-xxxxxx

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
    

    //Constant ID Field Focus
    var constantField = setInterval(function(){$('#field_input').focus();}, 1000);
    
    //Admin Options 
    $('#admin').on('click', function() {
        clearInterval(constantField);
        $('#passwordField').show();
        $('#passwordInput').focus();
        $('#nav-toggle').prop('checked', false);
    });
    
    $('#passwordField input').on('input', function() {
        let password = $('#passwordInput').val();
        
        // Perform password verification here
        if (password === 'pass') {
            $('#passwordField').hide();
            $('#admin').hide();
            $('#adminOptions').show();
            setInterval(function(){$('#field_input').focus();}, 1000);
            $('#actionHead').show();
            $('#rfidHead').show();
            $('#snHead').show();
            $('#seeall').show();
        }
    });
});