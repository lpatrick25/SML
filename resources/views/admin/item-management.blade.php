@extends('layouts.master')
@section('APP-TITLE')
    Item List
@endsection
@section('active-item-management')
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
                        <span>New Item</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                        data-show-columns="true" data-show-refresh="true" data-show-toggle="true" data-show-export="true"
                        data-filter-control="true" data-sticky-header="true" data-show-jump-to="true"
                        data-url="{{ route('items.index') }}" data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <th data-field="id">#</th>
                                <th data-field="item_name">Item Name</th>
                                <th data-field="description">Description</th>
                                <th data-field="quantity">Quantity</th>
                                <th data-field="unit">Unit</th>
                                <th data-field="action" data-formatter="getActionFormatter">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="addModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="addForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Item</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="item_name">Item Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="item_name" name="item_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="quantity">Quantity: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required
                                min="0">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="unit">Unit: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="unit" name="unit" required>
                            <!-- Optional: Replace with dropdown if units are predefined -->
                            <!--
                                    <select class="form-control" id="unit" name="unit" required>
                                        <option value="kg">Kilograms</option>
                                        <option value="liters">Liters</option>
                                        <option value="pieces">Pieces</option>
                                    </select>
                                    -->
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
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
    <div id="updateModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="updateForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Item</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="item_name">Item Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="item_name" name="item_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="quantity">Quantity: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required
                                min="0">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="unit">Unit: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="unit" name="unit" required>
                            <!-- Optional: Replace with dropdown if units are predefined -->
                            <!--
                                    <select class="form-control" id="unit" name="unit" required>
                                        <option value="kg">Kilograms</option>
                                        <option value="liters">Liters</option>
                                        <option value="pieces">Pieces</option>
                                    </select>
                                    -->
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
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
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
        let dataId;

        function getActionFormatter(value, row) {
            if (!row || !row.id) {
                return '<span class="text-muted">No actions</span>';
            }
            return `
                <button type="button" class="btn btn-sm btn-primary me-1" onclick="editData(${row.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger me-1" onclick="deleteData(${row.id})" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            `;
        }

        function editData(id) {
            $.ajax({
                method: 'GET',
                url: `{{ route('items.index') }}/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.content || response;
                    dataId = data.id;
                    $('#updateForm').find('#item_name').val(data.item_name);
                    $('#updateForm').find('#description').val(data.description || '');
                    $('#updateForm').find('#quantity').val(data.quantity);
                    $('#updateForm').find('#unit').val(data.unit);
                    $('#updateModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                },
                error: function(xhr) {
                    toastr.error(
                        `Error fetching item data: ${xhr.responseJSON?.message || 'Unknown error'}`);
                }
            });
        }

        function deleteData(id) {
            swal.fire({
                title: "Confirm Deletion",
                text: "Are you sure you want to delete this item? This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: `{{ route('items.index') }}/${id}`,
                        dataType: 'json',
                        cache: false,
                        success: function(response) {
                            $('#table').bootstrapTable('refresh');
                            toastr.success(response.message || 'Item item deleted successfully');
                        },
                        error: function(xhr) {
                            toastr.error(
                                `Error deleting item item: ${xhr.responseJSON?.message || 'Unknown error'}`
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

            $('#add-new-btn').click(function() {
                $('#addForm').trigger('reset').find('.is-invalid').removeClass('is-invalid');
                $('#addForm').find('.invalid-feedback').remove();
                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            });

            $('#addForm').submit(function(event) {
                event.preventDefault();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').remove();
                swal.fire({
                    title: "Confirm Creation",
                    text: "Are you sure you want to add this new item?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, add it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'POST',
                            url: '{{ route('items.store') }}',
                            data: $(this).serialize(),
                            dataType: 'json',
                            cache: false,
                            success: function(response) {
                                $('#addModal').modal('hide');
                                $('#table').bootstrapTable('refresh');
                                $('#addForm').trigger('reset');
                                toastr.success(response.message ||
                                    'Item item added successfully');
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON || {};
                                toastr.error(
                                    `Error adding item item: ${response.message || 'Unknown error'}`
                                );
                                if (response.errors) {
                                    for (const [field, messages] of Object.entries(
                                            response.errors)) {
                                        const input = $(`#addForm [name="${field}"]`);
                                        if (input.length) {
                                            input.addClass('is-invalid');
                                            const error = $(
                                                    '<span class="invalid-feedback"></span>'
                                                    )
                                                .text(messages[0]);
                                            input.closest('.form-group').append(error);
                                        }
                                    }
                                }
                            }
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
                    text: "Are you sure you want to update this item?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, update it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'PUT',
                            url: `{{ route('items.index') }}/${dataId}`,
                            data: $(this).serialize(),
                            dataType: 'json',
                            cache: false,
                            success: function(response) {
                                $('#updateModal').modal('hide');
                                $('#table').bootstrapTable('refresh');
                                $('#updateForm').trigger('reset');
                                toastr.success(response.message ||
                                    'Item item updated successfully');
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON || {};
                                toastr.error(
                                    `Error updating item item: ${response.message || 'Unknown error'}`
                                );
                                if (response.errors) {
                                    for (const [field, messages] of Object.entries(
                                            response.errors)) {
                                        const input = $(
                                        `#updateForm [name="${field}"]`);
                                        if (input.length) {
                                            input.addClass('is-invalid');
                                            const error = $(
                                                    '<span class="invalid-feedback"></span>'
                                                    )
                                                .text(messages[0]);
                                            input.closest('.form-group').append(error);
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
