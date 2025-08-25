<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dry Cleaning Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        h2.section-heading {
            background-color: #000;
            color: #FFD700;
            padding: 7px;
            border-radius: 8px;
            text-align: center;
            font-weight: 400;
            font-size: 2rem;
        }

        .btn-stock {
            background-color: #28a745;
            color: white;
        }

        .btn-stock:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #b02a37;
        }
        
        /* Responsive styles for main content */
        .main {
            width: 100%;
            overflow-x: auto;
        }
        
        .table-container {
            overflow-x: auto;
            width: 100%;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 992px) {
            .container-fluid.p-4 {
                padding: 1rem !important;
            }
            
            .container.mt-5.p-4 {
                margin-top: 1rem !important;
                padding: 1rem !important;
            }
            
            h2.section-heading {
                font-size: 1.5rem;
                padding: 10px;
            }
        }
        
        @media (max-width: 768px) {
            h2.section-heading {
                font-size: 1.3rem;
            }
            
            #cleaningTable {
                min-width: 800px; /* Force horizontal scroll on small screens */
            }
            
            .table th, 
            .table td {
                padding: 0.5rem;
                font-size: 0.85rem;
            }
            
            .btn-stock, 
            .btn-delete {
                font-size: 0.8rem;
                padding: 0.25rem 0.5rem;
            }
            
            .form-select {
                font-size: 0.85rem;
                padding: 0.25rem;
            }
        }
        
        @media (max-width: 576px) {
            h2.section-heading {
                font-size: 1.1rem;
                margin-bottom: 1rem !important;
            }
            
            .container.mt-5.p-4 {
                margin-top: 0.5rem !important;
                padding: 0.75rem !important;
            }
            
            .table th, 
            .table td {
                padding: 0.4rem;
                font-size: 0.8rem;
            }
            
            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .btn-stock, 
            .btn-delete {
                width: 100%;
                margin: 2px 0;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <?php $this->load->view('include/sidebar'); ?>
        <div class="main">
            <?php $this->load->view('include/navbar'); ?>

            <div class="container-fluid p-3 p-md-4">
                <div class="container mt-3 mt-md-5 p-3 p-md-4 bg-light rounded shadow">
                    <h2 class="section-heading mb-3 mb-md-4">Dry Cleaning Status</h2>

                    <div class="table-container">
                        <table class="table table-bordered table-striped" id="cleaningTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Vendor Name</th>
                                    <th>Vendor Mobile</th>
                                    <th>Product Name</th>
                                    <th>Product Status</th>
                                    <th>Forward Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Cleaning Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($drycleaning_data as $item): ?>
                                    <tr data-id="<?= $item->id ?>">
                                        <td><?= $item->id ?></td>
                                        <td><?= $item->vendor_name ?></td>
                                        <td><?= $item->vendor_mobile ?></td>
                                        <td><?= $item->product_name ?></td>
                                        <td><?= $item->product_status ?></td>
                                        <td><?= $item->forward_date ?></td>
                                        <td><?= $item->return_date ?></td>
                                        <td>
                                            <select name="status" class="form-select" data-id="<?= $item->id ?>">
                                                <option value="Forwarded" <?= $item->status == 'Forwarded' ? 'selected' : '' ?>>Forwarded</option>
                                                <option value="In Cleaning" <?= $item->status == 'In Cleaning' ? 'selected' : '' ?>>In Cleaning</option>
                                                <option value="Returned" <?= $item->status == 'Returned' ? 'selected' : '' ?>>Returned</option>
                                            </select>
                                        </td>
                                        <td><?= $item->cleaning_notes ?></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-stock btn-sm mb-1 mb-md-0">Add in Stock</button>
                                            <button class="btn btn-delete btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Update Status
            $("#cleaningTable").on("change", "select[name='status']", function() {
                let recordID = $(this).data("id");
                let newStatus = $(this).val();

                $.post("<?= base_url('drycleaning/update_status') ?>", {
                    id: recordID,
                    status: newStatus
                }, function(response) {
                    let res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed'
                        });
                    }
                });
            });

            // Add to Stock
            $("#cleaningTable").on("click", ".btn-stock", function() {
                let row = $(this).closest("tr");
                let status = row.find("select[name='status']").val();
                let recordID = row.data("id");
                let productName = row.find("td:eq(3)").text().trim();

                if (status !== "Returned") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Status must be Returned',
                        text: 'Only returned items can be added to stock.'
                    });
                    return;
                }

                Swal.fire({
                    icon: 'question',
                    title: 'Add to Stock?',
                    text: `Do you want to add ${productName} to stock?`,
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Add'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("<?= base_url('AdminController/ProductInventory') ?>", {
                            id: recordID
                        }, function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Added to Stock',
                                text: `${productName} added successfully!`
                            }).then(() => {
                                row.remove();
                            });
                        }).fail(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to add item to stock.'
                            });
                        });
                    }
                });
            });

            // Delete Record
            $("#cleaningTable").on("click", ".btn-delete", function() {
                let row = $(this).closest("tr");
                let recordID = row.data("id");
                let productName = row.find("td:eq(3)").text().trim();

                Swal.fire({
                    icon: 'warning',
                    title: 'Delete Item?',
                    text: `Delete ${productName}?`,
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("<?= base_url('AdminController/delete_drycleaning') ?>", {
                            id: recordID
                        }, function(response) {
                            let res = JSON.parse(response);
                            if (res.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted',
                                    text: `${productName} deleted successfully.`
                                }).then(() => {
                                    row.remove();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to delete item.'
                                });
                            }
                        }).fail(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Server error occurred.'
                            });
                        });
                    }
                });
            });

        });
    </script>
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