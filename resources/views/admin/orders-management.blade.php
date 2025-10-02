@extends('layouts.master')

@section('APP-TITLE', 'Transaction List')
@section('active-transactions', 'active')
@section('APP-SUBTITLE', 'Manage Transactions')

@section('APP-STYLES')
@endsection

@section('APP-CONTENT')
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">@yield('APP-SUBTITLE')</h3>
        </div>

        <div class="card-body">
            <div id="toolbar">

                <button class="btn btn-primary" id="add-new-btn">
                    <i class="bi bi-plus"></i> New Transaction
                </button>
            </div>
            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true"
                data-show-refresh="true" data-show-toggle="true" data-show-export="true" data-filter-control="true"
                data-sticky-header="true" data-show-jump-to="true" data-url="{{ route('transactions.index') }}"
                data-toolbar="#toolbar">
                <thead>
                    <tr>
                        <th data-field="id">#</th>
                        <th data-field="customer_name" data-formatter="customerNameFormatter">Customer</th>
                        <th data-field="staff_name" data-formatter="staffNameFormatter">Staff</th>
                        <th data-field="transaction_date" data-formatter="dateFormatter">Transaction Date</th>
                        <th data-field="transaction_status" data-formatter="statusFormatter">Status</th>
                        <th data-field="total_amount" data-formatter="priceFormatter">Total</th>
                        <th data-field="payment_status" data-formatter="paymentStatusFormatter">Payment</th>
                        <th data-field="transaction_items" data-formatter="servicesFormatter">Services</th>
                        <th data-field="action" data-formatter="getActionFormatter">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('transactions.add-modal')
    @include('transactions.update-modal')
    @include('transactions.view-modal')
@endsection

