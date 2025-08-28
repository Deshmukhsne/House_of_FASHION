<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tailor Management</title>
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

        .main {
            width: 100%;
            overflow-x: auto;
        }

        .table-container {
            overflow-x: auto;
            width: 100%;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .card-header h4 {
                font-size: 1.2rem;
            }

            .search-form .col-md-4,
            .search-form .col-md-3 {
                width: 100%;
                max-width: 100%;
                flex: 0 0 100%;
            }

            .table th,
            .table td {
                white-space: nowrap;
                font-size: 0.85rem;
                padding: 0.5rem;
            }

            .action-buttons {
                display: flex;
                flex-wrap: nowrap;
            }
        }

        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-body .col-md-6,
            .modal-body .col-md-12 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .container-fluid {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            .container.py-4 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
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
                <div class="container py-2 py-md-4">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <h4 class="mb-2 mb-md-0">Tailor Management</h4>
                            <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addTailorModal">+ Add Tailor</button>
                        </div>

                        <div class="card-body">
                            <form method="get" class="row g-2 mb-3 search-form">
                                <div class="col-12 col-md-8 col-lg-4">
                                    <input type="text" id="globalSearch" class="form-control" placeholder="Search tailors...">
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <button class="btn btn-dark w-100" type="submit">Search</button>
                                </div>
                            </form>

                            <div class="table-container">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>

                                            <th>Specialization</th>
                                            <th>Shop Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($tailors)) : foreach ($tailors as $tailor) : ?>
                                                <tr>
                                                    <td><?= $tailor['name'] ?></td>
                                                    <td><?= $tailor['email'] ?></td>
                                                    <td><?= $tailor['mobile'] ?></td>

                                                    <td><?= $tailor['specialization'] ?></td>
                                                    <td><?= $tailor['shop_address'] ?></td>
                                                    <td class="action-buttons">
                                                        <button class="btn btn-sm btn-warning editBtn me-1"
                                                            data-id="<?= $tailor['id'] ?>"
                                                            data-name="<?= $tailor['name'] ?>"
                                                            data-email="<?= $tailor['email'] ?>"
                                                            data-mobile="<?= $tailor['mobile'] ?>"

                                                            data-specialization="<?= $tailor['specialization'] ?>"
                                                            data-shop_address="<?= $tailor['shop_address'] ?>"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editTailorModal">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <a href="<?= base_url('Tailors/delete/' . $tailor['id']) ?>"
                                                            class="btn btn-sm btn-danger deleteBtn"
                                                            data-id="<?= $tailor['id'] ?>">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                        else : ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No tailors found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Tailor Modal -->
                <div class="modal fade" id="addTailorModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="<?= base_url('Tailors/create') ?>" method="post" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Tailor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body row g-2">
                                <div class="col-12 col-md-6"><input type="text" name="name" class="form-control" placeholder="Name" required></div>
                                <div class="col-12 col-md-6"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
                                <div class="col-12 col-md-6"><input type="text" name="mobile" class="form-control" placeholder="Mobile" required></div>

                                <div class="col-12 col-md-6"><input type="text" name="specialization" class="form-control" placeholder="Specialization" required></div>
                                <div class="col-12"><input type="text" name="shop_address" class="form-control" placeholder="Shop Address" required></div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-gold">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Tailor Modal -->
                <div class="modal fade" id="editTailorModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form id="editTailorForm" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Tailor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body row g-3">
                                    <input type="hidden" name="id" id="edit_id">
                                    <div class="col-12 col-md-6"><label>Name</label><input type="text" class="form-control" name="name" id="edit_name" required></div>
                                    <div class="col-12 col-md-6"><label>Email</label><input type="email" class="form-control" name="email" id="edit_email" required></div>
                                    <div class="col-12 col-md-6"><label>Mobile</label><input type="text" class="form-control" name="mobile" id="edit_mobile" required></div>

                                    <div class="col-12 col-md-6"><label>Specialization</label><input type="text" class="form-control" name="specialization" id="edit_specialization" required></div>
                                    <div class="col-12"><label>Shop Address</label><input type="text" class="form-control" name="shop_address" id="edit_shop_address" required></div>
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
                    text: "This tailor will be permanently deleted!",
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

        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_email').value = this.dataset.email;
                document.getElementById('edit_mobile').value = this.dataset.mobile;
                // ❌ remove the wrong experience line
                document.getElementById('edit_specialization').value = this.dataset.specialization;
                document.getElementById('edit_shop_address').value = this.dataset.shop_address;
                document.getElementById('editTailorForm').action = '<?= base_url("Tailors/edit/") ?>' + this.dataset.id;
            });
        });


        document.getElementById('globalSearch').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            document.querySelectorAll('table tbody tr').forEach(row => {
                let rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($this->session->flashdata('swal')): ?>
        <script>
            Swal.fire({
                icon: "<?= $this->session->flashdata('swal')['type'] ?>",
                title: "<?= $this->session->flashdata('swal')['title'] ?>",
                text: "<?= $this->session->flashdata('swal')['text'] ?>",
                confirmButtonColor: '#000'
            });
        </script>
    <?php endif; ?>

</body>

</html>