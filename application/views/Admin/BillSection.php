<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bill Section</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <style>
        :root {
            --primary-color: #D4AF37;
            --secondary-color: #a86d01;
            --light-gold: #FFD27F;
            --dark-gold: #B37B16;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .bill-card {
            position: relative;
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            background: #fff;
            padding: 2rem 3rem;
        }

        .bill-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--dark-gold), var(--light-gold));
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        h4 {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: var(--secondary-color);
            display: block;
            margin-bottom: .5rem;
        }

        .form-section-title {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            border-bottom: 3px solid var(--dark-gold);
            padding-bottom: .25rem;
        }

        .table thead {
            background-color: rgba(212, 175, 55, .2);
        }

        .table th {
            font-weight: 600;
            color: var(--secondary-color);
            vertical-align: middle;
        }

        .btn-gold {
            background: linear-gradient(90deg, var(--dark-gold), var(--light-gold));
            color: #000;
            font-weight: 600;
            border: none;
            transition: all .3s ease;
        }

        .btn-gold:hover {
            background: linear-gradient(90deg, var(--light-gold), var(--dark-gold));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        }

        .total-display {
            background-color: rgba(212, 175, 55, .1);
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
        }

        .date-highlight {
            background-color: #fff8e1;
        }
    </style>

    <style>
        /* Responsive table container */
        .table-responsive-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Small devices (phones, 576px and down) */
        @media (max-width: 576px) {
            .table {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 0.5rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.7rem;
            }
        }

        /* Extra small devices (phones, 400px and down) */
        @media (max-width: 400px) {
            .table {
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.3rem;
            }

            .form-select,
            .form-control {
                padding: 0.25rem;
                font-size: 0.75rem;
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
                <div class="container my-5">
                    <h4>RENTAL INVOICE</h4>
                    <div class="bill-card">

                        <?php if ($this->session->flashdata('error')): ?>
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: '<?= $this->session->flashdata('error'); ?>'
                                });
                            </script>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('success')): ?>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Invoice Created!',
                                    text: '<?= $this->session->flashdata('success'); ?>',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            </script>
                        <?php endif; ?>

                        <form action="<?= base_url('AdminController/save_invoice') ?>" method="post" id="invoiceForm">
                            <!-- Invoice Info -->
                            <div class="row mb-4 ">
                                <div class="col-md-3 ">
                                    <label>Invoice No:</label>
                                    <input type="text" name="invoiceNo" id="invoiceNo" class="form-control" readonly value="<?= isset($temp_invoice_no) ? $temp_invoice_no : '' ?>" />
                                </div>
                                <div class="col-md-3">
                                    <label>Customer Name:</label>
                                    <input type="text" name="customerName" id="customerName" class="form-control" placeholder="Enter Name" required />
                                </div>
                                <div class="col-md-3">
                                    <label>Customer Mobile No:</label>
                                    <input type="text" name="customerMobile" id="customerMobile" class="form-control" maxlength="10" placeholder="Enter Mobile" required />
                                </div>
                                <div class="col-md-3">
                                    <label>Alternate Mobile No:</label>
                                    <input type="text" name="alternateMobile" id="alternateMobile" class="form-control" placeholder="Enter Alternate Mobile" maxlength="10" required />
                                </div>

                                <div class="row mb-4 my-4">
                                    <div class="col-md-3">
                                        <label>Rental Date</label>
                                        <input type="date" id="commonRentalDate" class="form-control date-highlight" value="<?= date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Return Date</label>
                                        <input type="date" id="commonReturnDate" class="form-control date-highlight" value="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Rental Days</label>
                                        <input type="number" name="rentalDays" id="rentalDays" class="form-control" readonly />
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <div class="form-check mt-3">
                                            <input type="checkbox" id="applyCommonDates" class="form-check-input" />
                                            <label class="form-check-label" for="applyCommonDates">Apply to all rows</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label>Aadhaar Number:</label>
                                        <input
                                            type="text"
                                            name="aadhar_number"
                                            id="aadharno"
                                            class="form-control"
                                            placeholder="Enter Aadhaar Number"
                                            maxlength="12"
                                            inputmode="numeric"
                                            pattern="\d{12}"
                                            autocomplete="off"
                                            required />
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label for="staff_id">Select Staff</label>
                                        <select name="staff_name" id="staff_id" class="form-control" required>
                                            <option value="">Select Staff</option>
                                            <?php if (!empty($staffList)) : ?>
                                                <?php foreach ($staffList as $staff) : ?>
                                                    <option value="<?= $staff->name ?>">
                                                        <?= $staff->name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="">No staff found</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>


                                    <div class="col-md-3 mt-3">
                                        <label>Deposit Amount (₹):</label>
                                        <input type="number" name="depositAmount" id="depositAmount" class="form-control" min="0" step="1" value="0" oninput="updateBalance()" />
                                    </div>

                                    <div class="col-md-3  mt-3">
                                        <label>Payment Mode:</label>
                                        <select name="paymentMode" id="paymentMode" class="form-select">
                                            <option value="">Select</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Online">Online</option>
                                            <option value="Unpaid">Unpaid</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Items Table -->
                                <div class="table-responsive-container">
                                    <table class="table table-bordered table-striped table-hover align-middle">
                                        <!-- <div class="table-responsive-container"> -->
                                        <!-- <table class="table table-bordered align-middle"> -->
                                        <thead class="table-light">
                                            <tr>
                                                <th>Category</th>
                                                <th>Item</th>
                                                <th>Daily Rent (₹)</th>
                                                <th>Qty</th>
                                                <th>Rental Date</th>
                                                <th>Return Date</th>
                                                <th>Days</th>
                                                <th>Total (₹)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemTable">
                                            <!-- Single initial row -->
                                            <tr>
                                                <td>
                                                    <select name="category[]" class="form-select category-select" onchange="onCategoryChange(this)">
                                                        <option value="">Select</option>
                                                        <?php foreach ($categories as $c): ?>
                                                            <option value="<?= $c['id']; ?>"><?= htmlspecialchars($c['name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="itemName[]" class="form-select product-select" onchange="onProductChange(this)">
                                                        <option value="">Select Item</option>
                                                    </select>
                                                </td>
                                                <td><input type="number" name="price[]" class="form-control price" readonly /></td>
                                                <td><input type="number" name="qty[]" class="form-control qty" min="1" value="1" oninput="updateRowTotal(this)" /></td>
                                                <td><input type="date" name="rentalDate[]" class="form-control rental-date" onchange="updateRowDays(this)" value="<?= date('Y-m-d') ?>" /></td>
                                                <td><input type="date" name="returnDate[]" class="form-control return-date" onchange="updateRowDays(this)" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" /></td>
                                                <td><input type="number" name="days[]" class="form-control days" min="1" value="1" oninput="updateRowTotal(this)" /></td>
                                                <td><input type="number" name="total[]" class="form-control total" readonly /></td>
                                                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-sm btn-gold" type="button" onclick="addRow()">+ Add Item</button>
                                </div>

                                <!-- Summary -->
                                <div class="row summary-section">
                                    <div class="col-md-6 offset-md-6">
                                        <div class="mb-2 d-flex justify-content-between">
                                            <span>Total Amount:</span>
                                            <span class="value" id="totalAmount">₹0.00</span>
                                        </div>
                                        <div class="mb-3">
                                            <label>Discount (₹):</label>
                                            <input type="number" name="discountAmount" id="discountAmount" min="0" step="0.01" class="form-control" value="0" oninput="updateAllTotals()" />
                                        </div>
                                        <div class="mb-2 d-flex justify-content-between">
                                            <span>Total Payable:</span>
                                            <span class="value" id="totalPayable">₹0.00</span>
                                        </div>
                                        <div class="mb-3">
                                            <label>Paid Amount (₹):</label>
                                            <input type="number" name="paidAmount" id="paidAmount" class="form-control" min="0" step="0.01" value="0" oninput="updateBalance()" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Due Amount (₹):</label>
                                            <input type="number" name="dueAmount" id="dueAmount" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden totals -->
                                <input type="hidden" name="totalAmount" id="totalAmountInput">
                                <input type="hidden" name="totalPayable" id="totalPayableInput">

                                <div class="text-center mt-4">
                                    <button class="btn btn-gold px-4 py-2 me-md-2" type="submit">Save Invoice</button>
                                    <button class="btn btn-secondary px-4 py-2" type="button" onclick="resetForm()">Clear</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Product data from PHP
        const PRODUCTS = <?php
                            $grouped = [];
                            if (!empty($products)) {
                                foreach ($products as $p) {
                                    $cid = (int)$p['category_id'];
                                    if (!isset($grouped[$cid])) $grouped[$cid] = [];
                                    $grouped[$cid][] = [
                                        'id'    => (int)$p['id'],
                                        'name'  => $p['name'],
                                        'price' => (float)$p['price'],
                                        'status' => $p['status']
                                    ];
                                }
                            }
                            echo json_encode($grouped);
                            ?>;

        // Calculate days between two dates
        function calculateDays(startDate, endDate) {
            if (!startDate || !endDate) return 1;
            const oneDay = 24 * 60 * 60 * 1000;
            const diffDays = Math.round(Math.abs((new Date(endDate) - new Date(startDate)) / oneDay));
            return diffDays > 0 ? diffDays : 1;
        }

        // Update rental days for a specific row
        function updateRowDays(element) {
            const tr = element.closest('tr');
            const rentalDate = tr.querySelector('.rental-date').value;
            const returnDate = tr.querySelector('.return-date').value;
            const daysInput = tr.querySelector('.days');

            const days = calculateDays(rentalDate, returnDate);
            daysInput.value = days;

            // Update the row total
            updateRowTotal(daysInput);
        }

        // Function to apply common dates to all rows
        function applyDatesToAllRows() {
            const applyCommon = document.getElementById('applyCommonDates').checked;
            if (!applyCommon) return;

            const rentalDate = document.getElementById('commonRentalDate').value;
            const returnDate = document.getElementById('commonReturnDate').value;

            document.querySelectorAll('#itemTable tr').forEach(row => {
                const rentalInput = row.querySelector('.rental-date');
                const returnInput = row.querySelector('.return-date');
                const daysInput = row.querySelector('.days');

                if (rentalInput && returnInput) {
                    rentalInput.value = rentalDate;
                    returnInput.value = returnDate;

                    if (rentalDate && returnDate) {
                        const diff = calculateDays(rentalDate, returnDate);
                        daysInput.value = diff;
                        updateRowTotal(daysInput);
                    }
                }
            });

            // Update the overall rental days display
            document.getElementById('rentalDays').value = calculateDays(rentalDate, returnDate);
        }

        // Add new item row
        function addRow() {
            const tbody = document.getElementById('itemTable');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <select name="category[]" class="form-select category-select" onchange="onCategoryChange(this)">
                        <option value="">Select</option>
                        <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id']; ?>"><?= htmlspecialchars($c['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="itemName[]" class="form-select product-select" onchange="onProductChange(this)">
                        <option value="">Select Item</option>
                    </select>
                </td>
                <td><input type="number" name="price[]" class="form-control price" readonly /></td>
                <td><input type="number" name="qty[]" class="form-control qty" min="1" value="1" oninput="updateRowTotal(this)" /></td>
                <td><input type="date" name="rentalDate[]" class="form-control rental-date" onchange="updateRowDays(this)" /></td>
                <td><input type="date" name="returnDate[]" class="form-control return-date" onchange="updateRowDays(this)" /></td>
                <td><input type="number" name="days[]" class="form-control days" min="1" value="1" oninput="updateRowTotal(this)" /></td>
                <td><input type="number" name="total[]" class="form-control total" readonly /></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
            `;
            tbody.appendChild(newRow);

            // Apply common dates if the checkbox is checked
            applyDatesToAllRows();

            // Enable remove buttons for all rows except the first one
            updateRemoveButtons();
        }

        // Remove item row
        function removeRow(btn) {
            const tbody = document.getElementById('itemTable');
            if (tbody.children.length > 1) {
                btn.closest('tr').remove();
                updateAllTotals();
                updateRemoveButtons();
            }
        }

        // Update the state of remove buttons (disable for first row)
        function updateRemoveButtons() {
            const tbody = document.getElementById('itemTable');
            const rows = tbody.children;

            for (let i = 0; i < rows.length; i++) {
                const removeBtn = rows[i].querySelector('.btn-danger');
                if (removeBtn) {
                    if (i === 0 && rows.length > 1) {
                        removeBtn.disabled = false;
                    } else if (i === 0 && rows.length === 1) {
                        removeBtn.disabled = true;
                    } else {
                        removeBtn.disabled = false;
                    }
                }
            }
        }

        // Handle category selection change
        function onCategoryChange(sel) {
            const tr = sel.closest('tr');
            const prodSelect = tr.querySelector('.product-select');
            const priceInput = tr.querySelector('.price');
            const totalInput = tr.querySelector('.total');
            prodSelect.innerHTML = `<option value="">Select Item</option>`;
            const cid = parseInt(sel.value || 0);
            priceInput.value = '';
            totalInput.value = '';

            if (cid && PRODUCTS[cid]) {
                PRODUCTS[cid].forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = p.name;
                    opt.dataset.price = p.price;
                    opt.dataset.status = p.status;
                    prodSelect.appendChild(opt);
                });
            }
        }

        // Handle product selection change
        function onProductChange(sel) {
            const tr = sel.closest('tr');
            const priceInput = tr.querySelector('.price');
            const status = sel.selectedOptions[0]?.dataset.status;
            const price = parseFloat(sel.selectedOptions[0]?.dataset.price || 0);

            if (status !== 'Available') {
                alert('This item is not available for rent!');
                sel.value = '';
                priceInput.value = '';
                return;
            }

            priceInput.value = price ? price.toFixed(2) : '';
            updateRowTotal(priceInput);
        }

        // Update row total calculation
        function updateRowTotal(element) {
            const tr = element.closest('tr');
            const price = parseFloat(tr.querySelector('.price').value) || 0;
            const qty = parseFloat(tr.querySelector('.qty').value) || 0;
            const days = parseFloat(tr.querySelector('.days').value) || 1;
            tr.querySelector('.total').value = (price * qty * days).toFixed(2);
            updateAllTotals();
        }

        // Update all totals and balances
        function updateAllTotals() {
            let totalAmount = 0;
            document.querySelectorAll('.total').forEach(input => {
                totalAmount += parseFloat(input.value) || 0;
            });

            document.getElementById('totalAmount').textContent = `₹${totalAmount.toFixed(2)}`;
            document.getElementById('totalAmountInput').value = totalAmount.toFixed(2);

            const discount = parseFloat(document.getElementById('discountAmount').value) || 0;
            const validDiscount = discount > totalAmount ? totalAmount : discount;
            if (discount !== validDiscount) {
                document.getElementById('discountAmount').value = validDiscount.toFixed(2);
            }

            const totalPayable = totalAmount - validDiscount;
            document.getElementById('totalPayable').textContent = `₹${totalPayable.toFixed(2)}`;
            document.getElementById('totalPayableInput').value = totalPayable.toFixed(2);

            updateBalance();
        }

        // Update payment balance
        function updateBalance() {
            const totalPayable = parseFloat(document.getElementById('totalPayableInput').value) || 0;
            let paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;

            // Cap paid amount at total payable
            if (paidAmount > totalPayable) {
                paidAmount = totalPayable;
                document.getElementById('paidAmount').value = paidAmount.toFixed(2);
                Swal.fire({
                    icon: 'warning',
                    title: 'Adjustment made',
                    text: 'Paid amount cannot exceed total payable',
                    timer: 1500,
                    showConfirmButton: false
                });
            }

            const dueAmount = totalPayable - paidAmount;
            document.getElementById('dueAmount').value = dueAmount > 0 ? dueAmount.toFixed(2) : '0.00';
        }
        document.getElementById('aadharno').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 12);
        });

        // Reset form to initial state
        function resetForm() {
            if (confirm('Are you sure you want to clear the form? All data will be lost.')) {
                document.getElementById('invoiceForm').reset();
                const tbody = document.getElementById('itemTable');
                tbody.innerHTML = `
                    <tr>
                        <td>
                            <select name="category[]" class="form-select category-select" onchange="onCategoryChange(this)">
                                <option value="">Select</option>
                                <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id']; ?>"><?= htmlspecialchars($c['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="itemName[]" class="form-select product-select" onchange="onProductChange(this)">
                                <option value="">Select Item</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="price[]" class="form-control price" readonly />
                        </td>
                        <td>
                            <input type="number" name="qty[]" class="form-control qty" min="1" value="1" oninput="updateRowTotal(this)" />
                        </td>
                        <td>
                            <input type="date" name="rentalDate[]" class="form-control rental-date" onchange="updateRowDays(this)" value="<?= date('Y-m-d') ?>" />
                        </td>
                        <td>
                            <input type="date" name="returnDate[]" class="form-control return-date" onchange="updateRowDays(this)" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" />
                        </td>
                        <td>
                            <input type="number" name="days[]" class="form-control days" min="1" value="1" oninput="updateRowTotal(this)" />
                        </td>
                        <td>
                            <input type="number" name="total[]" class="form-control total" readonly />
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)" disabled>Remove</button>
                        </td>
                    </tr>
                `;

                // Reset common dates
                document.getElementById('commonRentalDate').value = '<?= date('Y-m-d') ?>';
                document.getElementById('commonReturnDate').value = '<?= date('Y-m-d', strtotime('+1 day')) ?>';
                document.getElementById('rentalDays').value = calculateDays(
                    document.getElementById('commonRentalDate').value,
                    document.getElementById('commonReturnDate').value
                );

                updateAllTotals();
                updateRemoveButtons();
            }
        }

        // Initialize form
        document.addEventListener('DOMContentLoaded', function() {
            // Set up event listeners for common dates
            document.getElementById('commonRentalDate').addEventListener('change', function() {
                const rentalDate = this.value;
                const returnDate = document.getElementById('commonReturnDate').value;
                document.getElementById('rentalDays').value = calculateDays(rentalDate, returnDate);
                applyDatesToAllRows();
            });

            document.getElementById('commonReturnDate').addEventListener('change', function() {
                const rentalDate = document.getElementById('commonRentalDate').value;
                const returnDate = this.value;
                document.getElementById('rentalDays').value = calculateDays(rentalDate, returnDate);
                applyDatesToAllRows();
            });

            document.getElementById('applyCommonDates').addEventListener('change', applyDatesToAllRows);

            // Set initial rental days
            const rentalDate = document.getElementById('commonRentalDate').value;
            const returnDate = document.getElementById('commonReturnDate').value;
            document.getElementById('rentalDays').value = calculateDays(rentalDate, returnDate);

            // Initialize remove buttons state
            updateRemoveButtons();

            // Apply dates to all rows if checkbox is checked
            applyDatesToAllRows();
        });

        // Form submission
        document.getElementById('invoiceForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate at least one item is added
            const items = document.querySelectorAll('#itemTable tr');
            let hasValidItems = false;

            items.forEach(tr => {
                const productSelect = tr.querySelector('.product-select');
                if (productSelect && productSelect.value) {
                    hasValidItems = true;
                }
            });

            if (!hasValidItems) {
                Swal.fire({
                    icon: 'error',
                    title: 'No Items',
                    text: 'Please add at least one rental item',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            // Collect all items data
            const itemsData = [];
            document.querySelectorAll('#itemTable tr').forEach(tr => {
                const categorySelect = tr.querySelector('.category-select');
                const productSelect = tr.querySelector('.product-select');
                const priceInput = tr.querySelector('.price');
                const qtyInput = tr.querySelector('.qty');
                const rentalDateInput = tr.querySelector('.rental-date');
                const returnDateInput = tr.querySelector('.return-date');
                const daysInput = tr.querySelector('.days');
                const totalInput = tr.querySelector('.total');

                const category = categorySelect.value;
                const itemId = productSelect.value;
                const itemName = productSelect.options[productSelect.selectedIndex]?.text || '';
                const price = priceInput.value;
                const qty = qtyInput.value;
                const rentalDate = rentalDateInput.value;
                const returnDate = returnDateInput.value;
                const days = daysInput.value;
                const total = totalInput.value;

                if (itemId && itemName) {
                    itemsData.push({
                        category: category,
                        item_id: itemId,
                        item_name: itemName,
                        price: price,
                        quantity: qty,
                        rental_date: rentalDate,
                        return_date: returnDate,
                        days: days,
                        total: total
                    });
                }
            });

            // Create a hidden input for items data
            const itemsInput = document.createElement('input');
            itemsInput.type = 'hidden';
            itemsInput.name = 'items';
            itemsInput.value = JSON.stringify(itemsData);

            // Append to form
            this.appendChild(itemsInput);

            // Submit form normally
            this.submit();
        });
    </script>

    <script>
        // Sidebar toggle functionality
        const toggler = document.querySelector(".toggler-btn");
        const closeBtn = document.querySelector(".close-sidebar");
        const sidebar = document.querySelector("#sidebar");
        if (toggler && sidebar) toggler.addEventListener("click", () => sidebar.classList.toggle("collapsed"));
        if (closeBtn && sidebar) closeBtn.addEventListener("click", () => sidebar.classList.remove("collapsed"));
    </script>

    <script>
        // Allow only letters and spaces in Customer Name
        document.getElementById("customerName").addEventListener("input", function() {
            this.value = this.value.replace(/[^A-Za-z\s]/g, "");
        });

        // Allow only digits in Customer Mobile No
        document.getElementById("customerMobile").addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
        });

        // Allow only digits in Alternate Mobile No
        document.getElementById("alternateMobile").addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    </script>





</body>

</html>