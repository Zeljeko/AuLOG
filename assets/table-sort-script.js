$(document).ready(function() {
    // Function to retrieve table data
    function getTableData() {
        var tableData = [];
        $('#tableSort tbody tr').each(function() {
            var rowData = [];
            $(this).find('td').each(function() {
            rowData.push($(this).html());
            });
            tableData.push(rowData);
        });
        return tableData;
    }
    console.log(getTableData());
    
    // Function to repopulate the table
    function repopulateTable(data) {
        var tableBody = $('#tableSort tbody');
        tableBody.empty();
        $.each(data, function(index, row) {
            var tableRow = $('<tr>');
            $.each(row, function(index, cellData) {
            tableRow.append($('<td>').html(cellData));
            });
            tableBody.append(tableRow);
        });
    }
    
    // Initial population of the table
    var originalData = getTableData();
    var initialData = getTableData();
    var sortDirection = 'asc';
    
    // Event handler for table header click to sort
    $('#tableSort thead tr td:not(:first)').click(function() {
        var columnIndex = $(this).index();
        var sortedData;
        if (sortDirection === 'asc') {
            sortedData = initialData.sort(function(a, b) {
                console.log(a[columnIndex]+" "+b[columnIndex]);
                return a[columnIndex].localeCompare(b[columnIndex]);
            });
            sortDirection = 'desc';
            $('#tableSort thead tr td:not(:first) span').removeClass().addClass("las la-sort");
            $(this).children('span').removeClass().addClass("las la-sort-up");
        }else if (sortDirection === 'desc') {
            sortedData = initialData.sort(function(a, b) {
                return b[columnIndex].localeCompare(a[columnIndex]);
            });
            $('#tableSort thead tr td:not(:first) span').removeClass().addClass("las la-sort");
            $(this).children('span').removeClass().addClass("las la-sort-down");
            sortDirection = 'orig';
        }else if (sortDirection === 'orig') {
            sortedData = originalData;
            $('#tableSort thead tr td:not(:first) span').removeClass().addClass("las la-sort");
            $(this).children('span').removeClass().addClass("las la-sort");
            sortDirection = 'asc';
        }
        repopulateTable(sortedData);
        console.log(sortedData);
    });
});
  