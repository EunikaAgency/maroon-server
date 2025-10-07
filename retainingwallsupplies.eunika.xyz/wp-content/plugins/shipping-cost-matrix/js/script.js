jQuery(document).ready(function ($) {








    var ajaxurl = my_ajax_object.ajaxurl;

    // Initialize DataTable
    var table = $('#shipping-cost-table').DataTable({
        paging: true,
        ordering: true,
        info: true
    });

    // Function to add a new row
    $('#add-row').click(function () {
        var newRow = '' +
            '<tr class="new-row">' +
                '<td contenteditable="true" data-column="suburb"></td>' +
                '<td contenteditable="true" data-column="postcode"></td>' +
                '<td contenteditable="true" data-column="steel_cost"></td>' +
                '<td contenteditable="true" data-column="combo_cost"></td>' +
                '<td contenteditable="true" data-column="area"></td>' +
                '<td data-column="actions">' +
                    '<button class="btn btn-primary save-new-row">Save</button> ' +
                    '<button class="btn btn-danger delete-row">Delete</button>' +
                '</td>' +
            '</tr>';

        // Append the new row to the table
        var rowNode = table.row.add($(newRow)).draw().node();
        $(rowNode).addClass('new-row');
    });

    // Function to delete a row
    $(document).on('click', '.delete-row', function () {
        var rowId = $(this).closest('tr').data('id');
        var row = $(this).closest('tr');
        // AJAX call to delete the row from the database
        $.post(ajaxurl, { action: 'delete_row', id: rowId }, function (response) {
            // Handle response
            console.log(response);
            // Remove the row from the DataTable
            table.row(row).remove().draw();
        });
    });

    // Function to update a cell
    $(document).on('blur', 'td[contenteditable="true"]', function () {
        var row = $(this).closest('tr');
        if (!row.hasClass('new-row')) {
            var rowId = row.data('id');
            var column = $(this).data('column');
            var newValue = $(this).text();
            // AJAX call to update the cell in the database
            $.post(ajaxurl, { action: 'update_cell', id: rowId, column: column, value: newValue }, function (response) {
                console.log(response);
                // Handle response
            });
        }
    });

    // Function to save a new row
    $(document).on('click', '.save-new-row', function () {
        var row = $(this).closest('tr');
        var data = {
            action: 'add_row',
            suburb: row.find('[data-column="suburb"]').text(),
            postcode: row.find('[data-column="postcode"]').text(),
            steel_cost: row.find('[data-column="steel_cost"]').text(),
            combo_cost: row.find('[data-column="combo_cost"]').text(),
            area: row.find('[data-column="area"]').text()
        }

        // AJAX call to save the new row
        $.post(ajaxurl, data, function (response) {
            if (response.success) {
                row.removeClass('new-row'); // Remove the 'new-row' class
                row.data('id', response.data.id); // Set the ID returned from the server

                // Update the row to match the existing rows
                var newRowHtml = '<td contenteditable="true" data-column="suburb">' + row.find('[data-column="suburb"]').text() + '</td>' +
                    '<td contenteditable="true" data-column="postcode">' + row.find('[data-column="postcode"]').text() + '</td>' +
                    '<td contenteditable="true" data-column="steel_cost">' + row.find('[data-column="steel_cost"]').text() + '</td>' +
                    '<td contenteditable="true" data-column="combo_cost">' + row.find('[data-column="combo_cost"]').text() + '</td>' +
                    '<td contenteditable="true" data-column="area">' + row.find('[data-column="area"]').text() + '</td>' +
                    '<td><button class="btn btn-danger delete-row">Delete</button></td>';
                row.html(newRowHtml); // Replace the row's HTML with the new structure

                // Redraw the DataTable
                table.row(row).invalidate().draw();
            } else {
                // Handle error
                alert('Error saving row: ' + response.data.message);
            }
        });
    });
});
