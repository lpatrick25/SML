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
