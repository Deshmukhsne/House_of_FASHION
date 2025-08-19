<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .card {
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            font-weight: 600;
        }

        .input-group-text {
            background-color: #fff;
            border-left: none;
            cursor: pointer;
        }

        .form-control {
            border-radius: 8px 0 0 8px;
            border-right: none;
        }

        .input-group .form-control:last-child {
            border-radius: 8px;
        }

        .toggle-password i {
            font-size: 1.2rem;
        }

        .btn-gradient {
            background: linear-gradient(90deg, #B37B16, #FFD27F, #B37B16);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #FFD27F, #B37B16, #FFD27F);
            color: black;
        }

        .alert {
            font-size: 14px;
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
                <div class="container mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-sm-12">
                            <div class="card p-4">
                                <h4 class="text-center mb-4">Change Password</h4>

                                <!-- Flash Messages -->
                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                                <?php elseif ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                                <?php endif; ?>

                                <!-- Password Form -->
                                <form id="changePasswordForm" method="POST" action="<?= base_url('AdminController/change_password_handler') ?>">
                                    <div class="mb-3">
                                        <label for="currentPassword" class="form-label">Current Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Enter current password" required>
                                            <span class="input-group-text toggle-password" onclick="togglePassword('currentPassword', this)">
                                                <i class="bi bi-eye-fill"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                                            <span class="input-group-text toggle-password" onclick="togglePassword('newPassword', this)">
                                                <i class="bi bi-eye-fill"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required>
                                            <span class="input-group-text toggle-password" onclick="togglePassword('confirmPassword', this)">
                                                <i class="bi bi-eye-fill"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-gradient">Save Changes</button>
                                    </div>
                                </form>

                                <div id="messageBox" class="mt-3 text-center text-danger fw-semibold"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Toggle and Validation -->
    <script>
        function togglePassword(id, iconElement) {
            const input = document.getElementById(id);
            const icon = iconElement.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        }

        // Password match validation
        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('confirmPassword').value;
            const messageBox = document.getElementById('messageBox');

            if (newPass !== confirmPass) {
                e.preventDefault();
                messageBox.innerText = "New passwords do not match!";
            }
        });
    </script>

    <!-- Sidebar toggle JS -->
    <script>
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