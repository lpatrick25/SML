@extends('layouts.master')
@section('APP-TITLE')
    Customer List
@endsection
@section('active-customers-management')
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
                        <span>New Customer</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                        data-show-columns="true" data-show-refresh="true" data-show-toggle="true" data-show-export="true"
                        data-filter-control="true" data-sticky-header="true" data-show-jump-to="true"
                        data-url="{{ route('customers.index') }}" data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <th data-field="id">#</th>
                                <th data-field="fullname" data-formatter="getFullnameFormatter">Fullname</th>
                                <th data-field="phone">Phone</th>
                                <th data-field="email">Email</th>
                                <th data-field="address" data-formatter="getAddressFormatter">Address</th>
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
                    <h3 class="modal-title">Add New Customer</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="first_name">First Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="middle_name">Middle Name:</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="last_name">Last Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="extension">Extension:</label>
                            <input type="text" class="form-control" id="extension" name="extension">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="phone">Phone: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="email">Email Address: <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="address">Address: <span class="text-danger">*</span></label>
                            <select name="address" id="address" class="form-control">
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
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-md btn-primary">Save</button>
                    <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <div id="updateModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="updateForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Customer</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="first_name">First Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="middle_name">Middle Name:</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="last_name">Last Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="extension">Extension:</label>
                            <input type="text" class="form-control" id="extension" name="extension">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="phone">Phone: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="email">Email Address: <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="address">Address: <span class="text-danger">*</span></label>
                            <select name="address" id="address" class="form-control">
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
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-md btn-primary">Save</button>
                    <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
        let dataId;

        function getAddressFormatter(value, row) {
            // Handle missing row or invalid ID
            if (!row || row.id === undefined || row.id === null) {
                return `<span class="badge bg-secondary text-light fw-semibold px-3 py-2">No actions</span>`;
            }

            return `<span class="badge rounded-pill bg-info text-white fw-semibold px-3 py-2 shadow-sm">
                <i class="bi bi-geo-alt-fill me-1"></i>Brgy. ${value}, Abuyog, Leyte
            </span>`;
        }

        function getFullnameFormatter(value, row) {
            if (!row) return 'N/A';
            const parts = [
                row.first_name,
                row.middle_name,
                row.last_name,
                row.extension
            ].filter(part => part).join(' ');
            return parts || 'N/A';
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

        function editData(id) {
            $.ajax({
                method: 'GET',
                url: `{{ route('customers.index') }}/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.content || response;
                    dataId = data.id;
                    $('#updateForm').find('#first_name').val(data.first_name);
                    $('#updateForm').find('#middle_name').val(data.middle_name || '');
                    $('#updateForm').find('#last_name').val(data.last_name);
                    $('#updateForm').find('#extension').val(data.extension || '');
                    $('#updateForm').find('#phone').val(data.phone);
                    $('#updateForm').find('#email').val(data.email);
                    $('#updateForm').find('#address').val(data.address);
                    $('#updateModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                },
                error: function(xhr) {
                    toastr.error(
                        `Error fetching customer data: ${xhr.responseJSON?.message || 'Unknown error'}`);
                }
            });
        }

        function deleteData(id) {
            if (!confirm('Are you sure you want to delete this customer?')) return;
            $.ajax({
                method: 'DELETE',
                url: `{{ route('customers.index') }}/${id}`,
                dataType: 'json',
                cache: false,
                success: function(response) {
                    $('#table').bootstrapTable('refresh');
                    toastr.success(response.message || 'Customer deleted successfully');
                },
                error: function(xhr) {
                    let message = 'Error customer user.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message);
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

                $.ajax({
                    method: 'POST',
                    url: '{{ route('customers.store') }}',
                    data: $(this).serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        $('#addModal').modal('hide');
                        $('#table').bootstrapTable('refresh');
                        $('#addForm').trigger('reset');
                        toastr.success(response.message || 'Customer added successfully');
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON || {};
                        toastr.error(
                            `Error adding customer: ${response.message || 'Unknown error'}`
                        );
                        if (response.errors) {
                            for (const [field, messages] of Object.entries(response
                                    .errors)) {
                                const input = $(`#addForm [name="${field}"]`);
                                if (input.length) {
                                    input.addClass('is-invalid');
                                    const error = $(
                                        '<span class="invalid-feedback"></span>').text(
                                        messages[0]);
                                    input.closest('.form-group').append(error);
                                }
                            }
                        }
                    }
                });
            });

            $('#updateForm').submit(function(event) {
                event.preventDefault();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').remove();

                $.ajax({
                    method: 'PUT',
                    url: `{{ route('customers.index') }}/${dataId}`,
                    data: $(this).serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        $('#updateModal').modal('hide');
                        $('#table').bootstrapTable('refresh');
                        $('#updateForm').trigger('reset');
                        toastr.success(response.message || 'Customer updated successfully');
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON || {};
                        toastr.error(
                            `Error updating customer: ${response.message || 'Unknown error'}`
                        );
                        if (response.errors) {
                            for (const [field, messages] of Object.entries(response
                                    .errors)) {
                                const input = $(`#updateForm [name="${field}"]`);
                                if (input.length) {
                                    input.addClass('is-invalid');
                                    const error = $(
                                        '<span class="invalid-feedback"></span>').text(
                                        messages[0]);
                                    input.closest('.form-group').append(error);
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
