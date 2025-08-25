<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            background: linear-gradient(90deg, #e2a93eff, #f7c872ff, #e1aa46ff);
            color: #000;
            font-weight: 600;
        }

        .modal-header {
            background-color: #000;
            color: #FFD27F;
        }

        .table th {
            background-color: #343a40;
            color: #FFD27F;
        }

        /* Responsive styles */
        .main {
            width: 100%;
            transition: margin-left 0.3s;
        }

        .container-fluid {
            padding: 15px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .action-buttons {
            white-space: nowrap;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 10px;
            }
            
            .card-header h4 {
                font-size: 1.2rem;
            }
            
            .search-form .col-md-4,
            .search-form .col-md-3 {
                margin-bottom: 10px;
                width: 100%;
            }
            
            .table th, 
            .table td {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
            
            .modal-body .col-md-6 {
                margin-bottom: 10px;
                width: 100%;
            }
            
            .action-buttons .btn {
                margin-bottom: 5px;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding: 10px;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .modal-dialog {
                margin: 10px;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
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
                <div class="container py-4">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Staff & Accountant Management</h4>
                            <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addStaffModal">+ Add Staff</button>
                        </div>

                        <div class="card-body">
                            <form method="get" class="row g-2 mb-3 search-form">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="">
                                </div>
                                <div class="col-md-3">
                                    <select name="role" class="form-control">
                                        <option value="">All Roles</option>
                                        <option value="Staff">Staff</option>
                                        <option value="Accountant">Accountant</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-dark" type="submit">Search</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Joining Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>John Doe</td>
                                            <td>john@example.com</td>
                                            <td>123-456-7890</td>
                                            <td>Staff</td>
                                            <td>2023-01-15</td>
                                            <td class="action-buttons">
                                                <button class="btn btn-sm btn-warning editBtn"
                                                    data-id="1"
                                                    data-name="John Doe"
                                                    data-email="john@example.com"
                                                    data-phone="123-456-7890"
                                                    data-address="123 Main St"
                                                    data-joining_date="2023-01-15"
                                                    data-role="Staff"
                                                    data-username="johndoe"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editStaffModal">
                                                    Edit
                                                </button>
                                                <a href="#" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff?')">Delete</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jane Smith</td>
                                            <td>jane@example.com</td>
                                            <td>987-654-3210</td>
                                            <td>Accountant</td>
                                            <td>2023-03-22</td>
                                            <td class="action-buttons">
                                                <button class="btn btn-sm btn-warning editBtn"
                                                    data-id="2"
                                                    data-name="Jane Smith"
                                                    data-email="jane@example.com"
                                                    data-phone="987-654-3210"
                                                    data-address="456 Oak Ave"
                                                    data-joining_date="2023-03-22"
                                                    data-role="Accountant"
                                                    data-username="janesmith"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editStaffModal">
                                                    Edit
                                                </button>
                                                <a href="#" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff?')">Delete</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Staff Modal -->
                <div class="modal fade" id="addStaffModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="#" method="post" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Staff/Accountant</h5>
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
                                    <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="joining_date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <select name="role" class="form-control" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option value="Staff">Staff</option>
                                        <option value="Accountant">Accountant</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-gold">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Staff Modal -->
                <div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="editStaffForm" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Staff</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" id="edit_phone" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" id="edit_address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Joining Date</label>
                                        <input type="date" class="form-control" name="joining_date" id="edit_joining_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Role</label>
                                        <select class="form-select" name="role" id="edit_role" required>
                                            <option value="Staff">Staff</option>
                                            <option value="Accountant">Accountant</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" id="edit_username" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>New Password (optional)</label>
                                        <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
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
        // Edit button functionality
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_email').value = this.dataset.email;
                document.getElementById('edit_phone').value = this.dataset.phone;
                document.getElementById('edit_address').value = this.dataset.address;
                document.getElementById('edit_joining_date').value = this.dataset.joining_date;
                document.getElementById('edit_role').value = this.dataset.role;
                document.getElementById('edit_username').value = this.dataset.username;
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
</body>

</html>