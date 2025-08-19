

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Stock</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-header {
            background-color: #000;
            color: #FFD27F;
            font-weight: 600;
        }

        .btn-gold {
            background: linear-gradient(90deg, #B37B16, #FFD27F, #B37B16);
            color: #000;
            font-weight: 600;
        }

        .btn-gold:hover {
            background: linear-gradient(90deg, #e2a93eff, #f7c872ff, #e1aa46ff);
            color: #000;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 210, 127, 0.5);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }
    </style>

</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php $this->load->view('include/sidebar'); ?>

        <!-- Main Content Area -->
        <div class="main">
            <!-- Navbar -->
            <?php $this->load->view('include/navbar'); ?>

            <!-- Page Content -->
            <div class="container-fluid p-4">
              <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    Add New Category
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control" id="category_name" placeholder="Enter category name">
                        </div>
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-gold px-4">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>

    </div>
    </div>
    </div>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar  toggler
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