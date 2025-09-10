<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Billing History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->load->view('CommonLinks'); ?>

    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

    <style>
        h2 {
            text-align: center;
            color: #a86d01ff;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            color: #a86d01ff;
        }

        .btn-gold {
            background: linear-gradient(90deg, #B37B16, #FFD27F);
            color: #000;
            font-weight: 600;
            border: none;
            transition: all .3s ease;
        }

        .btn-gold:hover {
            background: linear-gradient(90deg, #FFD27F, #B37B16);
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        }

        .btn-black {
            background: #111;
            color: #FFD27F;
            font-weight: 600;
            border: none;
            transition: all .3s ease;
        }

        .btn-black:hover {
            background: #FFD27F;
            color: #111;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        }

        .table th {
            color: #a86d01ff;
        }

        .btn-return {
            background: linear-gradient(90deg, #16B37B, #7FFFD2);
            /* Green gradient */
            color: #000;
            font-weight: 600;
            border: none;
            transition: all .3s ease;
        }

        .btn-return:hover {
            background: linear-gradient(90deg, #7FFFD2, #16B37B);
            box-shadow: 0 4px 8px rgba(0, 0, 0, .2);
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <?php $this->load->view('include/sidebar'); ?>
        <div class="main">
            <?php $this->load->view('include/navbar'); ?>

            <div class="container-fluid p-4">
                <h2 class="text-dark">Bill & Invoices</h2>

                <!-- Filter Form
                <form action="<?= base_url('AdminController/filter_billing_history') ?>" method="get" class="row mb-3">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">From Date:</label>
                        <input type="date" name="from" class="form-control" value="<?= $this->input->get('from') ?>">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">To Date:</label>
                        <input type="date" name="to" class="form-control" value="<?= $this->input->get('to') ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Generate Request</button>
                    </div>
                </form> -->


                <!-- Billing Table -->
                <div class="table-responsive">
                    <table class="table table-bordered bg-white shadow-sm align-middle">
                        <thead class="table-light">
                            <tr style="background:linear-gradient(90deg,#FFD27F,#B37B16);color:#a86d01ff;">
                                <th>Invoice </th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Mobile</th>
                                <th>Aadhar No</th>
                                <th>Total (₹)</th>
                                <th>Deposit (₹)</th>
                                <th>Paid (₹)</th>
                                <th>Due (₹)</th>
                                <th>Payment</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($invoices)): foreach ($invoices as $inv): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($inv['invoice_no']) ?></strong></td>
                                        <td><?= htmlspecialchars($inv['invoice_date']) ?></td>
                                        <td><?= htmlspecialchars($inv['customer_name']) ?></td>
                                        <td><?= htmlspecialchars($inv['customer_mobile'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($inv['aadhar_number'] ?? '-') ?></td>
                                        <td class="text-end">₹<?= number_format($inv['total_payable'], 2) ?></td>
                                        <!-- <td class="text-end">₹<?= number_format($inv['deposit_amount'], 2) ?></td> -->
                                        <td class="text-end deposit-<?= $inv['id'] ?>">
                                            ₹<?= number_format($inv['deposit_amount'], 2) ?>
                                        </td>

                                        <td class="text-end">₹<?= number_format($inv['paid_amount'], 2) ?></td>
                                        <td class="text-end">₹<?= number_format($inv['due_amount'], 2) ?></td>
                                        <td><?= htmlspecialchars($inv['payment_mode']) ?></td>

                                        <td class="d-flex flex-wrap gap-1">
                                            <!-- Print Button -->
                                            <button type="button"
                                                class="btn btn-gold btn-sm"
                                                onclick="goToConsent('<?= $inv['invoice_no'] ?>')">
                                                Print
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="javascript:void(0);"
                                                onclick="confirmDelete('<?= base_url('AdminController/delete_invoice/' . $inv['id']) ?>')"
                                                class="btn btn-gold btn-sm">
                                                Delete
                                            </a>

                                            <!-- Pay Due Button -->
                                            <?php if ($inv['due_amount'] > 0): ?>
                                                <button class="btn btn-warning btn-sm pay-due-btn"
                                                    data-id="<?= $inv['id'] ?>"
                                                    data-total="<?= $inv['total_payable'] ?>"
                                                    data-paid="<?= $inv['paid_amount'] ?>"
                                                    data-due="<?= $inv['due_amount'] ?>"
                                                    data-payment="<?= $inv['payment_mode'] ?>">
                                                    Pay Due
                                                </button>
                                            <?php endif; ?>

                                            <!-- Return Deposit Button -->
                                            <?php if ($inv['deposit_amount'] > 0): ?>
                                                <button class="btn btn-return btn-sm"
                                                    data-id="<?= $inv['id'] ?>"
                                                    data-deposit="<?= $inv['deposit_amount'] ?>">
                                                    Return Deposit
                                                </button>
                                            <?php endif; ?>



                                        </td>



                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="11">No records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>


                <!-- Pay Due Modal -->
                <div class="modal fade" id="payDueModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="payDueForm">
                                <div class="modal-header">
                                    <h5 class="modal-title">Pay Due Amount</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="invoice_id" id="invoiceId">

                                    <div class="mb-3">
                                        <label class="form-label">Total Amount (₹)</label>
                                        <input type="number" class="form-control" id="totalAmount" name="total_amount" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Paid Amount (₹)</label>
                                        <input type="number" class="form-control" name="paid_amount" id="paidAmount" min="0" step="0.01" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Due Amount (₹)</label>
                                        <input type="number" class="form-control" name="due_amount" id="dueAmount" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Payment Mode</label>
                                        <select class="form-select" name="payment_mode" id="paymentMode" required>
                                            <option value="" disabled selected>Select Payment Mode</option>
                                            <option value="Cash">Cash</option>

                                            <option value="Online">Online</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Open Pay Due Modal
                        document.querySelectorAll('.pay-due-btn').forEach(btn => {
                            btn.addEventListener('click', function() {
                                document.getElementById('invoiceId').value = this.dataset.id;
                                document.getElementById('totalAmount').value = this.dataset.total;
                                document.getElementById('paidAmount').value = this.dataset.paid;
                                document.getElementById('dueAmount').value = this.dataset.due;
                                document.getElementById('paymentMode').value = this.dataset.payment;

                                bootstrap.Modal.getOrCreateInstance(document.getElementById('payDueModal')).show();
                            });
                        });

                        // Auto-update due amount
                        document.getElementById('paidAmount').addEventListener('input', function() {
                            let total = parseFloat(document.getElementById('totalAmount').value) || 0;
                            let paid = parseFloat(this.value) || 0;
                            let due = total - paid;
                            document.getElementById('dueAmount').value = due >= 0 ? due.toFixed(2) : 0;
                        });

                        // Submit form via AJAX
                        document.getElementById('payDueForm').addEventListener('submit', e => {
                            e.preventDefault();
                            let formData = new FormData(e.target);

                            fetch("<?= base_url('AdminController/update_due_manual') ?>", {
                                    method: "POST",
                                    body: formData
                                })
                                .then(r => r.json())
                                .then(res => {
                                    if (res.success) {
                                        alert(res.message);
                                        location.reload();
                                    } else {
                                        alert(res.message);
                                    }
                                })
                                .catch(() => alert("Error updating payment"));
                        });
                    });
                </script>

                <!-- <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="<?= base_url('AdminController/export_pdf') ?>" class="btn btn-success">Export PDF</a>
                    <a href="<?= base_url('AdminController/export_excel') ?>" class="btn btn-warning">Export Excel</a>
                </div> -->
            </div>
        </div>
    </div>
    <script>
        function goToConsent(invoiceNo) {
            window.location.href = "<?= base_url('AdminController/consent_form/') ?>" + invoiceNo;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Open Pay Due Modal
            document.querySelectorAll('.pay-due-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('invoiceId').value = this.dataset.id;
                    document.getElementById('paidAmount').value = this.dataset.paid;
                    document.getElementById('dueAmount').value = this.dataset.due;
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('payDueModal')).show();
                });
            });

            // Submit Pay Due Form
            document.getElementById('payDueForm').addEventListener('submit', e => {
                e.preventDefault();
                let formData = new FormData(e.target);
                fetch("<?= base_url('index.php/AdminController/update_due_manual') ?>", {
                        method: "POST",
                        body: formData
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            alert(res.message);
                            location.reload();
                        } else {
                            alert(res.message);
                        }
                    })
                    .catch(() => alert("Error updating payment"));
            });
        });

        // update pay due payment
        $(document).on("click", ".pay-due-btn", function() {
            let id = $(this).data("invoice-id");
            let paid = $(this).data("paid");
            let due = $(this).data("due");

            $("#invoiceId").val(id);
            $("#dueAmount").val(due);

            $("#payDueModal").modal("show");
        });
        $(document).on("click", ".pay-due-btn", function() {
            let id = $(this).data("invoice-id");
            let paid = $(this).data("paid");
            let due = $(this).data("due");

            $("#invoiceId").val(id);
            $("#paidAmount").val(paid);
            $("#dueAmount").val(due);

            $("#payDueModal").modal("show");
        });
    </script>
    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url; // Redirect to delete
                }
            });
        }
    </script>
    <?php if ($this->session->flashdata('success')): ?>
        <script>
            Swal.fire({
                icon: "success",
                title: "<?= $this->session->flashdata('success'); ?>",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    <?php endif; ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-return').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id;
                    let button = this;

                    Swal.fire({
                        title: "Are you sure?",
                        text: "Are you sure you are returning the Deposit? This action cannot be undone.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#16B37B",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, return it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("<?= base_url('AdminController/return_deposit') ?>", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: "id=" + id
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        // update UI
                                        document.querySelector(".deposit-" + id).innerText = "₹0.00";
                                        button.style.display = "none";

                                        Swal.fire({
                                            icon: "success",
                                            title: "Deposit Returned!",
                                            text: "Deposit has been returned. ",
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                    } else {
                                        Swal.fire("Error!", "Failed to return deposit.", "error");
                                    }
                                })
                                .catch(() => {
                                    Swal.fire("Error!", "Something went wrong.", "error");
                                });
                        }
                    });
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>