<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forward Tailoring</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: linear-gradient(90deg, #0056b3, #004a9c);
            transform: scale(1.03);
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar would be included here -->
        <div class="main">
            <!-- Navbar would be included here -->

            <div class="container-fluid p-4">
                <div class="container form-container">
                    <h2 class="section-heading mb-4">Forward Tailoring Record</h2>

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

                    <form action="<?= base_url('TailoringController/save') ?>" method="post" id="tailoringForm">
                        <div class="row mb-3">
                            <!-- Tailor Name Dropdown -->
                            <div class="col-md-6">
                                <label class="form-label">Tailor Name</label>
                                <select name="tailor_id" id="tailorSelect" class="form-control" required>
                                    <option value="">Select Tailor</option>
                                    <?php foreach ($tailors as $tailor): ?>
                                        <option value="<?= $tailor['id'] ?>"
                                            data-name="<?= $tailor['name'] ?>"
                                            data-mobile="<?= $tailor['mobile'] ?>">
                                            <?= $tailor['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Tailor Mobile Autofill -->
                            <div class="col-md-6">
                                <label class="form-label">Tailor Mobile</label>
                                <input type="text" name="tailor_mobile" id="tailorMobile" class="form-control" readonly required>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="tailor_name" id="tailorName">
                        <input type="hidden" name="invoice_item_id" value="<?= isset($invoice_item_id) ? $invoice_item_id : '' ?>">
                        <input type="hidden" name="product_status" value="In Tailoring">

                        <!-- Product Info (pre-filled) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product_name" class="form-control"
                                    value="<?= isset($product['item_name']) ? $product['item_name'] : '' ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Product Status</label>
                                <input type="text" class="form-control" value="In Tailoring" readonly>
                            </div>
                        </div>

                        <!-- Forward and Return Dates -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Forward Date</label>
                                <input type="date" name="forward_date" class="form-control" required
                                    value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Expected Return Date</label>
                                <input type="date" name="return_date" class="form-control">
                            </div>
                        </div>

                        <!-- Tailoring Details -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tailoring Type</label>
                                <select name="tailoring_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="Alteration">Alteration</option>
                                    <option value="Repair">Repair</option>
                                    <option value="Custom Stitching">Custom Stitching</option>
                                    <option value="Resizing">Resizing</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Measurements</label>
                                <input type="text" name="measurements" class="form-control" placeholder="e.g., Length: 40, Waist: 32">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tailoring Instructions</label>
                            <textarea name="tailoring_instructions" class="form-control" rows="3" placeholder="Enter specific tailoring instructions..."></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-submit">Forward to Tailor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Set tailor info when selection changes
            $('#tailorSelect').change(function() {
                var selected = this.options[this.selectedIndex];
                $('#tailorMobile').val(selected.getAttribute('data-mobile') || '');
                $('#tailorName').val(selected.getAttribute('data-name') || '');
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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