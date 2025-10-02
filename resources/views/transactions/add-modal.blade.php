<!-- Add Transaction Wizard Modal -->
<div id="addModal" class="modal fade">
    <div class="modal-dialog">
        <form id="addForm" class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">New Transaction Wizard</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="staff_id" name="staff_id" value="{{ auth()->user()->id }}">
                <input type="hidden" id="transaction_id" name="transaction_id">
                <input type="hidden" id="load" name="load">
                <input type="hidden" id="total_amount" name="total_amount">

                <!-- Step 1: Customer -->
                <div id="step1" class="wizard-step active">
                    <h6>Step 1: Select Customer</h6>
                    <div class="form-group mb-3">
                        <label for="add_transaction_date">Transaction Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="add_transaction_date" name="transaction_date"
                            readonly value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="add_customer_id">Customer <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="add_customer_id" name="customer_id" required>
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="prev1" disabled>Previous</button>
                        <button type="button" class="btn btn-primary" id="next1">Next</button>
                    </div>
                </div>

                <!-- Step 2: Service & Items -->
                <div id="step2" class="wizard-step">
                    <h6>Step 2: Select Service & Items</h6>
                    <div class="form-group mb-3">
                        <label for="add_service_id">Service <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="add_service_id" name="service_id" required>
                            <option value="">Select Service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" data-kilograms="{{ $service->kilograms }}"
                                    data-price="{{ $service->price }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="add_item_id">Item <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="add_item_id" name="item_id" required>
                            <option value="">Select Item</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="add_kilograms">Kilograms <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="add_kilograms" name="kilograms" min="1"
                            required>
                    </div>
                    <div id="totalPreview" class="alert alert-info" style="display:none;"></div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="prev2">Previous</button>
                        <button type="button" class="btn btn-primary" id="next2">Next</button>
                    </div>
                </div>

                <!-- Step 3: Payment -->
                <div id="step3" class="wizard-step">
                    <h6>Step 3: Payment Method</h6>
                    <div class="form-group mb-3">
                        <label class="form-label">Choose Payment Method <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="cash"
                                value="cash" checked>
                            <label class="form-check-label" for="cash">Cash</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="gcash"
                                value="gcash">
                            <label class="form-check-label" for="gcash">GCash</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="paymaya"
                                value="paymaya">
                            <label class="form-check-label" for="paymaya">PayMaya</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="prev3">Previous</button>
                        <button type="button" class="btn btn-primary" id="submit">Create Transaction</button>
                    </div>
                </div>

                <!-- Step 4: QR Code (for online) -->
                <div id="step4" class="wizard-step" style="display:none;">
                    <h6>Payment QR Code</h6>
                    <div id="qrContainer" class="text-center mb-3"></div>
                    <p class="text-muted">Customer can scan this QR code to complete the payment.</p>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="prev4">Previous</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
