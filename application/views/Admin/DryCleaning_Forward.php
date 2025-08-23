<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forward Dry Cleaning</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->load->view('CommonLinks'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5 0%, #ffffff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h2.section-heading {
            background: linear-gradient(90deg, #000, #444);
            color: #FFD700;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            font-size: 1.8rem;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .form-container {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-2px);
        }

        label.form-label {
            font-weight: 500;
            color: #333;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px;
        }

        .btn-submit {
            background: linear-gradient(90deg, #28a745, #218838);
            color: white;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: linear-gradient(90deg, #218838, #1e7e34);
            transform: scale(1.03);
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <?php $this->load->view('include/sidebar'); ?>
        <div class="main">
            <?php $this->load->view('include/navbar'); ?>

            <div class="container-fluid p-4">
                <div class="container form-container">
                    <h2 class="section-heading mb-4">Forward Dry Cleaning Record</h2>

                    <?php if ($this->session->flashdata('success')): ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: "<?= $this->session->flashdata('success'); ?>"
                            });
                        </script>
                    <?php elseif ($this->session->flashdata('error')): ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: "<?= $this->session->flashdata('error'); ?>"
                            });
                        </script>
                    <?php endif; ?>

                    <form action="<?= base_url('AdminController/save_drycleaning') ?>" method="post" id="drycleaningForm">
                        <div class="row mb-3">
                            <!-- Vendor Name Dropdown -->
                            <div class="col-md-6">
                                <label class="form-label">Vendor Name</label>
                                <select name="vendor_id" id="vendorSelect" class="form-control" required>
                                    <option value="">Select Vendor</option>
                                    <?php foreach ($vendors as $vendor): ?>
                                        <option value="<?= $vendor['id'] ?>"
                                            data-name="<?= $vendor['name'] ?>"
                                            data-mobile="<?= $vendor['mobile'] ?>">
                                            <?= $vendor['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Hidden field to store actual vendor name -->
                            <input type="hidden" name="vendor_name" id="vendorName">

                            <!-- Vendor Mobile Autofill -->
                            <div class="col-md-6">
                                <label class="form-label">Vendor Mobile</label>
                                <input type="text" name="vendor_mobile" id="vendorMobile" class="form-control" readonly required>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Product</label>
                                    <select name="product_name" class="form-select" required>
                                        <option value="">-- Select Product --</option>
                                        <?php if (!empty($products)): ?>
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?= $product['item_name'] ?>">
                                                    <?= $product['item_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">No products available</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Product Status</label>
                                    <select name="product_status" class="form-select">
                                        <option value="">-- Select Status --</option>
                                        <option value="Forwarded">Forwarded</option>
                                        <option value="In Cleaning">In Cleaning</option>
                                        <option value="Returned">Returned</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4"> <label class="form-label">Forward Date</label> <input type="date" name="forward_date" class="form-control" required> </div>
                                <div class="col-md-4"> <label class="form-label">Expected Return</label> <input type="date" name="return_date" class="form-control"> </div>

                                <div class="mb-3">
                                    <label class="form-label">Cleaning Notes</label>
                                    <textarea name="cleaning_notes" class="form-control" rows="3" placeholder="Enter any specific cleaning instructions..."></textarea>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-submit">Forward</button>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#vendorSelect').change(function() {
                var vendorId = $(this).val();
                if (vendorId) {
                    $.ajax({
                        url: '<?= base_url("Vendors/get_vendor_mobile/") ?>' + vendorId,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#vendorMobile').val(data.mobile);
                        }
                    });
                } else {
                    $('#vendorMobile').val('');
                }
            });
        });
    </script>

    <script>
        document.getElementById('vendorSelect').addEventListener('change', function() {
            var selected = this.options[this.selectedIndex];
            document.getElementById('vendorMobile').value = selected.getAttribute('data-mobile') || '';
            document.getElementById('vendorName').value = selected.getAttribute('data-name') || '';
        });
    </script>
</body>

</html>