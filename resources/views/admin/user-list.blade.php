@extends('layouts.master')

@section('APP-TITLE')
    User List
@endsection

@section('active-users')
    active
@endsection

@section('APP-SUBTITLE')
    Manage Users
@endsection

@section('APP-CONTENT')
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">@yield('APP-SUBTITLE')</h3>
        </div>
        <div class="card-body">
            <div class="" id="toolbar">
                <button class="btn btn-primary" id="add-new-btn">
                    <i class="bi bi-plus"></i> New User
                </button>
            </div>
            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true"
                data-show-refresh="true" data-show-toggle="true" data-show-export="true" data-filter-control="true"
                data-sticky-header="true" data-show-jump-to="true" data-url="{{ route('users.index') }}"
                data-toolbar="#toolbar">
                <thead>
                    <tr>
                        <th data-field="id">#</th>
                        <th data-field="fullname">Fullname</th>
                        <th data-field="phone_number">Phone Number</th>
                        <th data-field="email">Email</th>
                        <th data-field="address" data-formatter="getAddressFormatter">Address</th>
                        <th data-field="role">Role</th>
                        <th data-field="status" data-formatter="getStatusFormatter">Status</th>
                        <th data-field="action" data-formatter="getActionFormatter">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="addForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New User</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="add_first_name">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_first_name" name="first_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_middle_name">Middle Name</label>
                            <input type="text" class="form-control" id="add_middle_name" name="middle_name">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_last_name">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_last_name" name="last_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_extension_name">Extension Name</label>
                            <input type="text" class="form-control" id="add_extension_name" name="extension_name">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_phone_number">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_phone_number" name="phone_number" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="add_email" name="email" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_address">Address <span class="text-danger">*</span></label>
                            <select name="address" id="add_address" class="form-control select2" required>
                                <option value="" selected disabled>Select Address</option>
                                <option value="Alangilan">Brgy Alangilan, Abuyog, Leyte</option>
                                <option value="Anibongan">Brgy Anibongan, Abuyog, Leyte</option>
                                <option value="Bagacay">Brgy Bagacay, Abuyog, Leyte</option>
                                <option value="Bahay">Brgy Bahay, Abuyog, Leyte</option>
                                <option value="Balinsasayao">Brgy Balinsasayao, Abuyog, Leyte</option>
                                <option value="Balocawe">Brgy Balocawe, Abuyog, Leyte</option>
                                <option value="Balocawehay">Brgy Balocawehay, Abuyog, Leyte</option>
                                <option value="Barayong">Brgy Barayong, Abuyog, Leyte</option>
                                <option value="Bayabas">Brgy Bayabas, Abuyog, Leyte</option>
                                <option value="Bito">Brgy Bito, Abuyog, Leyte</option>
                                <option value="Buaya">Brgy Buaya, Abuyog, Leyte</option>
                                <option value="Buenavista">Brgy Buenavista, Abuyog, Leyte</option>
                                <option value="Bulak">Brgy Bulak, Abuyog, Leyte</option>
                                <option value="Bunga">Brgy Bunga, Abuyog, Leyte</option>
                                <option value="Buntay">Brgy Buntay, Abuyog, Leyte</option>
                                <option value="Burubud-an">Brgy Burubud-an, Abuyog, Leyte</option>
                                <option value="Cadac-an">Brgy Cadac-an, Abuyog, Leyte</option>
                                <option value="Cagbolo">Brgy Cagbolo, Abuyog, Leyte</option>
                                <option value="Can-aporong">Brgy Can-aporong, Abuyog, Leyte</option>
                                <option value="Can-uguib">Brgy Can-uguib, Abuyog, Leyte</option>
                                <option value="Canmarating">Brgy Canmarating, Abuyog, Leyte</option>
                                <option value="Capilian">Brgy Capilian, Abuyog, Leyte</option>
                                <option value="Combis">Brgy Combis, Abuyog, Leyte</option>
                                <option value="Dingle">Brgy Dingle, Abuyog, Leyte</option>
                                <option value="Guintagbucan">Brgy Guintagbucan, Abuyog, Leyte</option>
                                <option value="Hampipila">Brgy Hampipila, Abuyog, Leyte</option>
                                <option value="Katipunan">Brgy Katipunan, Abuyog, Leyte</option>
                                <option value="Kikilo">Brgy Kikilo, Abuyog, Leyte</option>
                                <option value="Laray">Brgy Laray, Abuyog, Leyte</option>
                                <option value="Lawa-an">Brgy Lawa-an, Abuyog, Leyte</option>
                                <option value="Libertad">Brgy Libertad, Abuyog, Leyte</option>
                                <option value="Loyonsawang">Brgy Loyonsawang, Abuyog, Leyte</option>
                                <option value="Mag-atubang">Brgy Mag-atubang, Abuyog, Leyte</option>
                                <option value="Mahagna">Brgy Mahagna, Abuyog, Leyte</option>
                                <option value="Mahayahay">Brgy Mahayahay, Abuyog, Leyte</option>
                                <option value="Maitum">Brgy Maitum, Abuyog, Leyte</option>
                                <option value="Malaguicay">Brgy Malaguicay, Abuyog, Leyte</option>
                                <option value="Matagnao">Brgy Matagnao, Abuyog, Leyte</option>
                                <option value="Nalibunan">Brgy Nalibunan, Abuyog, Leyte</option>
                                <option value="Nebga">Brgy Nebga, Abuyog, Leyte</option>
                                <option value="New Taligue">Brgy New Taligue, Abuyog, Leyte</option>
                                <option value="Odiongan">Brgy Odiongan, Abuyog, Leyte</option>
                                <option value="Old Taligue">Brgy Old Taligue, Abuyog, Leyte</option>
                                <option value="Pagsang-an">Brgy Pagsang-an, Abuyog, Leyte</option>
                                <option value="Paguite">Brgy Paguite, Abuyog, Leyte</option>
                                <option value="Parasanon">Brgy Parasanon, Abuyog, Leyte</option>
                                <option value="Picas Sur">Brgy Picas Sur, Abuyog, Leyte</option>
                                <option value="Pilar">Brgy Pilar, Abuyog, Leyte</option>
                                <option value="Pinamanagan">Brgy Pinamanagan, Abuyog, Leyte</option>
                                <option value="Salvacion">Brgy Salvacion, Abuyog, Leyte</option>
                                <option value="San Francisco">Brgy San Francisco, Abuyog, Leyte</option>
                                <option value="San Isidro">Brgy San Isidro, Abuyog, Leyte</option>
                                <option value="San Roque">Brgy San Roque, Abuyog, Leyte</option>
                                <option value="Santa Fe">Brgy Santa Fe, Abuyog, Leyte</option>
                                <option value="Santa Lucia">Brgy Santa Lucia, Abuyog, Leyte</option>
                                <option value="Santo Niño">Brgy Santo Niño, Abuyog, Leyte</option>
                                <option value="Tabigue">Brgy Tabigue, Abuyog, Leyte</option>
                                <option value="Tadoc">Brgy Tadoc, Abuyog, Leyte</option>
                                <option value="Tib-o">Brgy Tib-o, Abuyog, Leyte</option>
                                <option value="Tinalian">Brgy Tinalian, Abuyog, Leyte</option>
                                <option value="Tinocolan">Brgy Tinocolan, Abuyog, Leyte</option>
                                <option value="Tuy-a">Brgy Tuy-a, Abuyog, Leyte</option>
                                <option value="Victory">Brgy Victory, Abuyog, Leyte</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_role">Role <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="add_role" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                                <option value="Owner">Owner</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_password">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="add_password" name="password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-target="add_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="add_password_confirmation">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="add_password_confirmation"
                                    name="password_confirmation" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-target="add_password_confirmation">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
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

    <!-- Update User Modal -->
    <div id="updateModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="updateForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update User</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="update_first_name">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="update_first_name" name="first_name"
                                required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_middle_name">Middle Name</label>
                            <input type="text" class="form-control" id="update_middle_name" name="middle_name">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_last_name">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="update_last_name" name="last_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_extension_name">Extension Name</label>
                            <input type="text" class="form-control" id="update_extension_name" name="extension_name">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_phone_number">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="update_phone_number" name="phone_number"
                                required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="update_email" name="email" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_address">Address <span class="text-danger">*</span></label>
                            <select name="address" id="update_address" class="form-control select2" required>
                                <option value="" selected disabled>Select Address</option>
                                <option value="Alangilan">Brgy Alangilan, Abuyog, Leyte</option>
                                <option value="Anibongan">Brgy Anibongan, Abuyog, Leyte</option>
                                <option value="Bagacay">Brgy Bagacay, Abuyog, Leyte</option>
                                <option value="Bahay">Brgy Bahay, Abuyog, Leyte</option>
                                <option value="Balinsasayao">Brgy Balinsasayao, Abuyog, Leyte</option>
                                <option value="Balocawe">Brgy Balocawe, Abuyog, Leyte</option>
                                <option value="Balocawehay">Brgy Balocawehay, Abuyog, Leyte</option>
                                <option value="Barayong">Brgy Barayong, Abuyog, Leyte</option>
                                <option value="Bayabas">Brgy Bayabas, Abuyog, Leyte</option>
                                <option value="Bito">Brgy Bito, Abuyog, Leyte</option>
                                <option value="Buaya">Brgy Buaya, Abuyog, Leyte</option>
                                <option value="Buenavista">Brgy Buenavista, Abuyog, Leyte</option>
                                <option value="Bulak">Brgy Bulak, Abuyog, Leyte</option>
                                <option value="Bunga">Brgy Bunga, Abuyog, Leyte</option>
                                <option value="Buntay">Brgy Buntay, Abuyog, Leyte</option>
                                <option value="Burubud-an">Brgy Burubud-an, Abuyog, Leyte</option>
                                <option value="Cadac-an">Brgy Cadac-an, Abuyog, Leyte</option>
                                <option value="Cagbolo">Brgy Cagbolo, Abuyog, Leyte</option>
                                <option value="Can-aporong">Brgy Can-aporong, Abuyog, Leyte</option>
                                <option value="Can-uguib">Brgy Can-uguib, Abuyog, Leyte</option>
                                <option value="Canmarating">Brgy Canmarating, Abuyog, Leyte</option>
                                <option value="Capilian">Brgy Capilian, Abuyog, Leyte</option>
                                <option value="Combis">Brgy Combis, Abuyog, Leyte</option>
                                <option value="Dingle">Brgy Dingle, Abuyog, Leyte</option>
                                <option value="Guintagbucan">Brgy Guintagbucan, Abuyog, Leyte</option>
                                <option value="Hampipila">Brgy Hampipila, Abuyog, Leyte</option>
                                <option value="Katipunan">Brgy Katipunan, Abuyog, Leyte</option>
                                <option value="Kikilo">Brgy Kikilo, Abuyog, Leyte</option>
                                <option value="Laray">Brgy Laray, Abuyog, Leyte</option>
                                <option value="Lawa-an">Brgy Lawa-an, Abuyog, Leyte</option>
                                <option value="Libertad">Brgy Libertad, Abuyog, Leyte</option>
                                <option value="Loyonsawang">Brgy Loyonsawang, Abuyog, Leyte</option>
                                <option value="Mag-atubang">Brgy Mag-atubang, Abuyog, Leyte</option>
                                <option value="Mahagna">Brgy Mahagna, Abuyog, Leyte</option>
                                <option value="Mahayahay">Brgy Mahayahay, Abuyog, Leyte</option>
                                <option value="Maitum">Brgy Maitum, Abuyog, Leyte</option>
                                <option value="Malaguicay">Brgy Malaguicay, Abuyog, Leyte</option>
                                <option value="Matagnao">Brgy Matagnao, Abuyog, Leyte</option>
                                <option value="Nalibunan">Brgy Nalibunan, Abuyog, Leyte</option>
                                <option value="Nebga">Brgy Nebga, Abuyog, Leyte</option>
                                <option value="New Taligue">Brgy New Taligue, Abuyog, Leyte</option>
                                <option value="Odiongan">Brgy Odiongan, Abuyog, Leyte</option>
                                <option value="Old Taligue">Brgy Old Taligue, Abuyog, Leyte</option>
                                <option value="Pagsang-an">Brgy Pagsang-an, Abuyog, Leyte</option>
                                <option value="Paguite">Brgy Paguite, Abuyog, Leyte</option>
                                <option value="Parasanon">Brgy Parasanon, Abuyog, Leyte</option>
                                <option value="Picas Sur">Brgy Picas Sur, Abuyog, Leyte</option>
                                <option value="Pilar">Brgy Pilar, Abuyog, Leyte</option>
                                <option value="Pinamanagan">Brgy Pinamanagan, Abuyog, Leyte</option>
                                <option value="Salvacion">Brgy Salvacion, Abuyog, Leyte</option>
                                <option value="San Francisco">Brgy San Francisco, Abuyog, Leyte</option>
                                <option value="San Isidro">Brgy San Isidro, Abuyog, Leyte</option>
                                <option value="San Roque">Brgy San Roque, Abuyog, Leyte</option>
                                <option value="Santa Fe">Brgy Santa Fe, Abuyog, Leyte</option>
                                <option value="Santa Lucia">Brgy Santa Lucia, Abuyog, Leyte</option>
                                <option value="Santo Niño">Brgy Santo Niño, Abuyog, Leyte</option>
                                <option value="Tabigue">Brgy Tabigue, Abuyog, Leyte</option>
                                <option value="Tadoc">Brgy Tadoc, Abuyog, Leyte</option>
                                <option value="Tib-o">Brgy Tib-o, Abuyog, Leyte</option>
                                <option value="Tinalian">Brgy Tinalian, Abuyog, Leyte</option>
                                <option value="Tinocolan">Brgy Tinocolan, Abuyog, Leyte</option>
                                <option value="Tuy-a">Brgy Tuy-a, Abuyog, Leyte</option>
                                <option value="Victory">Brgy Victory, Abuyog, Leyte</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="update_role">Role <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_role" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                                <option value="Owner">Owner</option>
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

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal">
        <div class="modal-dialog">
            <form class="modal-content" id="changePasswordForm">
                <div class="modal-header">
                    <h3 class="modal-title">Change Password</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="change_password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="change_password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="change_password_confirmation">Confirm Password <span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="change_password_confirmation"
                            name="password_confirmation" required>
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
        function getAddressFormatter(value, row) {
            return value ? `Brgy. ${value}, Abuyog, Leyte` : 'N/A';
        }

        function getStatusFormatter(value) {
            let badgeClass = value === 'Active' ? 'bg-success' : 'bg-danger';
            return `<span class="badge ${badgeClass}">${value}</span>`;
        }

        function getActionFormatter(value, row) {
            if (!row || !row.id) {
                return '<span class="text-muted">No actions</span>';
            }
            let statusButton = row.status === 'Active' ?
                `<button type="button" class="btn btn-sm btn-warning me-1" onclick="statusData(${row.id})" title="Deactivate"><i class="bi bi-lock"></i></button>` :
                `<button type="button" class="btn btn-sm btn-success me-1" onclick="statusData(${row.id})" title="Activate"><i class="bi bi-unlock"></i></button>`;
            return `
                    <button type="button" class="btn btn-sm btn-primary me-1" onclick="editData(${row.id})" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    ${statusButton}
                    <button type="button" class="btn btn-sm btn-info me-1" onclick="changeData(${row.id})" title="Change Password">
                        <i class="bi bi-key"></i>
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
                url: `/users/${id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    var data = response.content;
                    dataId = data.id;
                    $('#updateForm').find('#update_first_name').val(data.first_name);
                    $('#updateForm').find('#update_middle_name').val(data.middle_name);
                    $('#updateForm').find('#update_last_name').val(data.last_name);
                    $('#updateForm').find('#update_extension_name').val(data.extension_name);
                    $('#updateForm').find('#update_phone_number').val(data.phone_number);
                    $('#updateForm').find('#update_email').val(data.email);
                    $('#updateForm').find('#update_address').val(data.address).trigger('change');
                    $('#updateForm').find('#update_role').val(data.role).trigger('change');
                    $('#updateModal').modal('show');
                },
                error: function(xhr) {
                    toastr.error('Error fetching user data: ' + (xhr.responseJSON?.message ||
                        'Unknown error'));
                }
            });
        }

        function changeData(id) {
            dataId = id;
            $('#changePasswordModal').modal('show');
        }

        function statusData(id) {
            Swal.fire({
                title: "Confirm Status Change",
                text: "Are you sure you want to change the status of this user?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, change it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'PUT',
                        url: `/users/${id}/changeStatus`,
                        dataType: 'JSON',
                        cache: false,
                        success: function(response) {
                            $('#table').bootstrapTable('refresh');
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error('Error changing status: ' + (xhr.responseJSON
                                ?.message || 'Unknown error'));
                        }
                    });
                }
            });
        }

        function deleteData(id) {
            Swal.fire({
                title: "Confirm Deletion",
                text: "Are you sure you want to delete this user? This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
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
                            toastr.error('Error deleting user: ' + (xhr.responseJSON
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
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });

            $('#add-new-btn').click(function() {
                $('#addModal').modal('show');
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

            // Form validation for addForm
            $('#addForm').validate({
                rules: {
                    first_name: {
                        required: true,
                        minlength: 2
                    },
                    last_name: {
                        required: true,
                        minlength: 2
                    },
                    phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    address: {
                        required: true
                    },
                    role: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: '#add_password'
                    }
                },
                messages: {
                    password_confirmation: {
                        equalTo: 'Passwords do not match.'
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
                        text: "Are you sure you want to add this new user?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, add it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'POST',
                                url: '{{ route('users.store') }}',
                                data: $(form).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    $('#addModal').modal('hide');
                                    $('#table').bootstrapTable('refresh');
                                    $(form).trigger('reset');
                                    toastr.success(response.message);
                                },
                                error: function(xhr) {
                                    toastr.error('Error adding user: ' + (xhr
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
                    first_name: {
                        required: true,
                        minlength: 2
                    },
                    last_name: {
                        required: true,
                        minlength: 2
                    },
                    phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    address: {
                        required: true
                    },
                    role: {
                        required: true
                    },
                },
                messages: {
                    password_confirmation: {
                        equalTo: 'Passwords do not match.'
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
                        text: "Are you sure you want to update this user?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, update it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'PUT',
                                url: `/users/${dataId}`,
                                data: $(form).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    $('#updateModal').modal('hide');
                                    $('#table').bootstrapTable('refresh');
                                    $(form).trigger('reset');
                                    toastr.success(response.message);
                                },
                                error: function(xhr) {
                                    toastr.error('Error updating user: ' + (xhr
                                        .responseJSON?.message ||
                                        'Unknown error'));
                                }
                            });
                        }
                    });
                }
            });

            // Form validation for changePasswordForm
            $('#changePasswordForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: '#change_password'
                    }
                },
                messages: {
                    password_confirmation: {
                        equalTo: 'Passwords do not match.'
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
                        title: "Confirm Password Change",
                        text: "Are you sure you want to change the password for this user?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, change it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'PUT',
                                url: `/users/${dataId}/changePassword`,
                                data: $(form).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    $('#changePasswordModal').modal('hide');
                                    $('#table').bootstrapTable('refresh');
                                    $(form).trigger('reset');
                                    toastr.success(response.message);
                                },
                                error: function(xhr) {
                                    toastr.error('Error updating password: ' + (xhr
                                        .responseJSON?.message ||
                                        'Unknown error'));
                                }
                            });
                        }
                    });
                }
            });

            // Password toggle functionality
            $(document).on('click', '.toggle-password', function() {
                var targetId = $(this).data('target');
                var $input = $('#' + targetId);
                var $icon = $(this).find('i');
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('bi-eye').addClass('bi-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('bi-eye-slash').addClass('bi-eye');
                }
            });
        });
    </script>
@endsection
