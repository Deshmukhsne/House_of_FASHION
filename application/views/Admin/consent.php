<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Consent Form - House of Fashion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add signature_pad library -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <!-- Add crypto-js for hashing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

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

        /* Improved Signature canvas styling */
        .signature-pad-container {
            margin: 15px 0;
            position: relative;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            padding: 10px;
        }

        #signatureCanvas {
            display: block;
            width: 100%;
            height: 200px;
            border-radius: 4px;
            cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'><circle cx='20' cy='20' r='18' fill='black' opacity='0.3'/></svg>") 20 20, crosshair;
            touch-action: none;
            background-color: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1) inset;
        }

        .signature-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .signature-status {
            margin-top: 10px;
            font-size: 14px;
            color: #dc3545;
        }

        .signature-valid {
            color: #28a745;
        }

        .signature-data {
            display: none;
        }

        /* Instructions for signing */
        .signature-instructions {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
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

            #signatureCanvas {
                height: 180px;
            }

            .signature-actions {
                flex-direction: column;
            }

            .signature-actions .btn {
                width: 100%;
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
            }

            .signature-block {
                display: flex;
                justify-content: space-between;
            }

            .signature-block>div {
                width: 48%;
            }


            /* Resize signature image for print */
            .signature-image {
                display: inline-block;
                max-width: 120px;
                height: auto;
                border-bottom: 1px dotted #000;
                margin-left: 10px;
            }

            .signature-pad-container {
                display: none;
            }

            /* Keep the canvas hidden during print */
            #signatureCanvas {
                display: none !important;
            }

            .signature-actions,
            .signature-status,
            .signature-instructions {
                display: none;
            }

            .action-buttons {
                display: none;
            }
        }

        /* For screen view, hide the printed signature image */
        @media screen {
            .signature-image {
                display: none;
            }
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


        <!-- <p>- I hereby release the Rental Shop from any claims, liabilities, or damages arising from the use of the
            rented item(s), except where caused by the Rental Shop's negligence.</p> -->

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
                <!-- Shop signature would go here in a real implementation -->
            </div>
            <div class="col-md-6">
                <p><strong>CUSTOMER</strong></p>
                <p><b>Name:</b> <?php echo htmlspecialchars($invoice['customer_name']); ?></p>
                <p class="d-flex align-items-start">
                <p class="d-flex align-items-center">
                    <b class="me-2">Signature:</b>
                    <!-- Signature Image for Print -->
                    <img id="signatureImage" class="signature-image" alt="Customer Signature">
                </p>

                <!-- Signature Pad (screen only) -->
                <!-- <div class="signature-instructions">
                    Sign in the box below using your mouse, finger, or stylus
                </div>
                <div class="signature-pad-container">
                    <canvas id="signatureCanvas"></canvas>
                    <div class="signature-actions">
                        <button id="clearSignature" class="btn btn-secondary">Clear Signature</button>

                    </div>
                    <div id="signatureStatus" class="signature-status">Please sign above</div>
                </div> -->
                <textarea id="signatureData" name="signature_data" class="signature-data"></textarea>
                <textarea id="documentHash" name="document_hash" class="signature-data"></textarea>


                <!-- This will display the signature in print view -->
                <!-- <img id="signatureImage" class="signature-image" alt="Customer Signature"> -->
            </div>
        </div>


    </div>
    </div>

    <!-- Invoice Section -->
    <div class="invoice-container">
        <!-- Invoice content remains the same as before -->
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

        <table class="invoice-table">
            <thead>
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

        <!-- Digital Signature Verification Section -->
        <div class="mt-4 signature-verification no-print">
            <h5>Digital Signature Verification</h5>
            <p>This document has been digitally signed using cryptographic techniques that:</p>
            <ul>
                <li>Verify the authenticity of this document</li>
                <li>Confirm the identity of the signer</li>
                <li>Ensure the content hasn't been altered after signing</li>
                <li>Provide non-repudiation (the signer cannot deny having signed)</li>
            </ul>
            <div class="verification-data">
                <p><strong>Document Hash:</strong> <span id="displayHash"></span></p>
                <p><strong>Signature Timestamp:</strong> <span id="signatureTimestamp"></span></p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-center mt-4 no-print action-buttons" style="max-width: 900px; margin: auto;">
        <button onclick="validateAndPrint()" class="btn btn-success px-4">Print Consent & Invoice</button>
        <!-- <button onclick="saveSignature()" class="btn btn-primary px-4">Save Signature</button> -->
        <a href="<?php echo site_url('AdminController/BillHistory'); ?>" class="btn btn-secondary px-4">Back to Invoices</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize signature pad with improved settings
        const canvas = document.getElementById('signatureCanvas');
        let signaturePad;

        // Track signature history for undo functionality
        let signatureHistory = [];

        function initSignaturePad() {
            // Clear any existing signature pad
            if (signaturePad) {
                signaturePad.off();
            }

            // Set canvas size properly
            const container = canvas.parentElement;
            canvas.width = container.offsetWidth;
            canvas.height = 200;

            // Adjust for high DPI displays
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

            // Initialize with better drawing settings
            signaturePad = new SignaturePad(canvas, {
                minWidth: 1,
                maxWidth: 4,
                throttle: 16, // Increase drawing precision
                velocityFilterWeight: 0.7,
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)'
            });

            // Clear history when initializing
            signatureHistory = [];

            // Add event listeners
            signaturePad.addEventListener("beginStroke", () => {
                // Save state before new stroke for undo functionality
                if (!signaturePad.isEmpty()) {
                    signatureHistory.push(signaturePad.toData());
                }
                updateSignatureStatus();
            });

            signaturePad.addEventListener("endStroke", updateSignatureStatus);
        }

        // Adjust canvas when window resizes
        window.addEventListener('resize', initSignaturePad);

        // Clear signature button
        document.getElementById('clearSignature').addEventListener('click', function() {
            // Save current state before clearing
            if (!signaturePad.isEmpty()) {
                signatureHistory.push(signaturePad.toData());
            }
            signaturePad.clear();
            updateSignatureStatus();
        });

        // Undo last stroke
        document.getElementById('undoSignature').addEventListener('click', function() {
            if (signatureHistory.length > 0) {
                signaturePad.fromData(signatureHistory.pop());
                updateSignatureStatus();
            }
        });

        // Update signature status
        function updateSignatureStatus() {
            const status = document.getElementById('signatureStatus');
            if (signaturePad.isEmpty()) {
                status.textContent = 'Please sign above';
                status.classList.remove('signature-valid');
            } else {
                status.textContent = 'Signature captured - You can undo or clear if needed';
                status.classList.add('signature-valid');
            }
        }

        // Generate a hash of the document content for verification
        function generateDocumentHash() {
            // Get the main content of the consent form
            const formContent = document.querySelector('.form-container').innerText;

            // Generate SHA-256 hash of the content
            const hash = CryptoJS.SHA256(formContent).toString();
            document.getElementById('documentHash').value = hash;
            document.getElementById('displayHash').textContent = hash.substring(0, 16) + '...';

            return hash;
        }

        // Save signature data
        function saveSignature() {
            if (signaturePad.isEmpty()) {
                Swal.fire({
                    icon: 'error',
                    title: 'No Signature',
                    text: 'Please provide a signature first.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Generate document hash
            generateDocumentHash();

            // Get signature data
            const signatureData = signaturePad.toDataURL();
            document.getElementById('signatureData').value = signatureData;
            document.getElementById('signatureImage').src = signatureData;

            // Add timestamp
            const now = new Date();
            document.getElementById('signatureTimestamp').textContent = now.toLocaleString();

            // Prepare data for AJAX request
            const data = {
                invoice_id: '<?php echo $invoice["id"]; ?>', // Make sure your invoice data includes an ID
                customer_name: '<?php echo $invoice["customer_name"]; ?>',
                signature_data: signatureData,
                document_hash: document.getElementById('documentHash').value,
                signature_timestamp: now.toISOString().slice(0, 19).replace('T', ' ')
            };

            // Send AJAX request to save signature
            fetch('<?php echo site_url("SignatureController/saveSignature"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Signature Saved',
                            text: 'Your digital signature has been saved successfully.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save signature: ' + result.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while saving the signature.',
                        confirmButtonText: 'OK'
                    });
                    console.error('Error:', error);
                });
        }

        // Validate signature before printing
        function validateAndPrint() {
            if (signaturePad.isEmpty()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Signature',
                    text: 'Please provide your signature before printing.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Save signature if not already saved
            if (!document.getElementById('signatureData').value) {
                saveSignature();
            }

            // Print the documents
            window.print();

            // Show success message after printing
            window.onafterprint = function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data Saved Successfully. Invoice & Form Printed.',
                    confirmButtonText: 'OK'
                });
            };
        }

        // Initialize when page loads
        window.onload = function() {
            initSignaturePad();
            generateDocumentHash();
        };
    </script>


</body>

</html>