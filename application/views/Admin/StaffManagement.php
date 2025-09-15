<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                            <h4 class="mb-0">Staff Management</h4>
                            <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addStaffModal">+ Add Staff</button>
                        </div>

                        <div class="card-body">
                            <!-- Search -->
                            <form method="get" class="row g-2 mb-3 search-form">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-dark" type="submit">Search</button>
                                </div>
                            </form>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Joining Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($staffs)): ?>
                                            <?php foreach ($staffs as $staff): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($staff->name) ?></td>
                                                    <td><?= htmlspecialchars($staff->email) ?></td>
                                                    <td><?= htmlspecialchars($staff->phone) ?></td>
                                                    <td><?= htmlspecialchars($staff->address) ?></td>
                                                    <td><?= htmlspecialchars($staff->joining_date) ?></td>
                                                    <td class="action-buttons">
                                                        <button class="btn btn-sm btn-warning editBtn"
                                                            data-id="<?= $staff->id ?>"
                                                            data-name="<?= htmlspecialchars($staff->name) ?>"
                                                            data-email="<?= htmlspecialchars($staff->email) ?>"
                                                            data-phone="<?= htmlspecialchars($staff->phone) ?>"
                                                            data-address="<?= htmlspecialchars($staff->address) ?>"
                                                            data-joining_date="<?= htmlspecialchars($staff->joining_date) ?>"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editStaffModal">Edit</button>
                                                        <a href="<?= base_url('AdminController/delete_staff/' . $staff->id) ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this staff?')">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No staff found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Staff Modal -->
                <div class="modal fade" id="addStaffModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="<?= base_url('AdminController/add_staff') ?>" method="post" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Staff</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body row g-2">
                                <div class="col-md-6"><input type="text" name="name" class="form-control" placeholder="Name" required></div>
                                <div class="col-md-6"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
                                <div class="col-md-6"><input type="text" name="phone" class="form-control" placeholder="Phone" required maxlength="10"></div>
                                <div class="col-md-6"><input type="text" name="address" class="form-control" placeholder="Address" required></div>
                                <div class="col-md-6"><input type="date" name="joining_date" class="form-control" required></div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-gold">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#addStaffModal form');
    
    // Validation patterns
    const patterns = {
        name: /^[A-Za-z\s]+$/, // Letters and spaces only
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, // Basic email format
        phone: /^\d{10}$/, // Exactly 10 digits
        address: /^[\w\s,.-]+$/, // Alphanumeric, spaces, commas, periods, hyphens
        joining_date: /^\d{4}-\d{2}-\d{2}$/, // Date in YYYY-MM-DD format
    };

    // Validation messages
    const messages = {
        name: 'Name should contain only letters and spaces',
        email: 'Please enter a valid email address',
        phone: 'Phone number must be exactly 10 digits',
        address: 'Please enter a valid address',
        joining_date: 'Please select a valid joining date',
    };

    // Validate input field
    function validateInput(input) {
        const field = input.name;
        const value = input.value.trim();
        const errorId = `${field}Error`;
        
        // Remove existing error message if any
        const existingError = input.parentElement.querySelector(`#${errorId}`);
        if (existingError) existingError.remove();

        // Special handling for date input
        if (field === 'joining_date') {
            const date = new Date(value);
            if (!value || isNaN(date.getTime())) {
                input.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.id = errorId;
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = messages[field];
                input.parentElement.appendChild(errorDiv);
                return false;
            }
        } else if (!patterns[field].test(value)) {
            input.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.id = errorId;
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = messages[field];
            input.parentElement.appendChild(errorDiv);
            return false;
        }

        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        return true;
    }

    // Validate all inputs on form submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Validate each input
        ['name', 'email', 'phone', 'address', 'joining_date'].forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            if (!validateInput(input)) {
                isValid = false;
            }
        });

        // Submit form if all validations pass
        if (isValid) {
            form.submit();
        }
    });

    // Real-time validation on input
    form.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            validateInput(this);
        });
    });
});

                    </script>

                <!-- Edit Staff Modal -->
                <div class="modal fade" id="editStaffModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="editStaffForm" method="post" action="<?= base_url('AdminController/update_staff') ?>" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Staff</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body row g-3">
                                <input type="hidden" name="id" id="edit_id">
                                <div class="col-md-6"><label>Name</label><input type="text" class="form-control" name="name" id="edit_name" required></div>
                                <div class="col-md-6"><label>Email</label><input type="email" class="form-control" name="email" id="edit_email" required></div>
                                <div class="col-md-6"><label>Phone</label><input type="text" class="form-control" name="phone" id="edit_phone" required></div>
                                <div class="col-md-6"><label>Address</label><input type="text" class="form-control" name="address" id="edit_address" required></div>
                                <div class="col-md-6"><label>Joining Date</label><input type="date" class="form-control" name="joining_date" id="edit_joining_date" required></div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-gold">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Fill Edit Modal
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_email').value = this.dataset.email;
                document.getElementById('edit_phone').value = this.dataset.phone;
                document.getElementById('edit_address').value = this.dataset.address;
                document.getElementById('edit_joining_date').value = this.dataset.joining_date;
            });
        });
    </script>
    <script>
                                        // Sidebar toggler
                                        const toggler = document.querySelector(".toggler-btn");
                                        const closeBtn = document.querySelector(".close-sidebar");
                                        const sidebar = document.querySelector("#sidebar");

                                        if (toggler && sidebar) {
                                            toggler.addEventListener("click", () => sidebar.classList.toggle("collapsed"));
                                        }
                                        if (closeBtn && sidebar) {
                                            closeBtn.addEventListener("click", () => sidebar.classList.remove("collapsed"));
                                        }
                                    </script>


</body>

</html>