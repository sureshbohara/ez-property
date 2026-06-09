(function ($) {
    'use strict';

    window.AdminCRUD = {
        initStatusToggle: function (url, successMsg = 'Status updated successfully') {
            $('input[type="checkbox"][data-toggle="toggle"]')
                .bootstrapToggle()
                .off('change')
                .on('change', function () {
                    const checkbox = $(this);
                    const form = checkbox.closest('form');
                    const statusId = form.find('input[name="status_id"]').val();
                    
                    checkbox.prop('disabled', true);

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            status_id: statusId
                        },
                        success: function (response) {
                            checkbox.prop('disabled', false);
                            
                            if (response.status === 200 || response.success) {
                                toastr.success(response.message || successMsg);
                            } else {
                                checkbox.prop('checked', !checkbox.prop('checked'));
                                toastr.error(response.error || 'Failed to update status');
                            }
                        },
                        error: function (xhr) {
                            checkbox.prop('disabled', false);
                            checkbox.prop('checked', !checkbox.prop('checked'));
                            toastr.error(xhr.responseJSON?.message || 'Connection error');
                        }
                    });
                });
        },


        initOrderLevel: function (url, successMsg = 'Order updated successfully') {
            $('.order-level-input').off('change').on('change', function () {
                const input = $(this);
                const id = input.data('id');
                const value = input.val();
                const original = input.data('original');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id,
                        order_level: value
                    },
                    success: function (response) {
                        toastr.success(response.message || successMsg);
                        input.data('original', value);
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error updating order');
                        input.val(original);
                    }
                });
            });
        },


        initFilterAutoSubmit: function (formId = '#filterForm', delay = 300) {
            let timeout;

            $(`${formId} input, ${formId} select`)
                .off('change keyup')
                .on('change keyup', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        $(formId).submit();
                    }, delay);
                });
        }
    };
})(jQuery);