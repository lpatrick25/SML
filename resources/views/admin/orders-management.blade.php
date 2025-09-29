@extends('layouts.master')
@section('APP-TITLE')
    Transaction List
@endsection
@section('active-orders-management')
    active
@endsection
@section('APP-CONTENT')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap">
                <div class="header-title">
                    <h4 class="card-title mb-0">@yield('APP-TITLE')</h4>
                </div>
                <div>
                    <button class="text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" id="add-new-btn">
                        <i class="btn-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </i>
                        <span>New Transaction</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                        data-show-columns="true" data-show-refresh="true" data-show-toggle="true" data-show-export="true"
                        data-filter-control="true" data-sticky-header="true" data-show-jump-to="true"
                        data-url="{{ route('transactions.index') }}" data-toolbar="#toolbar">

                        <thead>
                            <tr>
                                <th data-field="id">#</th>
                                <th data-field="customer_name" data-formatter="customerNameFormatter">Customer</th>
                                <th data-field="staff_name" data-formatter="staffNameFormatter">Staff</th>
                                <th data-field="transaction_date">Transaction Date</th>
                                <th data-field="transaction_status" data-formatter="statusFormatter">Transaction Status</th>
                                <th data-field="total_amount" data-formatter="priceFormatter">Total Amount</th>
                                <th data-field="payment_status" data-formatter="paymentStatusFormatter">Payment Status</th>

                                <!-- 👇 New column for Services -->
                                <th data-field="transaction_items" data-formatter="servicesFormatter">Services</th>

                                <th data-field="action" data-formatter="getActionFormatter">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Transaction Modal -->
    <div id="addModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="addForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Transaction</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="customer_id">Customer: <span class="text-danger">*</span></label>
                            <select class="form-control" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                <!-- Populated dynamically via AJAX -->
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="staff_id">Staff:</label>
                            <select class="form-control" id="staff_id" name="staff_id">
                                <option value="">Select Staff (Optional)</option>
                                <!-- Populated dynamically via AJAX -->
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="transaction_date">Transaction Date: <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date"
                                required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="transaction_status">Transaction Status: <span class="text-danger">*</span></label>
                            <select class="form-control" id="transaction_status" name="transaction_status" required>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Picked Up">Picked Up</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="payment_status">Payment Status: <span class="text-danger">*</span></label>
                            <select class="form-control" id="payment_status" name="payment_status" required>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Paid">Paid</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label>Transaction Items: <span class="text-danger">*</span></label>
                            <div id="order-items-container">
                                <div class="order-item row mb-2" data-index="0">
                                    <div class="col-md-3 form-group">
                                        <select class="form-control service_id" name="transaction_items[0][service_id]"
                                            required>
                                            <option value="">Select Service</option>
                                            <!-- Populated dynamically via AJAX -->
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="text" class="form-control kilograms" readonly
                                            placeholder="Kilograms">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="text" class="form-control price" readonly placeholder="Price">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="number" class="form-control quantity"
                                            name="transaction_items[0][quantity]" required min="1"
                                            placeholder="Quantity">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <button type="button" class="btn btn-sm btn-primary add-item-item">Add
                                            Item</button>
                                    </div>
                                    <div class="col-md-1 form-group">
                                        <button type="button" class="btn btn-sm btn-danger remove-item">Remove</button>
                                    </div>
                                    <div class="col-md-12 item-items-container mt-2">
                                        <!-- Item items will be added here -->
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="add-item-btn">Add
                                Item</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-md btn-primary">Save</button>
                    <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Cancel</button>
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
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="update_customer_id">Customer: <span class="text-danger">*</span></label>
                            <select class="form-control" id="update_customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                <!-- Populated dynamically via AJAX -->
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_staff_id">Staff:</label>
                            <select class="form-control" id="update_staff_id" name="staff_id">
                                <option value="">Select Staff (Optional)</option>
                                <!-- Populated dynamically via AJAX -->
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_transaction_date">Transaction Date: <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="update_transaction_date"
                                name="transaction_date" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_transaction_status">Transaction Status: <span
                                    class="text-danger">*</span></label>
                            <select class="form-control" id="update_transaction_status" name="transaction_status"
                                required>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Picked Up">Picked Up</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_payment_status">Payment Status: <span class="text-danger">*</span></label>
                            <select class="form-control" id="update_payment_status" name="payment_status" required>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Paid">Paid</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label>Transaction Items: <span class="text-danger">*</span></label>
                            <div id="update-order-items-container">
                                <!-- Populated dynamically -->
                            </div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="update-add-item-btn">Add
                                Item</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Cancel</button>
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
                                            <th>Price</th>
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
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
        let dataId;
        let itemIndex = 1;

        function customerNameFormatter(value, row) {
            return row.customer ? `${row.customer.first_name} ${row.customer.last_name}` : 'N/A';
        }

        function staffNameFormatter(value, row) {
            return row.staff ? `${row.staff.first_name} ${row.staff.last_name}` : 'Unassigned';
        }

        function priceFormatter(value) {
            return value ? `₱${parseFloat(value).toFixed(2)}` : 'N/A';
        }

        function servicesFormatter(value, row) {
            if (!row.transaction_items || row.transaction_items.length === 0) {
                return "-";
            }

            return row.transaction_items.map(item => {
                let service = item.service;
                return `${service.name} (${service.kilograms}kg)`;
            }).join("<br>");
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
                <button class="btn ${colors[status]} text-white fw-semibold px-3 py-2 change-status"
                        data-id="${row.id}"
                        data-status="In Progress">In Progress</button>
                <button class="btn bg-danger text-white fw-semibold px-3 py-2 change-status"
                        data-id="${row.id}"
                        data-status="Cancelled">Cancel</button>
            </div>
        `;
            } else if (status === 'In Progress') {
                buttonStatus = `
            <button class="btn ${colors[status]} text-white fw-semibold px-3 py-2 change-status"
                    data-id="${row.id}"
                    data-status="Completed">Complete</button>
        `;
            } else if (status === 'Completed') {
                buttonStatus = `
            <button class="btn ${colors[status]} text-white fw-semibold px-3 py-2 change-status"
                    data-id="${row.id}"
                    data-status="Picked Up">Picked Up</button>
        `;
            }

            // Return buttons based on status
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

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('change-status')) {
                const transactionId = e.target.dataset.id;
                const newStatus = e.target.dataset.status;

                fetch(`/transactions/${transactionId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        $('#table').bootstrapTable('refresh');
                        toastr.success(data.message);
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                        alert('Failed to update status');
                    });
            }
        });

        function populateSelect(url, selectId, textField, valueField, containerId = null) {
            $.ajax({
                method: 'GET',
                url: url,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.data || response.rows || response;
                    let selector = `#${selectId}, #update_${selectId}`;
                    if (containerId) {
                        selector =
                            `#${containerId} .order-item[data-index="${selectId.split('-')[1]}"] .${selectId.split('-')[0]}`;
                    }
                    const $select = $(selector);
                    $select.find('option:not(:first)').remove();
                    data.forEach(item => {
                        let text = item[textField];
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
                },
                error: function(xhr) {
                    toastr.error(
                        `Error fetching ${selectId} data: ${xhr.responseJSON?.message || 'Unknown error'}`);
                }
            });
        }

        function addItemItem(containerId, itemIndex, invIndex, itemItemId = '', quantity = '') {
            const html = `
                <div class="item-item row mb-2" data-inv-index="${invIndex}">
                    <div class="col-md-5 form-group">
                        <select class="form-control item_item" name="transaction_items[${itemIndex}][item_items][${invIndex}][item_id]" required>
                            <option value="">Select Item</option>
                            <!-- Populated dynamically -->
                        </select>
                    </div>
                    <div class="col-md-5 form-group">
                        <input type="number" class="form-control item_quantity" name="transaction_items[${itemIndex}][item_items][${invIndex}][quantity]" required min="1" placeholder="Quantity Used" value="${quantity}">
                    </div>
                    <div class="col-md-2 form-group">
                        <button type="button" class="btn btn-sm btn-danger remove-item-item">Remove</button>
                    </div>
                </div>`;
            $(`#${containerId} .order-item[data-index="${itemIndex}"] .item-items-container`).append(html);
            populateSelect('{{ route('items.index') }}', `item_item-${itemIndex}-${invIndex}`, 'item_name', 'id',
                containerId);
            if (itemItemId) {
                $(`#${containerId} .order-item[data-index="${itemIndex}"] .item-item[data-inv-index="${invIndex}"] .item_item`)
                    .val(itemItemId);
            }
        }

        function addTransactionItem(containerId, index, serviceId = '', quantity = '', kilograms = '', price = '',
            itemItems = []) {
            const html = `
                <div class="order-item row mb-2" data-index="${index}">
                    <div class="col-md-3 form-group">
                        <select class="form-control service_id" name="transaction_items[${index}][service_id]" required>
                            <option value="">Select Service</option>
                            <!-- Populated dynamically -->
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="text" class="form-control kilograms" readonly placeholder="Kilograms" value="${kilograms}">
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="text" class="form-control price" readonly placeholder="Price" value="${price ? `₱${parseFloat(price).toFixed(2)}` : ''}">
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
                        <!-- Item items will be added here -->
                    </div>
                </div>`;
            $(`#${containerId}`).append(html);
            populateSelect('{{ route('services.index') }}', `service_id-${index}`, 'name', 'id', containerId);
            if (serviceId) {
                $(`#${containerId} .order-item[data-index="${index}"] .service_id`).val(serviceId);
                $(`#${containerId} .order-item[data-index="${index}"] .kilograms`).val(kilograms);
                $(`#${containerId} .order-item[data-index="${index}"] .price`).val(`₱${parseFloat(price).toFixed(2)}`);
            }
            itemItems.forEach((item, invIndex) => {
                addItemItem(containerId, index, invIndex, item.item_id, item.quantity);
            });
        }

        function viewData(id) {
            $.ajax({
                method: 'GET',
                url: `/transactions/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.content;
                    $('#view-id').text(data.id);
                    $('#view-customer').text(data.customer ?
                        `${data.customer.first_name} ${data.customer.last_name}` : 'N/A');
                    $('#view-staff').text(data.staff ? `${data.staff.first_name} ${data.staff.last_name}` :
                        'Unassigned');
                    $('#view-transaction_date').text(data.transaction_date);
                    $('#view-transaction_status').text(data.transaction_status);
                    $('#view-payment_status').text(data.payment_status);
                    $('#view-total_amount').text(`₱${parseFloat(data.total_amount).toFixed(2)}`);

                    const $tbody = $('#view-order-items-table tbody').empty();
                    if (data.transaction_items && data.transaction_items.length) {
                        data.transaction_items.forEach(item => {
                            const itemItems = item.item_logs && item.item_logs.length ?
                                item.item_logs.map(log =>
                                    `${log.item.item_name} (${log.quantity} ${log.item.unit})`).join(
                                    ', ') :
                                'None';
                            $tbody.append(`
                                <tr>
                                    <td>${item.service ? item.service.name : 'N/A'}</td>
                                    <td>${item.service ? item.service.kilograms || 'N/A' : 'N/A'}</td>
                                    <td>${item.service ? `₱${parseFloat(item.service.price).toFixed(2)}` : 'N/A'}</td>
                                    <td>${item.quantity}</td>
                                    <td>${itemItems}</td>
                                    <td>₱${parseFloat(item.subtotal).toFixed(2)}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $tbody.append('<tr><td colspan="6" class="text-center">No items found</td></tr>');
                    }

                    $('#viewModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                },
                error: function(xhr) {
                    toastr.error(`Error fetching order data: ${xhr.responseJSON?.message || 'Unknown error'}`);
                }
            });
        }

        function editData(id) {
            $.ajax({
                method: 'GET',
                url: `/transactions/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.content;
                    dataId = data.id;
                    $('#update_customer_id').val(data.customer_id);
                    $('#update_staff_id').val(data.staff_id || '');
                    $('#update_transaction_date').val(data.transaction_date);
                    $('#update_transaction_status').val(data.transaction_status);
                    $('#update_payment_status').val(data.payment_status);

                    const $container = $('#update-order-items-container').empty();
                    itemIndex = 0;
                    if (data.transaction_items && data.transaction_items.length) {
                        data.transaction_items.forEach(item => {
                            const itemItems = item.item_logs ? item.item_logs.map(log => ({
                                item_id: log.item_id,
                                quantity: log.quantity
                            })) : [];
                            addTransactionItem(
                                'update-order-items-container',
                                itemIndex,
                                item.service_id,
                                item.quantity,
                                item.service ? item.service.kilograms || '' : '',
                                item.service ? item.service.price : '',
                                itemItems
                            );
                            itemIndex++;
                        });
                    } else {
                        addTransactionItem('update-order-items-container', itemIndex);
                        itemIndex++;
                    }

                    $('#updateModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                },
                error: function(xhr) {
                    toastr.error(`Error fetching order data: ${xhr.responseJSON?.message || 'Unknown error'}`);
                }
            });
        }

        function deleteData(id) {
            swal.fire({
                title: "Confirm Deletion",
                text: "Are you sure you want to delete this transaction? This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: `/transactions/${id}`,
                        dataType: 'json',
                        cache: false,
                        success: function(response) {
                            $('#table').bootstrapTable('refresh');
                            toastr.success(response.message || 'Transaction deleted successfully');
                        },
                        error: function(xhr) {
                            toastr.error(
                                `Error deleting transaction: ${xhr.responseJSON?.message || 'Unknown error'}`
                            );
                        }
                    });
                }
            });
        }

        function isMobile() {
            return window.innerWidth <= 576;
        }

        $(document).ready(function() {
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
                formatNoMatches: () => '<div class="text-center p-4">No data found.</div>',
                formatLoadingMessage: () =>
                    '<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Loading...</div>'
            });

            $(window).on('resize', function() {
                $('#table').bootstrapTable('toggleCustomView', isMobile());
            });

            // Populate customer and staff dropdowns
            populateSelect('{{ route('customers.index') }}', 'customer_id', 'fullname', 'id');
            populateSelect('{{ route('users.index') }}', 'staff_id', 'fullname', 'id');

            $('#add-new-btn').click(function() {
                $('#addForm').trigger('reset').find('.is-invalid').removeClass('is-invalid');
                $('#addForm').find('.invalid-feedback').remove();
                $('#order-items-container').empty();
                itemIndex = 0;
                addTransactionItem('order-items-container', itemIndex);
                itemIndex++;
                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            });

            $('#add-item-btn').click(function() {
                addTransactionItem('order-items-container', itemIndex);
                itemIndex++;
            });

            $('#update-add-item-btn').click(function() {
                addTransactionItem('update-order-items-container', itemIndex);
                itemIndex++;
            });

            $(document).on('click', '.add-item-item', function() {
                const $orderItem = $(this).closest('.order-item');
                const itemIndex = $orderItem.data('index');
                const invIndex = $orderItem.find('.item-item').length;
                addItemItem($orderItem.parent().attr('id'), itemIndex, invIndex);
            });

            $(document).on('click', '.remove-item', function() {
                if ($(`#${$(this).closest('.order-item').parent().attr('id')} .order-item`).length > 1) {
                    $(this).closest('.order-item').remove();
                } else {
                    toastr.warning('At least one order item is required.');
                }
            });

            $(document).on('click', '.remove-item-item', function() {
                if ($(this).closest('.item-items-container').find('.item-item').length > 1) {
                    $(this).closest('.item-item').remove();
                } else {
                    toastr.warning('At least one item item is required.');
                }
            });

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

            $(document).on('change', '.item_item', function() {
                const $row = $(this).closest('.item-item');
                const itemId = $(this).val();
                const $quantity = $row.find('.item_quantity');

                if (itemId) {
                    const selectedOption = $(this).find('option:selected');
                    const availableQuantity = parseInt(selectedOption.data('quantity')) || 0;
                    $quantity.attr('max', availableQuantity).val('');
                    if (availableQuantity <= 0) {
                        toastr.warning('Selected item item is out of stock.');
                        $(this).val('');
                    }
                }
            });

            $('#addForm').submit(function(event) {
                event.preventDefault();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').remove();
                swal.fire({
                    title: "Confirm Creation",
                    text: "Are you sure you want to add this new transaction?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, add it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let total_amount = 0;
                        const $items = $('#order-items-container .order-item');
                        const servicePromises = [];
                        const itemChecks = [];

                        $items.each(function() {
                            const serviceId = $(this).find('.service_id').val();
                            const quantity = parseInt($(this).find('.quantity').val()) || 0;
                            if (serviceId && quantity) {
                                servicePromises.push(
                                    $.ajax({
                                        method: 'GET',
                                        url: `/services/${serviceId}`,
                                        dataType: 'json'
                                    }).then(response => {
                                        const service = response.content || response
                                            .data ||
                                            response;
                                        return service.price * quantity;
                                    })
                                );
                            }

                            const $itemItems = $(this).find('.item-item');
                            $itemItems.each(function() {
                                const itemId = $(this).find('.item_item').val();
                                const invQuantity = parseInt($(this).find(
                                        '.item_quantity')
                                    .val()) || 0;
                                if (itemId && invQuantity) {
                                    itemChecks.push(
                                        $.ajax({
                                            method: 'GET',
                                            url: `/items/${itemId}`,
                                            dataType: 'json'
                                        }).then(response => {
                                            const item = response.content ||
                                                response
                                                .data || response;
                                            if (item.quantity <
                                                invQuantity) {
                                                throw new Error(
                                                    `Insufficient item for ${item.item_name}`
                                                );
                                            }
                                        })
                                    );
                                }
                            });
                        });

                        Promise.all([...servicePromises, ...itemChecks]).then(amounts => {
                            total_amount = amounts.slice(0, servicePromises.length).reduce((
                                    sum, amount) =>
                                sum + amount, 0);
                            const data = $(this).serializeArray();
                            data.push({
                                name: 'total_amount',
                                value: total_amount.toFixed(2)
                            });

                            $.ajax({
                                method: 'POST',
                                url: '{{ route('transactions.store') }}',
                                data: data,
                                dataType: 'json',
                                cache: false,
                                success: function(response) {
                                    $('#addModal').modal('hide');
                                    $('#table').bootstrapTable('refresh');
                                    $('#addForm').trigger('reset');
                                    toastr.success(response.message ||
                                        'Transaction added successfully');
                                },
                                error: function(xhr) {
                                    const response = xhr.responseJSON || {};
                                    toastr.error(
                                        `Error adding order: ${response.message || 'Unknown error'}`
                                    );
                                    if (response.errors) {
                                        for (const [field, messages] of Object
                                            .entries(response
                                                .errors)) {
                                            const input = $(
                                                `#addForm [name="${field}"], #addForm [name^="${field.replace(/\./g, '\\.')}"]`
                                            );
                                            if (input.length) {
                                                input.addClass('is-invalid');
                                                const error = $(
                                                    '<span class="invalid-feedback"></span>'
                                                ).text(messages[0]);
                                                input.closest('.form-group')
                                                    .append(error);
                                            }
                                        }
                                    }
                                }
                            });
                        }).catch(error => {
                            toastr.error(error.message ||
                                'Error calculating total amount or checking item');
                        });
                    }
                });
            });

            $('#updateForm').submit(function(event) {
                event.preventDefault();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').remove();
                swal.fire({
                    title: "Confirm Update",
                    text: "Are you sure you want to update this transaction?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, update it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let total_amount = 0;
                        const $items = $('#update-order-items-container .order-item');
                        const servicePromises = [];
                        const itemChecks = [];

                        $items.each(function() {
                            const serviceId = $(this).find('.service_id').val();
                            const quantity = parseInt($(this).find('.quantity').val()) || 0;
                            if (serviceId && quantity) {
                                servicePromises.push(
                                    $.ajax({
                                        method: 'GET',
                                        url: `/services/${serviceId}`,
                                        dataType: 'json'
                                    }).then(response => {
                                        const service = response.content || response
                                            .data ||
                                            response;
                                        return service.price * quantity;
                                    })
                                );
                            }

                            const $itemItems = $(this).find('.item-item');
                            $itemItems.each(function() {
                                const itemId = $(this).find('.item_item').val();
                                const invQuantity = parseInt($(this).find(
                                        '.item_quantity')
                                    .val()) || 0;
                                if (itemId && invQuantity) {
                                    itemChecks.push(
                                        $.ajax({
                                            method: 'GET',
                                            url: `/items/${itemId}`,
                                            dataType: 'json'
                                        }).then(response => {
                                            const item = response.content ||
                                                response
                                                .data || response;
                                            if (item.quantity <
                                                invQuantity) {
                                                throw new Error(
                                                    `Insufficient item for ${item.item_name}`
                                                );
                                            }
                                        })
                                    );
                                }
                            });
                        });

                        Promise.all([...servicePromises, ...itemChecks]).then(amounts => {
                            total_amount = amounts.slice(0, servicePromises.length).reduce((
                                    sum, amount) =>
                                sum + amount, 0);
                            const data = $(this).serializeArray();
                            data.push({
                                name: 'total_amount',
                                value: total_amount.toFixed(2)
                            });

                            $.ajax({
                                method: 'PUT',
                                url: `/transactions/${dataId}`,
                                data: data,
                                dataType: 'json',
                                cache: false,
                                success: function(response) {
                                    $('#updateModal').modal('hide');
                                    $('#table').bootstrapTable('refresh');
                                    $('#updateForm').trigger('reset');
                                    toastr.success(response.message ||
                                        'Transaction updated successfully');
                                },
                                error: function(xhr) {
                                    const response = xhr.responseJSON || {};
                                    toastr.error(
                                        `Error updating order: ${response.message || 'Unknown error'}`
                                    );
                                    if (response.errors) {
                                        for (const [field, messages] of Object
                                            .entries(response
                                                .errors)) {
                                            const input = $(
                                                `#updateForm [name="${field}"], #updateForm [name^="${field.replace(/\./g, '\\.')}"]`
                                            );
                                            if (input.length) {
                                                input.addClass('is-invalid');
                                                const error = $(
                                                    '<span class="invalid-feedback"></span>'
                                                ).text(messages[0]);
                                                input.closest('.form-group')
                                                    .append(error);
                                            }
                                        }
                                    }
                                }
                            });
                        }).catch(error => {
                            toastr.error(error.message ||
                                'Error calculating total amount or checking item');
                        });
                    }
                });
            });
        });
    </script>
@endsection
