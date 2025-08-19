<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: #f8f9fa;
    }
    .invoice-container {
        width: 210mm;
        min-height: 297mm;
        margin: auto;
        background: #fff;
        padding: 20px 30px;
        box-sizing: border-box;
        border: 1px solid #ddd;
    }
    /* Header */
    .invoice-header {
        background: #fcbf2d;
        padding: 15px;
        color: #000;
        text-align: center;
    }
    .invoice-header h1 {
        margin: 5px 0;
        font-size: 26px;
        font-weight: bold;
    }
    .invoice-header p {
        margin: 2px 0;
        font-size: 14px;
    }
    .invoice-header h2 {
        margin-top: 10px;
        font-size: 22px;
    }
    /* Details section */
    .details, .items-table, .totals {
        margin-top: 20px;
    }
    .details .row {
        display: flex;
        flex-wrap: wrap;
    }
    .details .col {
        flex: 0 0 50%;
        padding: 4px 0;
        font-size: 14px;
    }
    .details strong {
        font-weight: bold;
    }
    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    table th, table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }
    table th {
        background: #f8f9fa;
    }
    /* Totals */
    .totals table td {
        text-align: right;
    }
    /* Signatures */
    .signatures {
        margin-top: 50px;
        display: flex;
        justify-content: space-between;
        font-size: 14px;
    }
    .signatures div {
        width: 45%;
        text-align: center;
    }
    .signatures .line {
        border-top: 1px solid #000;
        margin-top: 40px;
    }
    /* Footer */
    .invoice-footer {
        margin-top: 30px;
        text-align: center;
        font-size: 12px;
        color: #666;
    }
    /* Print styles */
    @media print {
        body {
            background: #fff;
        }
        .invoice-container {
            border: none;
            margin: 0;
            width: 100%;
            min-height: auto;
            padding: 0;
        }
        .no-print {
            display: none;
        }
        @page {
            size: A4;
            margin: 15mm;
        }
    }
</style>
</head>
<body>

<div class="invoice-container">
    <!-- Header -->
    <div class="invoice-header">
        <img src="<?php echo base_url('assets/images/invoice.png'); ?>"  style="max-height: 60px; margin-bottom: 5px;">
        <h1>SHOP NAME</h1>
        <p>123 Main Road, City, State - 123456</p>
        <p>Phone: +91-9876543210 | Email: shop@example.com</p>
        <h2>INVOICE</h2>
        <p>Date: 12 Aug 2025</p>
    </div>

    <!-- Invoice Details -->
    <div class="details">
        <div class="row">
            <div class="col"><strong>FASSI NO:</strong> 11550207001581</div>
            <div class="col"><strong>GST NO:</strong> 27ABJPL9876F1Z1</div>
            <div class="col"><strong>HSN/SAC Code:</strong> 996331</div>
            <div class="col"><strong>Bill No:</strong> BILL-20250710-102</div>
        </div>
    </div>

    <!-- Customer Details -->
    <div class="details">
        <h4>Invoice Details</h4>
        <div class="row">
            <div class="col"><strong>Customer Name:</strong> John Doe</div>
            <div class="col"><strong>Advance Amount:</strong> ₹2000</div>
            <div class="col"><strong>Date & Time:</strong> 12 Aug 2025, 10:00 AM</div>
            <div class="col"><strong>Return Date:</strong> 15 Aug 2025, 5:00 PM</div>
            <div class="col"><strong>CGST %:</strong> 1.5%</div>
            <div class="col"><strong>SGST %:</strong> 1.5%</div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="items-table">
        <h4>Items</h4>
        <table>
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Payment Mode</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PC101</td>
                    <td>Saree</td>
                    <td>₹1000</td>
                    <td>2</td>
                    <td>₹2000</td>
                    <td>₹0</td>
                    <td>Cash</td>
                </tr>
                <tr>
                    <td>PC102</td>
                    <td>Dress</td>
                    <td>₹1500</td>
                    <td>1</td>
                    <td>₹1500</td>
                    <td>₹0</td>
                    <td>Online</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>₹3500</td>
            </tr>
            <tr>
                <td><strong>CGST (1.5%):</strong></td>
                <td>₹52.50</td>
            </tr>
            <tr>
                <td><strong>SGST (1.5%):</strong></td>
                <td>₹52.50</td>
            </tr>
            <tr>
                <td><strong>Total Amount:</strong></td>
                <td><strong>₹3605</strong></td>
            </tr>
        </table>
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div>
            <p><strong>Customer Signature</strong></p>
            <div class="line"></div>
        </div>
        <div>
            <p><strong>Owner Signature</strong></p>
            <div class="line"></div>
        </div>
    </div>

    <!-- Footer -->
    <div class="invoice-footer">
        <p>Thank you for your business!</p>
       
    </div>
</div>

<!-- Buttons -->
<div class="no-print" style="text-align:center; margin-top: 20px;">
    <button onclick="window.print()" style="padding:10px 20px; background:#fcbf2d; border:none; cursor:pointer; font-weight:bold;">Print / Save to PDF</button>
</div>

</body>
</html>
