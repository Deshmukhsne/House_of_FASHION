<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
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

        .modal-header {
            background-color: #000;
            color: #FFD27F;
        }

        .table th {
            background-color: #343a40;
            color: #FFD27F;
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .status-available {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rented {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-dryclean {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        /* ====== Mobile Responsiveness ====== */
        @media (max-width: 768px) {
            .card-header h5 {
                font-size: 1rem;
            }

            .btn-gold {
                font-size: 0.8rem;
                padding: 6px 10px;
                margin-bottom: 5px;
            }

            .table th,
            .table td {
                font-size: 0.8rem;
                padding: 6px;
            }

            .table img {
                max-width: 45px;
            }

            /* Stack search + filter vertically */
            .row.mb-3 {
                flex-direction: column;
            }

            .row.mb-3 .col-md-6,
            .row.mb-3 .col-md-3 {
                width: 100%;
                margin-bottom: 10px;
            }

            /* Make modals fit smaller screens */
            .modal-dialog {
                max-width: 95% !important;
                margin: auto;
            }
        }

        /* ====== Extra Small Screens ====== */
        @media (max-width: 480px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .card-header h5 {
                margin-bottom: 10px;
            }

            .btn-gold {
                width: 100%;
                margin: 5px 0;
            }

            .table th,
            .table td {
                font-size: 0.75rem;
                padding: 5px;
            }

            .table img {
                max-width: 40px;
            }
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
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Product Inventory</h5>
                            <div>
                                <button class="btn btn-gold me-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
                                <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search by product name...">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="statusFilter">
                                        <option value="">Filter by Status</option>
                                        <option value="Available">Available</option>
                                        <option value="Rented">Rented</option>
                                        <option value="In Dry Clean">In Dry Clean</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price(Rs)</th>
                                            <th>MRP(Rs)</th> <!-- ✅ new -->
                                            <th>Category</th>
                                            <th>Main Category</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($product->image) && file_exists($product->image)): ?>
                                                        <img src="<?= base_url($product->image) ?>" height="60"
                                                            onclick="openImageModal('<?= base_url($product->image) ?>')" style="cursor:pointer;" />
                                                    <?php else: ?>
                                                        <span>No Image</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($product->name) ?></td>
                                                <td><?= number_format((float)($product->price ?? 0), 2) ?></td>
                                                <td><?= number_format((float)($product->mrp ?? 0), 2) ?></td> <!-- ✅ new -->
                                                <td><?= htmlspecialchars($product->category_name ?? '') ?></td>
                                                <td><?= htmlspecialchars($product->main_category ?? '') ?></td>
                                                <td><?= htmlspecialchars($product->stock ?? 0) ?></td>
                                                <td>
                                                    <?php
                                                    $status = ($product->stock <= 0) ? 'Rented' : 'Available';
                                                    ?>
                                                    <span class="status-badge 
                    <?= $status == 'Available' ? 'status-available' : 'status-rented' ?>">
                                                        <?= htmlspecialchars($status) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick='openEditModal(<?= json_encode([
                                                                                    "id" => $product->id,
                                                                                    "name" => $product->name,
                                                                                    "price" => $product->price,
                                                                                    "mrp" => $product->mrp,  // ✅ new
                                                                                    "stock" => $product->stock ?? 0,
                                                                                    "status" => $product->status ?? "",
                                                                                    "category_id" => $product->category_id,
                                                                                    "main_category" => $product->main_category ?? "",
                                                                                    "image" => $product->image
                                                                                ]) ?>)'>
                                                        Edit
                                                    </button>
                                                    <a href="<?= base_url('ProductController/delete_product/' . $product->id) ?>"
                                                        class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ✅ Keep This Modal Only -->
                <div class="modal fade" id="addProductModal" tabindex="-1">
                    <div class="modal-dialog">
                        <form class="modal-content" method="post" action="<?= base_url('ProductController/add_product') ?>" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>

                                <!-- Product Price -->
                                <input type="number" name="price" class="form-control mb-2" placeholder="Product Price" step="0.01" required>

                                <!-- ✅ New MRP Field -->
                                <input type="number" name="mrp" class="form-control mb-2" placeholder="MRP (Maximum Retail Price)" step="0.01" required>

                                <!-- Category -->
                                <select name="category_id" class="form-select mb-2" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Main Category -->
                                <select name="main_category" class="form-select mb-2">
                                    <option value="" readonly>Main Category</option>
                                    <option value="Cloths">Cloths</option>
                                    <option value="Accessories">Accessories</option>
                                </select>

                                <!-- Stock -->
                                <input type="number" name="stock" class="form-control mb-2" placeholder="Stock Quantity" required>

                                <!-- Status -->
                                <select name="status" class="form-select mb-2">
                                    <option value="Available">Available</option>
                                    <option value="Rented">Rented</option>
                                    <option value="In Dry Clean">In Dry Clean</option>
                                </select>

                                <!-- Image -->
                                <input type="file" name="image" class="form-control mb-2" required>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-gold" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Add Category Modal -->
                <div class="modal fade" id="addCategoryModal" tabindex="-1">
                    <div class="modal-dialog">
                        <form class="modal-content" method="post" action="<?= base_url('ProductController/add_category') ?>">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="name" class="form-control mb-2" placeholder="Category Name" required>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-gold" type="submit">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Image Preview Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 320px;">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <img id="modalImage" src="" style="width: 300px; height: 300px; object-fit: contain;" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Product Modal -->
                <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post" action="<?= base_url('ProductController/update_product') ?>" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Hidden ID -->
                                    <input type="hidden" name="product_id" id="edit_product_id">
                                    <input type="hidden" name="existing_image" value="<?= $product->image ?>">
                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" name="name" id="edit_product_name">
                                    </div>
                                    <div class="mb-3">
                                        <label>Price</label>
                                        <input type="number" class="form-control" name="price" id="edit_product_price" step="0.01">
                                    </div>

                                    <!-- Category -->
                                    <!-- Edit Modal -->
                                    <div class="mb-3">
                                        <label>Category</label>
                                        <select class="form-select" name="category_id" id="edit_product_category">
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Main Category</label>
                                        <select class="form-select" name="main_category" id="edit_product_main_category">
                                            <option value="" readonly>Main Category</option>
                                            <option value="Cloths">Cloths</option>
                                            <option value="Accessories">Accessories</option>
                                        </select>

                                        <!-- Stock -->
                                        <div class="mb-3">
                                            <label>Stock</label>
                                            <input type="number" class="form-control" name="stock" id="edit_product_stock">
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select class="form-select" name="status" id="edit_product_status">
                                                <option value="Available">Available</option>
                                                <option value="Rented">Rented</option>
                                                <option value="In Dry Clean">In Dry Clean</option>
                                            </select>
                                        </div>

                                        <!-- Current Image -->
                                        <div class="mb-3">
                                            <label>Current Image</label><br>
                                            <img id="edit_product_image_preview" src="" alt="Current Product Image" width="100" class="border rounded mb-2">
                                        </div>

                                        <!-- New Image -->
                                        <div class="mb-3">
                                            <label>Change Image</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                    </div>
                                </div>
                        </form>
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
                <?php if ($this->session->flashdata('success')): ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '<?= $this->session->flashdata('success') ?>',
                            confirmButtonColor: '#FFD27F'
                        });
                    </script>
                <?php endif; ?>

                <script>
                    function openImageModal(src) {
                        document.getElementById('modalImage').src = src;
                        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
                        myModal.show();
                    }
                </script>
                <script>
                    function openEditModal(product) {
                        document.getElementById('edit_product_id').value = product.id;
                        document.getElementById('edit_product_name').value = product.name;
                        document.getElementById('edit_product_category').value = product.category_id;
                        document.getElementById('edit_product_stock').value = product.stock;
                        document.getElementById('edit_product_price').value = product.price;
                        document.getElementById('edit_product_status').value = product.status;

                        // Fix the image path - use base_url() only once
                        document.getElementById('edit_product_image_preview').src = product.image ? '<?= base_url() ?>' + product.image : '';

                        // Also update the existing_image hidden field
                        document.querySelector('input[name="existing_image"]').value = product.image;

                        var myModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                        myModal.show();
                    }
                    // Search and Filter functionality
                    document.addEventListener('DOMContentLoaded', function() {
                        const searchInput = document.getElementById('searchInput');
                        const statusFilter = document.getElementById('statusFilter');
                        const productRows = document.querySelectorAll('tbody tr');

                        function filterProducts() {
                            const searchTerm = searchInput.value.toLowerCase();
                            const statusValue = statusFilter.value;

                            productRows.forEach(row => {
                                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                                const status = row.querySelector('td:nth-child(6) span').textContent;

                                const nameMatch = name.includes(searchTerm);
                                const statusMatch = statusValue === '' || status === statusValue;

                                if (nameMatch && statusMatch) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        }

                        // Add event listeners
                        searchInput.addEventListener('input', filterProducts);
                        statusFilter.addEventListener('change', filterProducts);
                    });
                </script>

</body>

</html>