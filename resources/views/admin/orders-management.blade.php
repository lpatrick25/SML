@extends('layouts.master')
@section('APP-TITLE')
    Order List
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
                        <span>New Order</span>
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
                                <th data-field="id">ID</th>
                                <th data-field="customer_name" data-formatter="customerNameFormatter">Customer</th>
                                <th data-field="staff_name" data-formatter="staffNameFormatter">Staff</th>
                                <th data-field="order_date">Order Date</th>
                                <th data-field="order_status" data-formatter="statusFormatter">Order Status</th>
                                <th data-field="total_amount" data-formatter="priceFormatter">Total Amount</th>
                                <th data-field="payment_status" data-formatter="paymentStatusFormatter">Payment Status</th>
                                <th data-field="action" data-formatter="getActionFormatter">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Order Modal -->
    <div id="addModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="addForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Order</h3>
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
                            <label for="order_date">Order Date: <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="order_date" name="order_date" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="order_status">Order Status: <span class="text-danger">*</span></label>
                            <select class="form-control" id="order_status" name="order_status" required>
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
                            <label>Order Items: <span class="text-danger">*</span></label>
                            <div id="order-items-container">
                                <div class="order-item row mb-2">
                                    <div class="col-md-6 form-group">
                                        <select class="form-control service_id" name="order_items[0][service_id]" required>
                                            <option value="">Select Service</option>
                                            <!-- Populated dynamically via AJAX -->
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="number" class="form-control quantity" name="order_items[0][quantity]" required min="1" placeholder="Quantity">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <button type="button" class="btn btn-sm btn-danger remove-item">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="add-item-btn">Add Item</button>
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

    <!-- Update Order Modal -->
    <div id="updateModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="updateForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Order</h3>
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
                            <label for="order_date">Order Date: <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="order_date" name="order_date" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="order_status">Order Status: <span class="text-danger">*</span></label>
                            <select class="form-control" id="order_status" name="order_status" required>
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
                            <label>Order Items: <span class="text-danger">*</span></label>
                            <div id="update-order-items-container">
                                <!-- Populated dynamically -->
                            </div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="update-add-item-btn">Add Item</button>
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

    <!-- View Order Details Modal -->
    <div id="viewModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Order Details</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <p><strong>ID:</strong> <span id="view-id"></span></p>
                            <p><strong>Customer:</strong> <span id="view-customer"></span></p>
                            <p><strong>Staff:</strong> <span id="view-staff"></span></p>
                        </div>
                        <div class="col-lg-6">
                            <p><strong>Order Date:</strong> <span id="view-order_date"></span></p>
                            <p><strong>Order Status:</strong> <span id="view-order_status"></span></p>
                            <p><strong>Payment Status:</strong> <span id="view-payment_status"></span></p>
                            <p><strong>Total Amount:</strong> <span id="view-total_amount"></span></p>
                        </div>
                        <div class="col-lg-12">
                            <h5>Order Items</h5>
                            <div class="table-responsive">
                                <table id="view-order-items-table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Quantity</th>
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
            return `
                <button class="btn btn-sm btn-info me-1" onclick="viewData(${row.id})" title="View">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="btn btn-sm btn-primary me-1" onclick="editData(${row.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger me-1" onclick="deleteData(${row.id})" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            `;
        }

        function populateSelect(url, selectId, textField, valueField) {
            $.ajax({
                method: 'GET',
                url: url,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.data || response.rows || response;
                    const $select = $(`#${selectId}, #updateForm #${selectId}`);
                    $select.find('option:not(:first)').remove();
                    data.forEach(item => {
                        $select.append(`<option value="${item[valueField]}">${item[textField]}</option>`);
                    });
                },
                error: function(xhr) {
                    toastr.error(`Error fetching ${selectId} data: ${xhr.responseJSON?.message || 'Unknown error'}`);
                }
            });
        }

        function addOrderItem(containerId, index, serviceId = '', quantity = '') {
            const html = `
                <div class="order-item row mb-2" data-index="${index}">
                    <div class="col-md-6 form-group">
                        <select class="form-control service_id" name="order_items[${index}][service_id]" required>
                            <option value="">Select Service</option>
                            <!-- Populated dynamically -->
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="number" class="form-control quantity" name="order_items[${index}][quantity]" required min="1" placeholder="Quantity" value="${quantity}">
                    </div>
                    <div class="col-md-2 form-group">
                        <button type="button" class="btn btn-sm btn-danger remove-item">Remove</button>
                    </div>
                </div>`;
            $(`#${containerId}`).append(html);
            populateSelect('{{ route('services.index') }}', `order-items-container .order-item[data-index="${index}"] .service_id`, 'name', 'id');
            if (serviceId) {
                $(`#${containerId} .order-item[data-index="${index}"] .service_id`).val(serviceId);
            }
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
                    $('#view-customer').text(data.customer ? `${data.customer.first_name} ${data.customer.last_name}` : 'N/A');
                    $('#view-staff').text(data.staff ? `${data.staff.first_name} ${data.staff.last_name}` : 'Unassigned');
                    $('#view-order_date').text(data.order_date);
                    $('#view-order_status').text(data.order_status);
                    $('#view-payment_status').text(data.payment_status);
                    $('#view-total_amount').text(`$${parseFloat(data.total_amount).toFixed(2)}`);

                    const $tbody = $('#view-order-items-table tbody').empty();
                    if (data.order_items && data.order_items.length) {
                        data.order_items.forEach(item => {
                            $tbody.append(`
                                <tr>
                                    <td>${item.service ? item.service.name : 'N/A'}</td>
                                    <td>${item.quantity}</td>
                                    <td>$${parseFloat(item.subtotal).toFixed(2)}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $tbody.append('<tr><td colspan="3" class="text-center">No items found</td></tr>');
                    }

                    $('#viewModal').modal({ backdrop: 'static', keyboard: false }).modal('show');
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
                    $('#updateForm').find('#customer_id').val(data.customer_id);
                    $('#updateForm').find('#staff_id').val(data.staff_id || '');
                    $('#updateForm').find('#order_date').val(data.order_date);
                    $('#updateForm').find('#order_status').val(data.order_status);
                    $('#updateForm').find('#payment_status').val(data.payment_status);

                    const $container = $('#update-order-items-container').empty();
                    itemIndex = 0;
                    if (data.order_items && data.order_items.length) {
                        data.order_items.forEach(item => {
                            addOrderItem('update-order-items-container', itemIndex, item.service_id, item.quantity);
                            itemIndex++;
                        });
                    } else {
                        addOrderItem('update-order-items-container', itemIndex);
                        itemIndex++;
                    }

                    $('#updateModal').modal({ backdrop: 'static', keyboard: false }).modal('show');
                },
                error: function(xhr) {
                    toastr.error(`Error fetching order data: ${xhr.responseJSON?.message || 'Unknown error'}`);
                }
            });
        }

        function deleteData(id) {
            if (!confirm('Are you sure you want to delete this order?')) return;
            $.ajax({
                method: 'DELETE',
                url: `/transactions/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    $('#table').bootstrapTable('refresh');
                    toastr.success(response.message || 'Order deleted successfully');
                },
                error: function(xhr) {
                    toastr.error(`Error deleting order: ${xhr.responseJSON?.message || 'Unknown error'}`);
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
                formatLoadingMessage: () => '<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Loading...</div>'
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
                addOrderItem('order-items-container', itemIndex);
                itemIndex++;
                $('#addModal').modal({ backdrop: 'static', keyboard: false }).modal('show');
            });

            $('#add-item-btn').click(function() {
                addOrderItem('order-items-container', itemIndex);
                itemIndex++;
            });

            $('#update-add-item-btn').click(function() {
                addOrderItem('update-order-items-container', itemIndex);
                itemIndex++;
            });

            $(document).on('click', '.remove-item', function() {
                if ($(`#${$(this).closest('.order-item').parent().attr('id')} .order-item`).length > 1) {
                    $(this).closest('.order-item').remove();
                } else {
                    toastr.warning('At least one order item is required.');
                }
            });

            $('#addForm').submit(function(event) {
                event.preventDefault();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').remove();

                // Calculate total_amount client-side to match backend
                let total_amount = 0;
                const $items = $('#order-items-container .order-item');
                const servicePromises = [];

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
                                const service = response.content || response.data || response;
                                return service.price * quantity;
                            })
                        );
                    }
                });

                Promise.all(servicePromises).then(amounts => {
                    total_amount = amounts.reduce((sum, amount) => sum + amount, 0);
                    const data = $(this).serializeArray();
                    data.push({ name: 'total_amount', value: total_amount.toFixed(2) });

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
                            toastr.success(response.message || 'Order added successfully');
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON || {};
                            toastr.error(`Error adding order: ${response.message || 'Unknown error'}`);
                            if (response.errors) {
                                for (const [field, messages] of Object.entries(response.errors)) {
                                    const input = $(`#addForm [name="${field}"], #addForm [name^="${field.replace(/\./g, '\\.')}"]`);
                                    if (input.length) {
                                        input.addClass('is-invalid');
                                        const error = $('<span class="invalid-feedback"></span>').text(messages[0]);
                                        input.closest('.form-group').append(error);
                                    }
                                }
                            }
                        }
                    });
                }).catch(() => {
                    toastr.error('Error calculating total amount');
                });
            });

            $('#updateForm').submit(function(event) {
                event.preventDefault();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').remove();

                // Calculate total_amount client-side to match backend
                let total_amount = 0;
                const $items = $('#update-order-items-container .order-item');
                const servicePromises = [];

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
                                const service = response.content || response.data || response;
                                return service.price * quantity;
                            })
                        );
                    }
                });

                Promise.all(servicePromises).then(amounts => {
                    total_amount = amounts.reduce((sum, amount) => sum + amount, 0);
                    const data = $(this).serializeArray();
                    data.push({ name: 'total_amount', value: total_amount.toFixed(2) });

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
                            toastr.success(response.message || 'Order updated successfully');
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON || {};
                            toastr.error(`Error updating order: ${response.message || 'Unknown error'}`);
                            if (response.errors) {
                                for (const [field, messages] of Object.entries(response.errors)) {
                                    const input = $(`#updateForm [name="${field}"], #updateForm [name^="${field.replace(/\./g, '\\.')}"]`);
                                    if (input.length) {
                                        input.addClass('is-invalid');
                                        const error = $('<span class="invalid-feedback"></span>').text(messages[0]);
                                        input.closest('.form-group').append(error);
                                    }
                                }
                            }
                        }
                    });
                }).catch(() => {
                    toastr.error('Error calculating total amount');
                });
            });
        });
    </script>
@endsection
