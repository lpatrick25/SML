@extends('layouts.master')

@section('APP-TITLE')
    Transaction List
@endsection

@section('active-transactions')
    active
@endsection

@section('APP-SUBTITLE')
    Manage Transactions
@endsection

@section('APP-CONTENT')
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">@yield('APP-SUBTITLE')</h3>
        </div>
        <div class="card-body">
            <div class="" id="toolbar">

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
                        <th data-field="transaction_status" data-formatter="statusFormatter">Transaction Status</th>
                        <th data-field="total_amount" data-formatter="priceFormatter">Total Amount</th>
                        <th data-field="payment_status" data-formatter="paymentStatusFormatter">Payment Status</th>
                        <th data-field="transaction_items" data-formatter="servicesFormatter">Services</th>
                        <th data-field="action" data-formatter="getActionFormatter">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Add Transaction Modal -->
    <div id="addModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="addForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Transaction</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="staff_id" name="staff_id" readonly
                            value="{{ auth()->user()->id }}">
                        <div class="col-lg-6 form-group">
                            <label for="add_transaction_date">Transaction Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="add_transaction_date" name="transaction_date"
                                readonly value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_customer_id">Customer <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="add_customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_service_id">Services <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="add_service_id" name="service_id" required>
                                <option value="">Select Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_total_amount">Total Amount <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_total_amount" name="total_amount" readonly>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_transaction_status">Transaction Status <span
                                    class="text-danger">*</span></label>
                            <select class="form-control select2" id="add_transaction_status" name="transaction_status"
                                required>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Picked Up">Picked Up</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_payment_status">Payment Status <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="add_payment_status" name="payment_status" required>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Paid">Paid</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_kilograms">Kilograms <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_kilograms" name="kilograms" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_load">Load <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_load" name="load" readonly>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_item_id">Item <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="add_item_id" name="item_id" required>
                                <option value="">Select Items</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="bi bi-x"></i>
                        Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Transaction Modal -->
    <div id="updateModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="updateForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Transaction</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="update_staff_id" name="staff_id" readonly
                            value="{{ auth()->user()->id }}">
                        <div class="col-lg-6 form-group">
                            <label for="update_transaction_date">Transaction Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="update_transaction_date"
                                name="transaction_date" readonly value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_customer_id">Customer <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_service_id">Services <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_service_id" name="service_id" required>
                                <option value="">Select Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_total_amount">Total Amount <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="update_total_amount" name="total_amount"
                                readonly>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_transaction_status">Transaction Status <span
                                    class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_transaction_status" name="transaction_status"
                                required>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Picked Up">Picked Up</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_payment_status">Payment Status <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_payment_status" name="payment_status"
                                required>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Paid">Paid</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_kilograms">Kilograms <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="update_kilograms" name="kilograms" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_load">Load <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="update_load" name="load" readonly>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_item_id">Item <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_item_id" name="item_id" required>
                                <option value="">Select Items</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="bi bi-x"></i>
                        Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Transaction Details Modal -->
    <div id="viewModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Transaction Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <p><strong>ID:</strong> <span id="view-id"></span></p>
                            <p><strong>Customer:</strong> <span id="view-customer"></span></p>
                            <p><strong>Staff:</strong> <span id="view-staff"></span></p>
                        </div>
                        <div class="col-lg-6">
                            <p><strong>Transaction Date:</strong> <span id="view-transaction_date"></span></p>
                            <p><strong>Transaction Status:</strong> <span id="view-transaction_status"></span></p>
                            <p><strong>Payment Status:</strong> <span id="view-payment_status"></span></p>
                            <p><strong>Total Amount:</strong> <span id="view-total_amount"></span></p>
                        </div>
                        <div class="col-lg-12">
                            <h5>Transaction Items</h5>
                            <div class="table-responsive">
                                <table id="view-order-items-table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Kilograms</th>
                                            <th>Rate</th>
                                            <th>Quantity</th>
                                            <th>Items Used</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="bi bi-x"></i>
                        Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
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
            const colors = {
                'Pending': 'bg-warning',
                'In Progress': 'bg-info',
                'Completed': 'bg-success',
                'Picked Up': 'bg-primary',
                'Cancelled': 'bg-danger'
            };
            let buttonStatus = '';
            if (status === 'Pending') {
                buttonStatus = `
                        <div class="btn-group" role="group">
                            <button class="btn ${colors[status]} text-white fw-semibold px-3 py-2 change-status" data-id="${row.id}" data-status="In Progress">In Progress</button>
                            <button class="btn bg-danger text-white fw-semibold px-3 py-2 change-status" data-id="${row.id}" data-status="Cancelled">Cancel</button>
                        </div>
                    `;
            } else if (status === 'In Progress') {
                buttonStatus = `
                        <button class="btn ${colors[status]} text-white fw-semibold px-3 py-2 change-status" data-id="${row.id}" data-status="Completed">Complete</button>
                    `;
            } else if (status === 'Completed') {
                buttonStatus = `
                        <button class="btn ${colors[status]} text-white fw-semibold px-3 py-2 change-status" data-id="${row.id}" data-status="Picked Up">Picked Up</button>
                    `;
            }
            if (status === 'Pending') {
                return `
                        <button type="button" class="btn btn-sm btn-info me-1" onclick="viewData(${row.id})" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary me-1" onclick="editData(${row.id})" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        ${buttonStatus}
                    `;
            } else if (status === 'In Progress' || status === 'Completed') {
                return `
                        <button type="button" class="btn btn-sm btn-info me-1" onclick="viewData(${row.id})" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        ${buttonStatus}
                    `;
            } else if (status === 'Picked Up' || status === 'Cancelled') {
                return `
                        <button type="button" class="btn btn-sm btn-info me-1" onclick="viewData(${row.id})" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                    `;
            }
            return '<span class="text-muted">No actions</span>';
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

        // Populate customer, staff, and service dropdowns
        function populateSelect(url, selectId, textField, valueField, containerId = null) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    method: 'GET',
                    url: url,
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        console.log('AJAX Response for', url, response);
                        const data = response.data || response.rows || response;
                        let selector = containerId ?
                            `#${containerId} .order-item[data-index="${selectId.split('-')[1]}"] .${selectId.split('-')[0]}` :
                            `#${selectId}`;
                        const $select = $(selector);
                        console.log(`Targeting selector: ${selector}`, $select.length);
                        $select.find('option:not(:first)').remove();
                        data.forEach(item => {
                            let text = item[textField] || (item.first_name ?
                                `${item.first_name} ${item.last_name}` : item.name);
                            if (selectId.startsWith('service_id')) {
                                text =
                                    `${item.name} (${item.kilograms}kg, ₱${parseFloat(item.price).toFixed(2)})`;
                            } else if (selectId.startsWith('item_item')) {
                                text = `${item.item_name} (${item.quantity} ${item.unit})`;
                            }
                            $select.append(
                                `<option value="${item[valueField]}" data-kilograms="${item.kilograms || ''}" data-price="${item.price || ''}" data-quantity="${item.quantity || ''}" data-unit="${item.unit || ''}">${text}</option>`
                            );
                        });
                        $select.select2({
                            theme: 'bootstrap4',
                            width: '100%',
                            placeholder: 'Select an option',
                            allowClear: true
                        });
                        $select.trigger('change.select2');
                        resolve();
                    },
                    error: function(xhr) {
                        toastr.error(
                            `Error fetching ${selectId} data: ${xhr.responseJSON?.message || 'Unknown error'}`
                        );
                        reject(xhr);
                    }
                });
            });
        }

        // Add transaction item
        function addTransactionItem(containerId, index, serviceId = '', quantity = '', kilograms = '', price = '',
            itemItems = []) {
            const html = `
        <div class="order-item row mb-2" data-index="${index}">
            <div class="col-md-3 form-group">
                <select class="form-control select2 service_id" name="transaction_items[${index}][service_id]" required>
                    <option value="">Select Service</option>
                    <!-- Populated dynamically -->
                </select>
            </div>
            <div class="col-md-2 form-group">
                <input type="text" class="form-control kilograms" readonly placeholder="Kilograms" value="${kilograms}">
            </div>
            <div class="col-md-2 form-group">
                <input type="text" class="form-control price" readonly placeholder="Rate" value="${price ? `₱${parseFloat(price).toFixed(2)}` : ''}">
            </div>
            <div class="col-md-2 form-group">
                <input type="number" class="form-control quantity" name="transaction_items[${index}][quantity]" required min="1" placeholder="Quantity" value="${quantity}">
            </div>
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary add-item-item">Add Item</button>
            </div>
            <div class="col-md-1 form-group">
                <button type="button" class="btn btn-sm btn-danger remove-item">Remove</button>
            </div>
            <div class="col-md-12 item-items-container mt-2">
                <!-- Item logs will be added here -->
            </div>
        </div>`;
            $(`#${containerId}`).append(html);

            // Populate service dropdown and wait for it to complete
            return populateSelect('{{ route('services.index') }}', `service_id-${index}`, 'name', 'id', containerId).then(
                () => {
                    const $serviceSelect = $(`#${containerId} .order-item[data-index="${index}"] .service_id`);
                    $serviceSelect.select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        placeholder: 'Select an option',
                        allowClear: true
                    });
                    if (serviceId) {
                        console.log(`Setting service_id: ${serviceId} for index ${index}`, $serviceSelect.find(
                            `option[value="${serviceId}"]`).length);
                        $serviceSelect.val(serviceId).trigger('change.select2');
                        $(`#${containerId} .order-item[data-index="${index}"] .kilograms`).val(kilograms);
                        $(`#${containerId} .order-item[data-index="${index}"] .price`).val(
                            price ? `₱${parseFloat(price).toFixed(2)}` : ''
                        );
                    }

                    // Collect promises for item logs
                    const itemPromises = itemItems.map((item, invIndex) => {
                        return addItemItem(containerId, index, invIndex, item.item_id, item.quantity);
                    });

                    // Return a promise that resolves when all item logs are populated
                    return Promise.all(itemPromises);
                });
        }

        // Add item log
        function addItemItem(containerId, itemIndex, invIndex, itemItemId = '', quantity = '') {
            const html = `
        <div class="item-item row mb-2" data-inv-index="${invIndex}">
            <div class="col-md-5 form-group">
                <select class="form-control select2 item_item" name="transaction_items[${itemIndex}][item_items][${invIndex}][item_id]">
                    <option value="">Select Item (Optional)</option>
                    <!-- Populated dynamically -->
                </select>
            </div>
            <div class="col-md-5 form-group">
                <input type="number" class="form-control item_quantity" name="transaction_items[${itemIndex}][item_items][${invIndex}][quantity]" min="1" placeholder="Quantity Used" value="${quantity}">
            </div>
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-danger remove-item-item">Remove</button>
            </div>
        </div>`;
            $(`#${containerId} .order-item[data-index="${itemIndex}"] .item-items-container`).append(html);

            // Return the promise from populateSelect
            return populateSelect('{{ route('items.index') }}', `item_item-${itemIndex}-${invIndex}`, 'item_name', 'id',
                containerId).then(() => {
                // Initialize Select2 for the new dropdown
                const $itemSelect = $(
                    `#${containerId} .order-item[data-index="${itemIndex}"] .item-item[data-inv-index="${invIndex}"] .item_item`
                );
                $itemSelect.select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: 'Select an option',
                    allowClear: true
                });

                if (itemItemId) {
                    console.log(`Setting item_id: ${itemItemId} for itemIndex ${itemIndex}, invIndex ${invIndex}`,
                        $itemSelect.find(`option[value="${itemItemId}"]`).length);
                    $itemSelect.val(itemItemId).trigger('change.select2');
                }
            }).catch(error => {
                console.error('Error populating item dropdown:', error);
                toastr.error('Error populating item dropdown: ' + (error.message || 'Unknown error'));
            });
        }

        $(document).ready(function() {
            // Initialize Select2 for dropdowns
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            }); // Populate dropdowns for Add modal
            // populateSelect('{{ route('customers.index') }}', 'add_customer_id', 'fullname', 'id');
            // populateSelect('{{ route('users.index') }}', 'add_staff_id', 'fullname', 'id');

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

            // Open add modal
            $('#add-new-btn').click(function() {
                $('#addForm').trigger('reset').find('.is-invalid').removeClass('is-invalid');
                $('#addForm').find('.invalid-feedback').remove();
                $('#order-items-container').empty();
                addTransactionItem('order-items-container', 0);
                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            });

            $('#add_kilograms').change(function() {
                var service = $('#add_service_id').val();
                var kilograms = $('#add_kilograms').val();
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
                            $('#add_total_amount').val(response.totalAmount);
                            $('#add_load').val(response.load);
                        }
                    });
                }
            });

            // Add transaction item
            $(document).on('click', '#add-item-btn, #update-add-item-btn', function() {
                const containerId = $(this).attr('id') === 'add-item-btn' ? 'order-items-container' :
                    'update-order-items-container';
                const index = $(`#${containerId} .order-item`).length;
                addTransactionItem(containerId, index);
            });

            // Add item log
            $(document).on('click', '.add-item-item', function() {
                const $orderItem = $(this).closest('.order-item');
                const itemIndex = $orderItem.data('index');
                const invIndex = $orderItem.find('.item-item').length;
                const containerId = $orderItem.parent().attr('id');
                addItemItem(containerId, itemIndex, invIndex);
            });

            // Remove transaction item
            $(document).on('click', '.remove-item', function() {
                if ($(`#${$(this).closest('.order-item').parent().attr('id')} .order-item`).length > 1) {
                    $(this).closest('.order-item').remove();
                } else {
                    toastr.warning('At least one transaction item is required.');
                }
            });

            // Remove item log
            $(document).on('click', '.remove-item-item', function() {
                $(this).closest('.item-item').remove();
            });

            // Update kilograms and price on service change
            $(document).on('change', '.service_id', function() {
                const $row = $(this).closest('.order-item');
                const serviceId = $(this).val();
                const $kilograms = $row.find('.kilograms');
                const $price = $row.find('.price');
                if (serviceId) {
                    const selectedOption = $(this).find('option:selected');
                    $kilograms.val(selectedOption.data('kilograms') || '');
                    $price.val(selectedOption.data('price') ?
                        `₱${parseFloat(selectedOption.data('price')).toFixed(2)}` : '');
                } else {
                    $kilograms.val('');
                    $price.val('');
                }
            });

            // Validate item quantity
            $(document).on('change', '.item_item', function() {
                const $row = $(this).closest('.item-item');
                const itemId = $(this).val();
                const $quantity = $row.find('.item_quantity');
                if (itemId) {
                    const selectedOption = $(this).find('option:selected');
                    const availableQuantity = parseInt(selectedOption.data('quantity')) || 0;
                    $quantity.attr('max', availableQuantity).val('');
                    if (availableQuantity <= 0) {
                        toastr.warning('Selected item is out of stock.');
                        $(this).val('').trigger('change');
                    }
                } else {
                    $quantity.removeAttr('max').val('');
                }
            });

            // Form validation for addForm
            $('#addForm').validate({
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
                        title: "Confirm Creation",
                        text: "Are you sure you want to add this new transaction?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'POST',
                                url: '{{ route('transactions.store') }}',
                                data: $(form).serialize(),
                                dataType: 'json',
                                cache: false,
                                success: function(response) {
                                    $('#addModal').modal('hide');
                                    $('#table').bootstrapTable(
                                        'refresh');
                                    $(form).trigger('reset');
                                    toastr.success(response.message ||
                                        'Transaction added successfully'
                                    );
                                },
                                error: function(xhr) {
                                    toastr.error(
                                        'Error adding transaction: ' +
                                        (xhr.responseJSON
                                            ?.message ||
                                            'Unknown error'));
                                }
                            });
                        }
                    });
                }
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
                            const dataId = $(form).data('id');
                            const $items = $('#update-order-items-container .order-item');
                            const servicePromises = [];
                            const itemChecks = [];
                            let total_amount = 0;

                            $items.each(function() {
                                const serviceId = $(this).find('.service_id').val();
                                const quantity = parseInt($(this).find('.quantity')
                                    .val()) || 0;
                                if (serviceId && quantity) {
                                    servicePromises.push(
                                        $.ajax({
                                            method: 'GET',
                                            url: `{{ route('services.index') }}/${serviceId}`,
                                            dataType: 'json'
                                        }).then(response => {
                                            const service = response.content ||
                                                response.data || response;
                                            return service.price * quantity;
                                        })
                                    );
                                }
                                const $itemItems = $(this).find('.item-item');
                                $itemItems.each(function() {
                                    const itemId = $(this).find('.item_item')
                                        .val();
                                    const invQuantity = parseInt($(this).find(
                                        '.item_quantity').val()) || 0;
                                    if (itemId && invQuantity) {
                                        itemChecks.push(
                                            $.ajax({
                                                method: 'GET',
                                                url: `{{ route('items.index') }}/${itemId}`,
                                                dataType: 'json'
                                            }).then(response => {
                                                const item = response
                                                    .content || response
                                                    .data || response;
                                                if (item.quantity <
                                                    invQuantity) {
                                                    throw new Error(
                                                        `Insufficient stock for ${item.item_name}`
                                                    );
                                                }
                                            })
                                        );
                                    }
                                });
                            });

                            Promise.all([...servicePromises, ...itemChecks]).then(amounts => {
                                total_amount = amounts.slice(0, servicePromises.length)
                                    .reduce((sum, amount) => sum + amount, 0);
                                const data = $(form).serializeArray();
                                data.push({
                                    name: 'total_amount',
                                    value: total_amount.toFixed(2)
                                });

                                $.ajax({
                                    method: 'PUT',
                                    url: `{{ route('transactions.index') }}/${dataId}`,
                                    data: data,
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
                            }).catch(error => {
                                toastr.error(error.message ||
                                    'Error validating transaction items');
                            });
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
