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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        h2 {
            text-align: center;
            color: #a86d01ff;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(168, 109, 1, 0.2);
            border-color: #a86d01ff;
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
            transform: translateY(-2px);
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
            background: linear-gradient(90deg, #FFD27F, #B37B16);
        }

        .search-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .search-container i {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #a86d01ff;
        }

        .search-container input {
            padding-left: 35px;
        }

        .filter-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .highlight {
            background-color: rgba(255, 210, 127, 0.2) !important;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-style: italic;
        }

        .export-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .export-buttons {
                flex-direction: column;
            }

            .export-buttons a {
                width: 100%;
            }
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

                <!-- Search Box -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="search-container">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by invoice, customer, mobile...">
                        </div>
                    </div>

                </div>



                <!-- Billing Table -->
                <div class="table-responsive">
                    <table class="table table-bordered bg-white shadow-sm align-middle" id="billingTable">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Mobile</th>
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
                                        <td class="text-end">₹<?= number_format($inv['total_payable'], 2) ?></td>
                                        <td class="text-end">₹<?= number_format($inv['deposit_amount'], 2) ?></td>
                                        <td class="text-end">₹<?= number_format($inv['paid_amount'], 2) ?></td>
                                        <td class="text-end">₹<?= number_format($inv['due_amount'], 2) ?></td>
                                        <td><?= htmlspecialchars($inv['payment_mode']) ?></td>
                                        <td>
                                            <button class="btn btn-gold btn-sm view-invoice-btn" data-id="<?= $inv['id'] ?>">View</button>
                                            <a href="<?= base_url('AdminController/delete_invoice/' . $inv['id']) ?>"
                                                onclick="return confirm('Delete this invoice?')"
                                                class="btn btn-gold btn-sm">Delete</a>
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
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="10" class="no-results">No records found.</td>
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
                                            <option value="Cash">Cash</option>
                                            <option value="Card">Card</option>
                                            <option value="UPI">UPI</option>
                                            <option value="Bank">Bank</option>
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

                <!-- <div class="d-flex justify-content-end gap-2 mt-3 export-buttons">
                    <a href="<?= base_url('AdminController/export_pdf') ?>" class="btn btn-success">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                    <a href="<?= base_url('AdminController/export_excel') ?>" class="btn btn-warning">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                </div> -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('billingTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let found = false;

                    for (let j = 0; j < cells.length; j++) {
                        const cellText = cells[j].textContent.toLowerCase();
                        if (cellText.includes(searchText)) {
                            found = true;
                            break;
                        }
                    }

                    if (found) {
                        rows[i].style.display = '';
                        // Highlight matching text
                        if (searchText) {
                            rows[i].classList.add('highlight');
                        } else {
                            rows[i].classList.remove('highlight');
                        }
                    } else {
                        rows[i].style.display = 'none';
                        rows[i].classList.remove('highlight');
                    }
                }
            });

            // Clear filters button
            document.getElementById('clearFilters').addEventListener('click', function() {
                document.getElementById('fromDate').value = '';
                document.getElementById('toDate').value = '';
                document.getElementById('statusFilter').value = '';
                document.getElementById('searchInput').value = '';

                // Show all rows
                for (let i = 0; i < rows.length; i++) {
                    rows[i].style.display = '';
                    rows[i].classList.remove('highlight');
                }

                // Submit the form to reset URL parameters
                window.location.href = "<?= base_url('AdminController/billing_history') ?>";
            });

            // Date validation for filter form
            const filterForm = document.querySelector('form[action="<?= base_url('AdminController/filter_billing_history') ?>"]');
            filterForm.addEventListener('submit', function(e) {
                const fromDate = new Date(document.getElementById('fromDate').value);
                const toDate = new Date(document.getElementById('toDate').value);

                if (document.getElementById('fromDate').value && document.getElementById('toDate').value && fromDate > toDate) {
                    e.preventDefault();
                    alert('To date must be after From date');
                    return false;
                }
            });

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

            // Collapsible filter section icon toggle
            const filterCollapse = document.getElementById('filterCollapse');
            filterCollapse.addEventListener('show.bs.collapse', function() {
                document.querySelector('.filter-header i.fa-chevron-down').classList.replace('fa-chevron-down', 'fa-chevron-up');
            });

            filterCollapse.addEventListener('hide.bs.collapse', function() {
                document.querySelector('.filter-header i.fa-chevron-up').classList.replace('fa-chevron-up', 'fa-chevron-down');
            });
        });

        // Navbar toggler
        const toggler = document.querySelector(".toggler-btn");
        const closeBtn = document.querySelector(".close-sidebar");
        const sidebar = document.querySelector("#sidebar");

        if (toggler && sidebar) {
            toggler.addEventListener("click", function() {
                sidebar.classList.toggle("collapsed");
            });
        }

        if (closeBtn && sidebar) {
            closeBtn.addEventListener("click", function() {
                sidebar.classList.remove("collapsed");
            });
        }
    </script>
</body>

</html>