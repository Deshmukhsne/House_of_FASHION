 <!DOCTYPE html>
 <html>

 <head>
     <title>Invoice ${invoiceNo}</title>
     <style>
         body {
             font-family: Arial, sans-serif;
             margin: 0;
             padding: 20px;
             color: #333;
         }

         .invoice-header {
             text-align: center;
             margin-bottom: 20px;
         }

         .invoice-header img {
             max-height: 80px;
             margin-bottom: 10px;
         }

         .invoice-title {
             font-size: 24px;
             font-weight: bold;
             margin: 10px 0;
         }

         .invoice-info {
             margin-bottom: 20px;
         }

         .invoice-info table {
             width: 100%;
             border-collapse: collapse;
         }

         .invoice-info td {
             padding: 5px;
         }

         .invoice-table {
             width: 100%;
             border-collapse: collapse;
             margin: 20px 0;
         }

         .invoice-table th,
         .invoice-table td {
             border: 1px solid #ddd;
             padding: 8px;
             text-align: left;
         }

         .invoice-table th {
             background-color: #f2f2f2;
         }

         .invoice-totals {
             float: right;
             width: 300px;
             margin-top: 20px;
         }

         .invoice-totals table {
             width: 100%;
             border-collapse: collapse;
         }

         .invoice-totals td {
             padding: 8px;
             border-bottom: 1px solid #ddd;
         }

         .invoice-totals tr:last-child td {
             border-bottom: none;
             font-weight: bold;
         }

         .invoice-footer {
             margin-top: 50px;
             font-size: 12px;
             text-align: center;
         }

         @page {
             size: auto;
             margin: 5mm;
         }
     </style>
 </head>

 <body>
     <div class="invoice-header">
         <div class="invoice-title">HOUSE OF FASHION</div>
         <div>123 Fashion Street, Mumbai - 400001</div>
         <div>GSTIN: 27ABJPL9876F1Z1 | FASSI NO: 11550207001581</div>
     </div>

     <div class="invoice-info">
         <table>
             <tr>
                 <td><strong>Invoice No:</strong> ${invoiceNo}</td>
                 <td><strong>Date:</strong> ${formatDate(dateTime)}</td>
             </tr>
             <tr>
                 <td><strong>Customer:</strong> ${customerName}</td>
                 <td><strong>Return Date:</strong> ${formatDate(returnDate)}</td>
             </tr>
         </table>
     </div>

     <table class="invoice-table">
         <thead>
             <tr>
                 <th>#</th>
                 <th>Item</th>
                 <th>Category</th>
                 <th>Price</th>
                 <th>Days</th>
                 <th>Discount</th>
                 <th>Total</th>
             </tr>
         </thead>
         <tbody>
             ${itemsHTML}
         </tbody>
     </table>

     <div class="invoice-totals">
         <table>
             <tr>
                 <td>Subtotal:</td>
                 <td>${subtotal}</td>
             </tr>
             <tr>
                 <td>CGST:</td>
                 <td>${cgst}</td>
             </tr>
             <tr>
                 <td>SGST:</td>
                 <td>${sgst}</td>
             </tr>
             <tr>
                 <td>Advance Paid:</td>
                 <td>₹${parseFloat(advance).toFixed(2)}</td>
             </tr>
             <tr>
                 <td>Total Amount:</td>
                 <td>${total}</td>
             </tr>
             <tr>
                 <td>Balance Due:</td>
                 <td>${balance}</td>
             </tr>
         </table>
     </div>

     <div class="invoice-footer">
         <p><strong>Terms & Conditions:</strong></p>
         <p>1. All items must be returned in original condition.</p>
         <p>2. Late returns will be charged 1.5x the daily rate.</p>
         <p>3. Damage to items will incur repair/replacement costs.</p>
         <p>4. Advance payment is non-refundable for cancellations.</p>
         <p>Thank you for your business!</p>
     </div>

     <script>
         window.onload = function() {
             window.print();
             setTimeout(function() {
                 window.close();
             }, 1000);
         };
     </script>
 </body>

 </html>