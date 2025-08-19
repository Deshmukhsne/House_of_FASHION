<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Shop Consent Form - House of Fashion</title>
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
            }

            /* Force side-by-side signatures in print */
            .signature-block {
                display: flex;
                justify-content: space-between;
            }

            .signature-block>div {
                width: 48%;
            }
        }
    </style>
</head>

<body>

    <div class="form-container">
        <!-- Shop Name -->
        <div class="shop-header">
            <h2>HOUSE OF FASHION</h2>
            <p>Address: 123 Fashion Street, City, Country<br />
                Phone: (123) 456-7890 | Email: info@example.com</p>
        </div>

        <!-- Agreement Body -->
        <p>- I __________________________ hereby acknowledge that this Rental Agreement Form (hereinafter referred to as
            "<strong>Form</strong>") became effective on __________________________.</p>

        <p>- I hereby agree to rent the item(s) listed below from __________________________ ("Rental Shop") for the
            agreed duration and cost.</p>

        <p>- I acknowledge that I am responsible for the proper care, use, and return of the rented item(s) in the same
            condition as received, except for normal wear and tear.</p>

        <p>- I agree to be liable for any damage, loss, or late return of the rented item(s), and will compensate the
            Rental Shop for repair, replacement, or late fees as applicable.</p>

        <p>- I understand that the rental item(s) remain the sole property of the Rental Shop and that I have no
            ownership rights over them.</p>

        <p>- I agree to follow all usage instructions provided by the Rental Shop and use the rented item(s) only for
            lawful purposes.</p>

        <p>- I hereby release the Rental Shop from any claims, liabilities, or damages arising from the use of the
            rented item(s), except where caused by the Rental Shop’s negligence.</p>

        <hr>
        <!-- Item Details -->
        <p><strong>ITEM(S) RENTED:</strong> ___________________________________________</p>
        <p><strong>RENTAL DURATION:</strong> _________________________________________</p>
        <p><strong>TOTAL COST:</strong> ______________________________________________</p>
        <hr>

        <!-- Signature Section -->
        <div class="row signature-block">
            <div class="col-md-6">
                <p><strong>RENTAL SHOP</strong></p>
                <p>Name: <span class="signature-line"></span></p>
                <p>Signature: <span class="signature-line"></span></p>
                <p>Date: <span class="signature-line"></span></p>
            </div>
            <div class="col-md-6">
                <p><strong>CUSTOMER</strong></p>
                <p>Name: <span class="signature-line"></span></p>
                <p>Signature: <span class="signature-line"></span></p>
                <p>Date: <span class="signature-line"></span></p>
            </div>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-success px-4">Print Form</button>
        </div>
    </div>

</body>

</html>