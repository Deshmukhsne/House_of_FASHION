<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Consent Form - House of Fashion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            padding: 30px;
            font-size: 16px;
        }

        .form-container {
            background: #fff;
            border: 1px solid #000;
            padding: 40px;
            max-width: 900px;
            margin: auto;
            color: #000;
            line-height: 1.6;
        }

        .shop-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .shop-header h2 {
            margin: 0;
            font-weight: bold;
        }

        .form-title {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 1.5rem;
            margin-bottom: 25px;
        }

        .signature-block {
            margin-top: 40px;
        }

        .signature-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 200px;
            margin-top: 5px;
        }

        .filled-data {
            display: inline-block;
            min-width: 100px;
            border-bottom: 1px dotted #000;
            padding: 0 5px;
            font-weight: bold;
        }

        .invoice-container {
            background: #fff;
            border: 1px solid #000;
            padding: 40px;
            max-width: 900px;
            margin: 30px auto;
            color: #000;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f8f9fa;
        }

        .invoice-totals {
            width: 50%;
            margin-left: auto;
        }

        .text-right {
            text-align: right;
        }

        /* Mobile-specific improvements */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .form-container,
            .invoice-container {
                padding: 20px;
            }
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .no-print {
                display: none;
            }

            .form-container {
                border: none;
                padding: 0;
                box-shadow: none;
                page-break-after: always;
            }

            .invoice-container {
                page-break-before: always;
                border: none;
            }

            .signature-block {
                display: flex;
                justify-content: space-between;
            }

            .signature-block>div {
                width: 48%;
            }
        }

        .manual-signature-line {
            height: 1px;
            background-color: #000;
            width: 250px;
            margin-top: 40px;
            margin-bottom: 5px;
        }

        .signature-label {
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>

    <!-- Consent Form Section -->
    <div class="form-container">
        <!-- Shop Name -->
        <div class="shop-header">
            <h2>HOUSE OF FASHION</h2>
            <p>Address: 123 Fashion Street, City, Country<br />
                Phone: (123) 456-7890 | Email: info@example.com</p>
        </div>

        <!-- Agreement Body -->
        <p>- I <span class="filled-data"><?php echo htmlspecialchars($invoice['customer_name']); ?></span> hereby acknowledge that this Rental Agreement Form (hereinafter referred to as
            "<strong>Form</strong>") became effective on <span class="filled-data"><?php echo date('F j, Y', strtotime($invoice['invoice_date'])); ?></span>.</p>

        <p>- I hereby agree to rent the item(s) listed below from <span class="filled-data">House of Fashion</span> ("Rental Shop") for the
            agreed duration and cost.</p>

        <p>- I acknowledge that I am responsible for the proper care, use, and return of the rented item(s) in the same
            condition as received, except for normal wear and tear.</p>

        <p>- I agree to be liable for any damage, loss, or late return of the rented item(s), and will compensate the
            Rental Shop for repair, replacement, or late fees as applicable.</p>

        <p>- I understand that the rental item(s) remain the sole property of the Rental Shop and that I have no
            ownership rights over them.</p>

        <hr>
        <!-- Item Details -->
        <p><strong>ITEM(S) RENTED:</strong></p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Rental Date</th>
                        <th>Return date</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['rental_date']); ?></td>
                            <td><?php echo htmlspecialchars($item['return_date']); ?></td>
                            <td>Rs <?php echo number_format($item['price'], 2); ?></td>
                            <td>Rs <?php echo number_format($item['total'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p><strong>RENTAL DURATION:</strong> From <span class="filled-data"><?php echo date('F j, Y', strtotime($invoice['invoice_date'])); ?></span> to <span class="filled-data"><?php echo date('F j, Y', strtotime($invoice['return_date'])); ?></span></p>
        <p><strong>TOTAL COST:</strong> Rs <span class="filled-data"><?php echo number_format($invoice['total_amount'], 2); ?></span>
            (Deposit: Rs <span class="filled-data"><?php echo number_format($invoice['deposit_amount'], 2); ?></span>)</p>
        <hr>

        <!-- Signature Section -->
        <div class="row signature-block">
            <div class="col-md-6">
                <p><strong>RENTAL SHOP</strong></p>
                <p><b>Name :</b> Prajakta Gite</p>
                <p><b>Date: </b><?= date('d-m-Y'); ?></p>
                <!-- <div class="manual-signature-line"></div>
                <div class="signature-label">Authorized Signature</div> -->
            </div>
            <div class="col-md-6">
                <p><strong>CUSTOMER</strong></p>
                <p><b>Name:</b> <?php echo htmlspecialchars($invoice['customer_name']); ?></p>
                <p><b>Date: </b><?= date('d-m-Y'); ?></p>
                <div class="manual-signature-line"></div>
                <div class="signature-label">Customer Signature</div>
            </div>
        </div>
    </div>

    <!-- Invoice Section -->
    <div class="invoice-container">
        <div class="shop-header">
            <h2>HOUSE OF FASHION</h2>
            <p>Address: 123 Fashion Street, City, Country<br />
                Phone: (123) 456-7890 | Email: info@example.com</p>
            <h3>INVOICE</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Invoice No:</strong> <?php echo $invoice['invoice_no']; ?></p>
                <p><strong>Invoice Date:</strong> <?php echo date('F j, Y', strtotime($invoice['invoice_date'])); ?></p>
                <p><strong>Staff Name: </strong> <?php echo htmlspecialchars($invoice['staff_name']); ?></p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($invoice['customer_name']); ?></p>
                <p><strong>Customer Mobile:</strong> <?php echo htmlspecialchars($invoice['customer_mobile']); ?></p>
                <p><strong>Payment Mode:</strong> <?php echo htmlspecialchars($invoice['payment_mode']); ?></p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table invoice-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Rental Date</th>
                        <th>Return Date</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['rental_date']); ?></td>
                            <td><?php echo htmlspecialchars($item['return_date']); ?></td>
                            <td>Rs <?php echo number_format($item['price'], 2); ?></td>
                            <td>Rs <?php echo number_format($item['total'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <div class="invoice-totals">
            <table class="table">
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td class="text-right">Rs <?php echo number_format($invoice['total_amount'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Discount:</strong></td>
                    <td class="text-right">Rs <?php echo number_format($invoice['discount_amount'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Deposit:</strong></td>
                    <td class="text-right">Rs <?php echo number_format($invoice['deposit_amount'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Total Payable:</strong></td>
                    <td class="text-right">Rs <?php echo number_format($invoice['total_payable'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Paid Amount:</strong></td>
                    <td class="text-right">Rs <?php echo number_format($invoice['paid_amount'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Due Amount:</strong></td>
                    <td class="text-right">Rs <?php echo number_format($invoice['due_amount'], 2); ?></td>
                </tr>
            </table>
        </div>

        <div class="mt-4 text-center">
            <p>Thank you for your business!</p>
            <p>Terms: All rentals are subject to our terms and conditions. Late returns will incur additional charges.</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-center mt-4 no-print action-buttons" style="max-width: 900px; margin: auto;">
        <button onclick="window.print()" class="btn btn-success px-4">Print Consent & Invoice</button>
        <a href="<?php echo site_url('AdminController/BillHistory'); ?>" class="btn btn-secondary px-4">Back to Invoices</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>