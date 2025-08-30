@extends('layouts.master')
@section('APP-TITLE')
    User List
@endsection
@section('active-user-list')
    active
@endsection
@section('APP-CONTENT')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap">
                <div class="header-title">
                    <h4 class="card-title mb-0">@yield('APP-TITLE')</h4>
                </div>
                <div class="">
                    <button href="#" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" id="add-new-btn">
                        <i class="btn-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </i>
                        <span>New User</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                        data-show-columns="true" data-show-refresh="true" data-show-toggle="true" data-show-export="true"
                        data-filter-control="true" data-sticky-header="true" data-show-jump-to="true"
                        data-url="{{ route('users.index') }}" data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <th data-field="id">ID</th>
                                <th data-field="fullname">Fullname</th>
                                <th data-field="phone_number">Phone Number</th>
                                <th data-field="email">Email</th>
                                <th data-field="address">Address</th>
                                <th data-field="role">Role</th>
                                <th data-field="status" data-formatter="getStatusFormatter">Status</th>
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
                    <h3 class="modal-title">Add New User</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="first_name">First Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="middle_name">Middle Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="col-lg-6">
                            <label for="last_name">Last Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="extension_name">Extension Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="extension_name" name="extension_name">
                        </div>
                        <div class="col-lg-6">
                            <label for="phone_number">Phone Number: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="email">Email Address: <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="address">Address: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="role">Role: <span class="text-danger">*</span></label>
                            <select type="text" class="form-control" id="role" name="role">
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                                <option value="Owner">Owner</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="password">Password: <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="col-lg-6">
                            <label for="password_confirmation">Confirm Password: <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
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
                    <h3 class="modal-title">Update User</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="first_name">First Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="middle_name">Middle Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="col-lg-6">
                            <label for="last_name">Last Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="extension_name">Extension Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="extension_name" name="extension_name">
                        </div>
                        <div class="col-lg-6">
                            <label for="phone_number">Phone Number: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="email">Email Address: <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="address">Address: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="role">Role: <span class="text-danger">*</span></label>
                            <select type="text" class="form-control" id="role" name="role">
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                                <option value="Owner">Owner</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button class="btn btn-md btn-primary">Submit</button>
                    <button class="btn btn-md btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
        let dataId;


        function getStatusFormatter(value, row) {
            // Handle missing row or invalid ID
            if (!row || row.id === undefined || row.id === null) {
                return `<span class="badge bg-secondary text-light fw-semibold px-3 py-2">No actions</span>`;
            }

            // Normalize value (in case of lowercase/mixed)
            const status = (value || '').toString().trim().toLowerCase();

            if (status === 'active') {
                return `<span class="badge rounded-pill bg-success text-white fw-semibold px-3 py-2 shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> ${value}
                </span>`;
            }

            return `<span class="badge rounded-pill bg-danger text-white fw-semibold px-3 py-2 shadow-sm">
                <i class="bi bi-x-circle-fill me-1"></i> ${value}
            </span>`;
        }

        function getActionFormatter(value, row) {
            // Ensure row is defined and has an id
            if (!row || row.id === undefined || row.id === null) {
                return '<span class="text-muted">No actions available</span>';
            }
            return `
                <button class="btn btn-sm btn-primary me-1" onclick="editData(${row.id})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger me-1" onclick="deleteData(${row.id})" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            `;
        }

        function editData(id) {
            $.ajax({
                method: 'GET',
                url: `/users/${id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    var data = response.content;
                    dataId = data.id;
                    $('#updateForm').find('input[id=first_name]').val(data.first_name);
                    $('#updateForm').find('input[id=middle_name]').val(data.middle_name);
                    $('#updateForm').find('input[id=last_name]').val(data.last_name);
                    $('#updateForm').find('input[id=extension_name]').val(data.extension_name);
                    $('#updateForm').find('input[id=phone_number]').val(data.phone_number);
                    $('#updateForm').find('input[id=email]').val(data.email);
                    $('#updateForm').find('input[id=address]').val(data.address);
                    $('#updateForm').find('select[id=role]').val(data.role);
                    $('#updateModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                },
                error: function(xhr) {
                    toastr.error('Error fetching user data: ' + (xhr.responseText || 'Unknown error'));
                }
            });
        }

        function deleteData(id) {
            $.ajax({
                method: 'DELETE',
                url: `/users/${id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    $('#table').bootstrapTable('refresh');
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    let message = 'Error deleting user.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message);
                }
            });
        }

        // Function to check if the device is mobile (based on screen width)
        function isMobile() {
            return window.innerWidth <= 576; // Bootstrap's 'sm' breakpoint
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
                pipeline: true,
                cache: true,
                cacheAmount: 100,
                showCustomView: isMobile(), // Enable custom view on mobile
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

            $('#add-new-btn').click(function() {
                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            });

            $('#addForm').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    method: 'POST',
                    url: '{{ route('users.store') }}',
                    data: $('#addForm').serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        $('#addModal').modal('hide');
                        $('#table').bootstrapTable('refresh');
                        $('#addForm').trigger('reset');
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        let response;
                        try {
                            response = JSON.parse(xhr.responseText);
                            toastr.error('Error adding user: ' + (response
                                .message || 'An unknown error occurred.'));
                            if (response.errors) {
                                for (const field in response.errors) {
                                    const messages = response.errors[field];
                                    if (messages.length > 0) {
                                        const input = $(
                                            `#addForm [name="${field}"]`
                                        );
                                        input.addClass('is-invalid');
                                        input.closest('.form-group').find(
                                            'span.invalid-feedback').remove();
                                        const error = $(
                                            '<span class="invalid-feedback"></span>'
                                        ).text(messages[0]);
                                        input.closest('.form-group').append(error);
                                    }
                                }
                            }
                        } catch (e) {
                            toastr.error('Error parsing server response.');
                        }
                    }
                });
            });

            $('#updateForm').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    method: 'PUT',
                    url: `/users/${dataId}`,
                    data: $('#updateForm').serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        $('#updateModal').modal('hide');
                        $('#table').bootstrapTable('refresh');
                        $('#updateForm').trigger('reset');
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        let response;
                        try {
                            response = JSON.parse(xhr.responseText);
                            toastr.error('Error updating user: ' + (response
                                .message || 'An unknown error occurred.'));
                            if (response.errors) {
                                for (const field in response.errors) {
                                    const messages = response.errors[field];
                                    if (messages.length > 0) {
                                        const input = $(
                                            `#updateForm [name="${field}"]`
                                        );
                                        input.addClass('is-invalid');
                                        input.closest('.form-group').find(
                                            'span.invalid-feedback').remove();
                                        const error = $(
                                            '<span class="invalid-feedback"></span>'
                                        ).text(messages[0]);
                                        input.closest('.form-group').append(error);
                                    }
                                }
                            }
                        } catch (e) {
                            toastr.error('Error parsing server response.');
                        }
                    }
                });
            });

        });
    </script>
@endsection
