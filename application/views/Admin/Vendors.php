<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vendor Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
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
            background: linear-gradient(90deg, #B37B16 0%, #FFD27F 100%);
            color: #000;
            font-weight: 600;
        }

        .btn-gold:hover {
            background: linear-gradient(90deg, #e2a93e, #f7c872, #e1aa46);
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
    </style>
</head>

<body>
    <div class="d-flex">
        <?php $this->load->view('include/sidebar'); ?>
        <div class="main">
            <?php $this->load->view('include/navbar'); ?>
            <div class="container-fluid p-4">
                <div class="container py-4">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Vendor Management</h4>
                            <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addVendorModal">+ Add Vendor</button>
                        </div>

                        <div class="card-body">
                            <form method="get" class="row g-2 mb-3">
                                <div class="col-md-4">
                                    <input type="text" id="globalSearch" class="form-control" placeholder="Search vendors...">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-dark" type="submit">Search</button>
                                </div>
                            </form>

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Company</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($vendors)) : foreach ($vendors as $vendor) : ?>
                                            <tr>
                                                <td><?= $vendor['name'] ?></td>
                                                <td><?= $vendor['email'] ?></td>
                                                <td><?= $vendor['mobile'] ?></td>
                                                <td><?= $vendor['company'] ?></td>
                                                <td><?= $vendor['address'] ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning editBtn"
                                                        data-id="<?= $vendor['id'] ?>"
                                                        data-name="<?= $vendor['name'] ?>"
                                                        data-email="<?= $vendor['email'] ?>"
                                                        data-mobile="<?= $vendor['mobile'] ?>"
                                                        data-company="<?= $vendor['company'] ?>"
                                                        data-address="<?= $vendor['address'] ?>"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editVendorModal">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <a href="<?= base_url('Vendors/delete/' . $vendor['id']) ?>"
                                                        class="btn btn-sm btn-danger deleteBtn"
                                                        data-id="<?= $vendor['id'] ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No vendors found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Vendor Modal -->
                <div class="modal fade" id="addVendorModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="<?= base_url('Vendors/create') ?>" method="post" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Vendor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body row g-2">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="mobile" class="form-control" placeholder="Mobile" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="company" class="form-control" placeholder="Company" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-gold">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Vendor Modal -->
                <div class="modal fade" id="editVendorModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="editVendorForm" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Vendor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body row g-3">
                                    <input type="hidden" name="id" id="edit_id">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" id="edit_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" id="edit_email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" name="mobile" id="edit_mobile" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Company</label>
                                        <input type="text" class="form-control" name="company" id="edit_company" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" id="edit_address" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-gold">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let deleteUrl = this.getAttribute('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This vendor will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    </script>
    <?php if ($this->session->flashdata('vendor_msg')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= $this->session->flashdata("vendor_msg"); ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>

    <script>
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_email').value = this.dataset.email;
                document.getElementById('edit_mobile').value = this.dataset.mobile;
                document.getElementById('edit_company').value = this.dataset.company;
                document.getElementById('edit_address').value = this.dataset.address;

                document.getElementById('editVendorForm').action = '<?= base_url("vendors/edit/") ?>' + this.dataset.id;
            });
        });
    </script>
    <script>
        document.getElementById('globalSearch').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            document.querySelectorAll('table tbody tr').forEach(row => {
                let rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchValue) ? '' : 'none';
            });
        });
    </script>

</body>

</html>