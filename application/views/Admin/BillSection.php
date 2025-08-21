<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Billing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
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
            background: linear-gradient(90deg,var(--dark-gold),var(--light-gold));
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
            margin-bottom: .3rem;
        }
        .form-section-title {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            border-bottom: 3px solid var(--dark-gold);
            padding-bottom: .25rem;
        }
        .table thead {
            background-color: rgba(212,175,55,.2);
        }
        .table th {
            font-weight: 600;
            color: var(--secondary-color);
            vertical-align: middle;
        }
        .btn-gold {
            background: linear-gradient(90deg,var(--dark-gold),var(--light-gold));
            color: #000;
            font-weight: 600;
            border: none;
            transition: all .3s ease;
        }
        .btn-gold:hover {
            background: linear-gradient(90deg,var(--light-gold),var(--dark-gold));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }
        .total-display {
            background-color: rgba(212,175,55,.1);
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
        }
        .date-highlight {
            background-color: #fff8e1;
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
                <div class="bill-card">
                    <h4>RENTAL INVOICE</h4>
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
                    <form action="<?= base_url('AdminController/save_invoice') ?>" method="post" id="invoiceForm">
                        <!-- Invoice Info -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Invoice No:</label>
                                <input type="text" name="invoiceNo" id="invoiceNo" class="form-control" readonly value="<?= isset($temp_invoice_no) ? $temp_invoice_no : '' ?>" />
                            </div>
                            <div class="col-md-3">
                                <label>Customer Name:</label>
                                <input type="text" name="customerName" id="customerName" class="form-control" required />
                            </div>
                            <div class="col-md-3">
                                <label>Customer Mobile No:</label>
                                <input type="text" name="customerMobile" id="customerMobile" class="form-control" maxlength="15" required />
                            </div>
                            <div class="col-md-3">
                                <label>Deposit Amount (₹):</label>
                                <input type="number" name="depositAmount" id="depositAmount" class="form-control" min="0" step="0.01" value="0" oninput="updateBalance()" />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Rental Date</label>
                                <input type="date" name="date" id="date" class="form-control date-highlight" required />
                            </div>
                            <div class="col-md-3">
                                <label>Return Date</label>
                                <input type="date" name="returnDate" id="returnDate" class="form-control date-highlight" required />
                            </div>
                            <div class="col-md-3">
                                <label>Rental Days</label>
                                <input type="number" name="rentalDays" id="rentalDays" class="form-control" readonly />
                            </div>
                            <div class="col-md-3">
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
                        <div class="mb-4">
                            <label class="form-section-title">Rental Items</label>
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Category</th>
                                        <th>Item</th>
                                        <th>Daily Price (₹)</th>
                                        <th>Qty</th>
                                        <th>Days</th>
                                        <th>Total (₹)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemTable">
                                    <tr>
                                        <td>
                                            <select name="category[]" class="form-select category-select" onchange="onCategoryChange(this)">
                                                <option value="">Select</option>
                                                <?php foreach($categories as $c): ?>
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
                                            <input type="number" name="days[]" class="form-control days" min="1" value="1" oninput="updateRowTotal(this)" />
                                        </td>
                                        <td>
                                            <input type="number" name="total[]" class="form-control total" readonly />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button>
                                        </td>
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
<button class="btn btn-gold px-4 py-2" type="submit" onclick="goToConsent()">Save & Next </button>   
                         <button class="btn btn-outline-secondary px-4 py-2" type="reset" onclick="resetForm()">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function goToConsent() {
    const invoiceNo = document.getElementById('invoiceNo').value;
    window.location.href = "<?= base_url('AdminController/consent_form/') ?>" + invoiceNo;
}
</script>
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
                'status'=> $p['status']
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

// Update rental days when dates change
function updateRentalDays() {
    const startDate = document.getElementById('date').value;
    const endDate = document.getElementById('returnDate').value;
    const days = calculateDays(startDate, endDate);
    document.getElementById('rentalDays').value = days;
    
    // Update days for all rows
    document.querySelectorAll('.days').forEach(dayInput => {
        dayInput.value = days;
        updateRowTotal(dayInput);
    });
}

// Add new item row
function addRow() {
    const tbody = document.getElementById('itemTable');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <select name="category[]" class="form-select category-select" onchange="onCategoryChange(this)">
                <option value="">Select</option>
                <?php foreach($categories as $c): ?>
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
        <td><input type="number" name="days[]" class="form-control days" min="1" value="${document.getElementById('rentalDays').value || 1}" oninput="updateRowTotal(this)" /></td>
        <td><input type="number" name="total[]" class="form-control total" readonly /></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
    `;
    tbody.appendChild(tr);
}

// Remove item row
function removeRow(btn) {
    btn.closest('tr').remove();
    updateAllTotals();
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

// Reset form to initial state
function resetForm() {
    document.getElementById('invoiceForm').reset();
    const tbody = document.getElementById('itemTable');
    tbody.innerHTML = '';
    addRow();
    updateAllTotals();
}

// Initialize form
document.addEventListener('DOMContentLoaded', function() {
    // Set default dates
    const today = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);
    
    document.getElementById('date').valueAsDate = today;
    document.getElementById('returnDate').valueAsDate = tomorrow;
    updateRentalDays();
    
    // Add first row
    addRow();
});

// Date change listeners
document.getElementById('date').addEventListener('change', updateRentalDays);
document.getElementById('returnDate').addEventListener('change', updateRentalDays);

// Form submission
document.getElementById('invoiceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate at least one item is added
    const items = document.querySelectorAll('#itemTable tr');
    if (items.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'No Items',
            text: 'Please add at least one rental item',
            timer: 2000,
            showConfirmButton: false
        });
        return;
    }
    
    // Submit form via AJAX
    const formData = new FormData(this);
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Invoice Saved',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Reset form and keep the new invoice number
                document.getElementById('invoiceForm').reset();
                document.getElementById('invoiceNo').value = data.invoice_no;
                document.getElementById('itemTable').innerHTML = '';
                addRow();
                updateAllTotals();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to save invoice',
                timer: 2000,
                showConfirmButton: false
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Network Error',
            text: 'Failed to connect to server',
            timer: 2000,
            showConfirmButton: false
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Sidebar toggle functionality
    const toggler = document.querySelector(".toggler-btn");
    const closeBtn = document.querySelector(".close-sidebar");
    const sidebar = document.querySelector("#sidebar");
    if (toggler && sidebar) toggler.addEventListener("click", () => sidebar.classList.toggle("collapsed"));
    if (closeBtn && sidebar) closeBtn.addEventListener("click", () => sidebar.classList.remove("collapsed"));
</script>
</body>
</html>