@extends('layouts.master')

@section('APP-TITLE')
    Service List
@endsection

@section('active-services')
    active
@endsection

@section('APP-SUBTITLE')
    Manage Services
@endsection

@section('APP-CONTENT')
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">@yield('APP-SUBTITLE')</h3>
        </div>
        <div class="card-body">
            <div class="" id="toolbar">
                <button class="btn btn-primary" id="add-new-btn">
                    <i class="bi bi-plus"></i> New Service
                </button>
            </div>
            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true"
                data-show-refresh="true" data-show-toggle="true" data-show-export="true" data-filter-control="true"
                data-sticky-header="true" data-show-jump-to="true" data-url="{{ route('services.index') }}"
                data-toolbar="#toolbar">
                <thead>
                    <tr>
                        <th data-field="id">#</th>
                        <th data-field="name">Name</th>
                        <th data-field="description" data-formatter="descriptionFormatter">Description</th>
                        <th data-field="kilograms">KG Limit</th>
                        <th data-field="price" data-formatter="priceFormatter">Price</th>
                        <th data-field="action" data-formatter="getActionFormatter">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Add Service Modal -->
    <div id="addModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="addForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Service</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="add_name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_name" name="name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_kilograms">KG Limit <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="add_kilograms" name="kilograms" required
                                min="0">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_price">Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="add_price" name="price" required step="0.01"
                                min="0">
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="add_description">Description</label>
                            <textarea class="form-control" id="add_description" name="description" rows="4"></textarea>
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

    <!-- Update Service Modal -->
    <div id="updateModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="updateForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Service</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="update_name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="update_name" name="name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_kilograms">KG Limit <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="update_kilograms" name="kilograms" required
                                min="0">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_price">Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="update_price" name="price" required
                                step="0.01" min="0">
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="update_description">Description</label>
                            <textarea class="form-control" id="update_description" name="description" rows="4"></textarea>
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
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
        // Table formatters
        function priceFormatter(value) {
            return value ? `₱${parseFloat(value).toFixed(2)}` : 'N/A';
        }

        function descriptionFormatter(value) {
            if (!value) return 'N/A';
            const maxLength = 50;
            return value.length > maxLength ?
                `<span title="${value}">${value.substring(0, maxLength)}...</span>` :
                value;
        }

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

        // AJAX functions
        function editData(id) {
            $.ajax({
                method: 'GET',
                url: `{{ route('services.index') }}/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.content || response;
                    $('#updateForm').data('id', data.id); // Store ID in form data
                    $('#updateForm').find('#update_name').val(data.name);
                    $('#updateForm').find('#update_description').val(data.description || '');
                    $('#updateForm').find('#update_kilograms').val(data.kilograms);
                    $('#updateForm').find('#update_price').val(data.price);
                    $('#updateModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                },
                error: function(xhr) {
                    toastr.error('Error fetching service data: ' + (xhr.responseJSON?.message ||
                        'Unknown error'));
                }
            });
        }

        function deleteData(id) {
            Swal.fire({
                title: "Confirm Deletion",
                text: "Are you sure you want to delete this service? This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: `{{ route('services.index') }}/${id}`,
                        dataType: 'json',
                        cache: false,
                        success: function(response) {
                            $('#table').bootstrapTable('refresh');
                            toastr.success(response.message ||
                                'Service deleted successfully');
                        },
                        error: function(xhr) {
                            toastr.error('Error deleting service: ' + (xhr.responseJSON
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

        $(document).ready(function() {
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
                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            });

            // Form validation for addForm
            $('#addForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    kilograms: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 0
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
                        title: "Confirm Creation",
                        text: "Are you sure you want to add this new service?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, add it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'POST',
                                url: '{{ route('services.store') }}',
                                data: $(form).serialize(),
                                dataType: 'json',
                                cache: false,
                                success: function(response) {
                                    $('#addModal').modal('hide');
                                    $('#table').bootstrapTable('refresh');
                                    $(form).trigger('reset');
                                    toastr.success(response.message ||
                                        'Service added successfully');
                                },
                                error: function(xhr) {
                                    toastr.error('Error adding service: ' + (xhr
                                        .responseJSON?.message ||
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
                    name: {
                        required: true,
                        minlength: 2
                    },
                    kilograms: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 0
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
                        text: "Are you sure you want to update this service?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, update it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const dataId = $(form).data('id');
                            $.ajax({
                                method: 'PUT',
                                url: `{{ route('services.index') }}/${dataId}`,
                                data: $(form).serialize(),
                                dataType: 'json',
                                cache: false,
                                success: function(response) {
                                    $('#updateModal').modal('hide');
                                    $('#table').bootstrapTable('refresh');
                                    $(form).trigger('reset');
                                    toastr.success(response.message ||
                                        'Service updated successfully');
                                },
                                error: function(xhr) {
                                    toastr.error('Error updating service: ' + (xhr
                                        .responseJSON?.message ||
                                        'Unknown error'));
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