@section('APP-SCRIPT')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script type="text/javascript">
        var dataId;
        let currentStep = 1;

        // Table formatters
        function customerNameFormatter(value, row) {
            return row.customer ? `${row.customer.first_name} ${row.customer.last_name}` : 'N/A';
        }

        function staffNameFormatter(value, row) {
            return row.staff ? `${row.staff.first_name} ${row.staff.last_name}` : 'Unassigned';
        }

        function dateFormatter(value) {
            if (!value) return 'N/A';
            const date = new Date(value);
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            });
        }

        function priceFormatter(value) {
            return value ? `₱${parseFloat(value).toFixed(2)}` : 'N/A';
        }

        function servicesFormatter(value, row) {
            if (!row.transaction_items || row.transaction_items.length === 0) {
                return 'None';
            }
            const services = row.transaction_items.map(item => {
                return item.service ? `${item.service.name} (${item.service.kilograms}kg)` : 'N/A';
            });
            const maxDisplay = 2;
            if (services.length > maxDisplay) {
                const remaining = services.length - maxDisplay;
                return `<span title="${services.join(', ')}">${services.slice(0, maxDisplay).join(', ')} (+${remaining} more)</span>`;
            }
            return services.join(', ');
        }

        function statusFormatter(value) {
            const status = (value || '').toString().trim().toLowerCase();
            const colors = {
                'pending': 'bg-warning',
                'in progress': 'bg-info',
                'completed': 'bg-success',
                'picked up': 'bg-primary',
                'cancelled': 'bg-danger'
            };
            return `<span class="badge ${colors[status] || 'bg-secondary'} text-white fw-semibold px-3 py-2">${value || 'N/A'}</span>`;
        }

        function paymentStatusFormatter(value) {
            const status = (value || '').toString().trim().toLowerCase();
            const colors = {
                'unpaid': 'bg-danger',
                'paid': 'bg-success',
                'partial': 'bg-warning'
            };
            return `<span class="badge ${colors[status] || 'bg-secondary'} text-white fw-semibold px-3 py-2">${value || 'N/A'}</span>`;
        }

        function getActionFormatter(value, row) {
            if (!row || !row.id) {
                return '<span class="text-muted">No actions</span>';
            }

            const status = (row.transaction_status || '').toString().trim();
            const canEdit = status === 'Pending'; // Adjust as needed
            let dropdownItems = `
        <li><a class="dropdown-item" href="#" onclick="viewData(${row.id})" title="View Details">
            <i class="bi bi-eye me-1"></i> View
        </a></li>
    `;

            if (canEdit) {
                dropdownItems += `
            <li><a class="dropdown-item" href="#" onclick="editData(${row.id})" title="Edit Transaction">
                <i class="bi bi-pencil me-1"></i> Edit
            </a></li>
        `;
            }

            // 🔹 Add Pay button if unpaid
            if ((row.payment_status || '').toLowerCase() === 'unpaid') {
                dropdownItems += `
            <li><a class="dropdown-item" href="#" onclick="payTransaction(${row.id})" title="Pay Now">
                <i class="bi bi-cash-coin me-1"></i> Pay
            </a></li>
        `;
            }

            // Status change items
            const statusOptions = {
                'Pending': [{
                        label: 'Mark In Progress',
                        status: 'In Progress',
                        icon: 'bi bi-play-fill'
                    },
                    {
                        label: 'Cancel',
                        status: 'Cancelled',
                        icon: 'bi bi-x-circle-fill'
                    }
                ],
                'In Progress': [{
                    label: 'Mark Complete',
                    status: 'Completed',
                    icon: 'bi bi-check-lg'
                }],
                'Completed': [{
                    label: 'Mark Picked Up',
                    status: 'Picked Up',
                    icon: 'bi bi-box-arrow-up'
                }]
            };

            const options = statusOptions[status] || [];
            options.forEach(option => {
                dropdownItems += `
            <li><a class="dropdown-item change-status" href="#" data-id="${row.id}" data-status="${option.status}" title="${option.label}">
                <i class="bi ${option.icon} me-1"></i> ${option.label}
            </a></li>
        `;
            });

            if (options.length === 0 && !canEdit && (row.payment_status || '').toLowerCase() !== 'unpaid') {
                dropdownItems += '<li><span class="dropdown-item text-muted">No further actions</span></li>';
            }

            return `
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" title="Actions">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">${dropdownItems}</ul>
        </div>
    `;
        }

        // View transaction
        function viewData(id) {
            $.ajax({
                method: 'GET',
                url: `{{ route('transactions.index') }}/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.content || response;
                    $('#view-id').text(data.id);
                    $('#view-customer').text(data.customer ?
                        `${data.customer.first_name} ${data.customer.last_name}` : 'N/A');
                    $('#view-staff').text(data.staff ?
                        `${data.staff.first_name} ${data.staff.last_name}` : 'Unassigned');
                    $('#view-transaction_date').text(data.transaction_date ? new Date(data
                        .transaction_date).toLocaleDateString('en-US', {
                        month: 'short',
                        day: '2-digit',
                        year: 'numeric'
                    }) : 'N/A');
                    $('#view-transaction_status').text(data.transaction_status || 'N/A');
                    $('#view-payment_status').text(data.payment_status || 'N/A');
                    $('#view-total_amount').text(data.total_amount ?
                        `₱${parseFloat(data.total_amount).toFixed(2)}` : 'N/A');

                    const $tbody = $('#view-order-items-table tbody').empty();
                    if (data.transaction_items && data.transaction_items.length) {
                        data.transaction_items.forEach(item => {
                            const itemItems = item.item_logs && item.item_logs.length ?
                                item.item_logs.map(log =>
                                    `${log.item.item_name} (${log.quantity} ${log.item.unit})`
                                ).join(', ') :
                                'None';
                            $tbody.append(`
                                    <tr>
                                        <td>${item.service ? item.service.name : 'N/A'}</td>
                                        <td>${item.service ? item.service.kilograms || 'N/A' : 'N/A'}</td>
                                        <td>${item.service ? `₱${parseFloat(item.service.price).toFixed(2)}` : 'N/A'}</td>
                                        <td>${item.quantity || 'N/A'}</td>
                                        <td>${itemItems}</td>
                                        <td>₱${parseFloat(item.subtotal).toFixed(2)}</td>
                                    </tr>
                                `);
                        });
                    } else {
                        $tbody.append(
                            '<tr><td colspan="6" class="text-center">No items found</td></tr>');
                    }

                    $('#viewModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                },
                error: function(xhr) {
                    toastr.error('Error fetching transaction data: ' + (xhr.responseJSON?.message ||
                        'Unknown error'));
                }
            });
        }

        // Edit transaction
        function editData(id) {

            $.ajax({
                method: 'GET',
                url: `{{ route('transactions.index') }}/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    var data = response.content;
                    var transactionItems = data.transaction_items;

                    console.log(transactionItems);

                    if (transactionItems.length > 0) {
                        // Example: just take the first transaction item
                        var firstItem = transactionItems[0];

                        $('#update_service_id').val(firstItem.service_id);
                        $('#update_kilograms').val(firstItem.kilograms);
                        $('#update_load').val(firstItem.quantity);

                        var itemLogs = firstItem.item_logs;
                        console.log(itemLogs)
                        if (itemLogs.length > 0) {
                            var firstItemLogs = itemLogs[0];

                            $('#update_item_id').val(firstItemLogs.item_id);
                        }

                    }

                    dataId = data.id;

                    $('#update_customer_id').val(data.customer_id);
                    $('#update_staff_id').val(data.staff_id);
                    $('#update_item_id').val(firstItem?.item_logs?.[0]?.item_id ?? '');
                    $('#update_transaction_date').val(data.transaction_date);
                    $('#update_transaction_status').val(data.transaction_status);
                    $('#update_total_amount').val(data.total_amount);
                    $('#update_payment_status').val(data.payment_status);

                    $('#updateForm').find('select').trigger('change');

                    $('#updateModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                }
            });
        }

        // Delete transaction
        function deleteData(id) {
            Swal.fire({
                title: "Confirm Deletion",
                text: "Are you sure you want to delete this transaction? This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: `{{ route('transactions.index') }}/${id}`,
                        dataType: 'json',
                        cache: false,
                        success: function(response) {
                            $('#table').bootstrapTable('refresh');
                            toastr.success(response.message ||
                                'Transaction deleted successfully');
                        },
                        error: function(xhr) {
                            toastr.error('Error deleting transaction: ' + (xhr.responseJSON
                                ?.message || 'Unknown error'));
                        }
                    });
                }
            });
        }

        // Check if device is mobile
        function isMobile() {
            return window.innerWidth <= 576;
        }

        // Wizard Navigation
        function showStep(step) {
            $('.wizard-step').removeClass('active').hide();
            $('#step' + step).addClass('active').show();
            currentStep = step;
        }

        function validateStep(step) {
            let valid = true;
            $('#step' + step + ' [required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return valid;
        }

        function payTransaction(transactionId) {
            $.ajax({
                method: 'GET',
                url: `/transactions/${transactionId}/getPayment`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response.success && response.data && response.data.checkout_url) {
                        Swal.fire({
                            title: 'Scan to Pay',
                            html: `
                        <div id="paymentQrCode" class="d-flex justify-content-center mb-3"></div>
                        <p><a href="${response.data.checkout_url}" target="_blank">Or click here to open checkout</a></p>
                    `,
                            didOpen: () => {
                                new QRCode(document.getElementById('paymentQrCode'), response.data
                                    .checkout_url);
                            },
                            width: 400,
                            showConfirmButton: false,
                            showCloseButton: true
                        });

                        toastr.success('Customer can scan the QR code to pay.');
                    } else {
                        toastr.error('No active payment session found.');
                    }
                },
                error: function(xhr) {
                    toastr.error('Error fetching payment session: ' + (xhr.responseJSON?.message ||
                        'Unknown error'));
                }
            });
        }

        $(document).ready(function() {
            // Initialize Select2 for dropdowns
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });

            // Initialize Bootstrap Table
            $('#table').bootstrapTable({
                exportDataType: 'all',
                exportTypes: ['json', 'csv', 'txt', 'excel'],
                filterControl: true,
                stickyHeader: true,
                pagination: true,
                pageSize: 10,
                pageList: [10, 25, 50, 100],
                search: true,
                showColumns: true,
                showRefresh: true,
                showToggle: true,
                sidePagination: 'server',
                cache: true,
                cacheAmount: 100,
                showCustomView: isMobile(),
                formatNoMatches: function() {
                    return '<div class="text-center p-4">No data found.</div>';
                },
                formatLoadingMessage: function() {
                    return '<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Loading...</div>';
                }
            });

            // Toggle custom view on window resize
            $(window).on('resize', function() {
                $('#table').bootstrapTable('toggleCustomView', isMobile());
            });

            // Wizard Steps
            $('#next1').click(function() {
                if (validateStep(1)) {
                    showStep(2);
                }
            });

            $('#prev2, #prev3, #prev4').click(function() {
                showStep(currentStep - 1);
            });

            $('#next2').click(function() {
                if (validateStep(2)) {
                    calculateTotal();
                    if ($('#total_amount').val()) {
                        showStep(3);
                    }
                }
            });

            // Calculate Total
            function calculateTotal() {
                const serviceId = $('#add_service_id').val();
                const kg = parseInt($('#add_kilograms').val()) || 0;
                if (serviceId && kg) {
                    $.ajax({
                        method: 'POST',
                        url: '/transactions/getTotalAmount',
                        data: {
                            service: serviceId,
                            kilograms: kg
                        },
                        cache: false,
                        success: function(response) {
                            $('#load').val(response.load);
                            $('#total_amount').val(response.totalAmount);
                            $('#totalPreview').html(
                                `Load: ${response.load}, Total: ₱${response.totalAmount}`).show();
                        },
                        error: function() {
                            toastr.error('Error calculating total');
                        }
                    });
                }
            }

            $('#add_kilograms, #add_service_id').on('change', calculateTotal);

            // Submit Wizard
            $('#submit').click(function() {
                if (!validateStep(3)) return;

                const formData = $('#addForm').serialize();
                const paymentMethod = $('input[name="payment_method"]:checked').val();
                const transactionStatus = 'Pending'; // Default

                // Temporarily set status for creation
                $('<input>').attr({
                    type: 'hidden',
                    name: 'transaction_status',
                    value: transactionStatus
                }).appendTo('#addForm');

                Swal.fire({
                    title: "Confirm Creation",
                    text: "Are you sure you want to create this transaction?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "Yes"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'POST',
                            url: '{{ route('transactions.store') }}',
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            success: function(response) {
                                const transactionId = response.content.id;
                                $('#transaction_id').val(transactionId);
                                 $('#table').bootstrapTable('refresh');

                                if (paymentMethod === 'cash') {
                                    processPayment(transactionId, 'cash');
                                } else {
                                    processPayment(transactionId, paymentMethod);
                                }
                            },
                            error: function(xhr) {
                                toastr.error('Error creating transaction: ' + (xhr
                                    .responseJSON?.message || 'Unknown error'));
                            }
                        });
                    }
                });
            });



            // Form validation for updateForm
            $('#updateForm').validate({
                rules: {
                    customer_id: {
                        required: true
                    },
                    transaction_date: {
                        required: true
                    },
                    transaction_status: {
                        required: true
                    },
                    payment_status: {
                        required: true
                    },
                    'transaction_items[0][service_id]': {
                        required: true
                    },
                    'transaction_items[0][quantity]': {
                        required: true,
                        number: true,
                        min: 1
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    Swal.fire({
                        title: "Confirm Update",
                        text: "Are you sure you want to update this transaction?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'PUT',
                                url: `{{ route('transactions.index') }}/${dataId}`,
                                data: $(form).serialize(),
                                dataType: 'json',
                                cache: false,
                                success: function(response) {
                                    $('#updateModal').modal('hide');
                                    $('#table').bootstrapTable(
                                        'refresh');
                                    $(form).trigger('reset');
                                    toastr.success(response.message ||
                                        'Transaction updated successfully'
                                    );
                                },
                                error: function(xhr) {
                                    toastr.error(
                                        'Error updating transaction: ' +
                                        (xhr.responseJSON
                                            ?.message ||
                                            'Unknown error'));
                                }
                            });
                        }
                    });
                }
            });

            function processPayment(transactionId, method) {
                $.ajax({
                    method: 'POST',
                    url: `/transactions/${transactionId}/payment`,
                    data: {
                        payment_method: method
                    },
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        if (response.success) {
                            if (method === 'cash') {
                                toastr.success('Transaction created and paid with cash.');
                                $('#addModal').modal('hide');
                                $('#table').bootstrapTable('refresh');
                            } else {
                                // Show QR
                                showStep(4);
                                new QRCode(document.getElementById('qrContainer'), response.data.session
                                    .checkout_url);
                                toastr.success('Transaction created. Customer can scan QR to pay.');
                            }
                        } else {
                            toastr.error(response.message || 'Payment processing failed');
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error processing payment: ' + (xhr.responseJSON?.message ||
                            'Unknown error'));
                    }
                });
            }

            // Open Wizard
            $('#add-new-btn').click(function() {
                $('#addForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                $('#totalPreview').hide();
                $('#qrContainer').empty();
                showStep(1);
                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
                $('.select2').each(function() {
                    $(this).val(null).trigger('change');
                });
            });

            // Update kilograms change
            $('#update_kilograms').change(function() {
                var service = $('#update_service_id').val();
                var kilograms = $('#update_kilograms').val();
                if (service !== '' && kilograms !== '') {
                    $.ajax({
                        method: 'POST',
                        url: '/transactions/getTotalAmount',
                        data: {
                            service: service,
                            kilograms: kilograms,
                        },
                        cache: false,
                        success: function(response) {
                            $('#update_total_amount').val(response.totalAmount);
                            $('#update_load').val(response.load);
                        }
                    });
                }
            });

            // Change status
            $(document).on('click', '.change-status', function() {
                const transactionId = $(this).data('id');
                const newStatus = $(this).data('status');
                $.ajax({
                    method: 'PATCH',
                    url: `{{ route('transactions.index') }}/${transactionId}/status`,
                    data: {
                        status: newStatus
                    },
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        $('#table').bootstrapTable('refresh');
                        toastr.success(response.message ||
                            'Transaction status updated successfully');
                    },
                    error: function(xhr) {
                        toastr.error('Error updating transaction status: ' + (xhr.responseJSON
                            ?.message || 'Unknown error'));
                    }
                });
            });

        });
    </script>
@endsection
