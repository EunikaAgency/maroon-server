$(document).ready(function () {
    $('select#user_role').on('change', function () {
        $(this).prop('disabled', true);
        let new_role = $(this).val();
        let user_id = $(this).data('user-id');

        $.ajax({
            url: base_url + 'auth/ajax_change_user_role',
            type: 'POST',
            data: { user_role: new_role, user_id: user_id },
            success: function (response) {
                if (response.success) {
                    toastr.success('User role updated successfully');
                } else {
                    toastr.error(response.message || 'Failed to update user role');
                }

                $('select#user_role').prop('disabled', false);
            },
            error: function () {
                toastr.error('Request failed');
                $('select#user_role').prop('disabled', false);
            }
        });

    });
});