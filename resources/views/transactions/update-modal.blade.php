<!-- Update Transaction Modal (unchanged) -->
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
                        <label for="update_item_id">Item <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="update_item_id" name="item_id" required>
                            <option value="">Select Items</option>
                            @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                            @endforeach
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
