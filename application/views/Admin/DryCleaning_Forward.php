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
        h2.section-heading {
            background-color: #000;
            color: #FFD700;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: 400;
            font-size: 1.8rem;
        }
        .form-container {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
        }
        .btn-submit:hover {
            background-color: #218838;
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
                        <div class="col-md-6">
                            <label class="form-label">Vendor Name</label>
                            <input type="text" name="vendor_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Vendor Mobile</label>
                            <input type="text" name="vendor_mobile" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Product</label>
                            <select name="product_name" class="form-select" required>
                                <option value="">-- Select Product --</option>
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product->product_name ?>">
                                            <?= $product->product_name ?> (Order #<?= $product->order_id ?>)
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
                        <div class="col-md-4">
                            <label class="form-label">Forward Date</label>
                            <input type="date" name="forward_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Expected Return</label>
                            <input type="date" name="expected_return" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Return Date</label>
                            <input type="date" name="return_date" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cleaning Notes</label>
                        <textarea name="cleaning_notes" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-submit px-4">Forward</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#drycleaningForm").on("submit", function(){
        // Optional validation logic here
    });
});
</script>

</body>
</html>
