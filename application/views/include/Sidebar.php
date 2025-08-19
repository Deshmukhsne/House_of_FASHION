<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Billing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="views/CommonLinks.php">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Sidebar */
        a {
            text-decoration: none;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 16px;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
        }

        ::-webkit-scrollbar {
            width: 0;
        }

        /* === Layout === */
        .main {
            width: 100%;
            height: 100vh;
            overflow-y: auto;
        }

        /* === Sidebar === */
        #sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), url('<?php echo base_url("assets/images/sidebar_bg.jpg"); ?>') no-repeat center center;
            color: #fff;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
            transition: all 0.35s ease-in-out;
        }

        #sidebar.collapsed {
            margin-left: -280px;
        }

        .sidebar-nav {
            flex: 1 1 auto;
            overflow-y: auto;
        }

        /* === Sidebar Logo === */
        .sidebar-logo {
            text-align: center;
            padding: 1.2rem;
            position: relative;
        }

        .sidebar-logo img {
            width: 150px;
            height: 80px;
        }

        .sidebar-logo span {
            font-weight: bold;
            font-size: 1.4rem;
            background: linear-gradient(to bottom, rgb(255, 217, 0), #b8860b);
            /* -webkit-background-clip: text; */
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        /* === Close Button (Mobile) === */
        .close-sidebar {
            display: none;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
        }

        /* === Sidebar Link === */
        .page-heading {
            background: linear-gradient(90deg, #fffbe6 0%, #ffe4b5 100%);
            color: #8B004D !important;
            font-weight: 700;
            padding: 8px 10px;

            margin-bottom: 20px;
            border-radius: 4px 4px 4px 4px !important;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            font-size: 18px;
            color: #fac852ff;
            position: relative;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-link i {
            margin-right: 0.8rem;
            font-size: 1.1rem;
        }

        /* Hover Effects */
        .sidebar-link:hover,
        .sidebar-link:focus {
            background: linear-gradient(90deg, #FFD27F 0%, #B37B16 100%);
            color: black !important;
            box-shadow: 0 2px 12px rgba(209, 78, 120, 0.15);
            transform: translateX(6px) scale(1.03);
            z-index: 1;
        }

        */

        /* Active Link */
        .sidebar-link.active {
            background: linear-gradient(90deg, #FFD27F 0%, #B37B16 100%);
            color: #8B004D !important;
            font-weight: 700;
            border-left: 4px solid #8b004d;
            box-shadow: 0 2px 8px rgba(255, 217, 0, 0.1);
        }

        .sidebar-link.active i {
            color: #d14e78 !important;
        }

        /* === Dropdown Arrows Working === */
        .sidebar-link[data-bs-toggle="collapse"]::after {
            content: "";
            border: solid currentColor;
            border-width: 0 2px 2px 0;
            padding: 3px;
            position: absolute;
            right: 1.5rem;
            top: 1.25rem;
            transform: rotate(45deg);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
            transform: rotate(-45deg);
        }

        /* Submenu Items */
        .nav .nav-item .sidebar-link {
            padding-left: 2rem;
            font-size: 17px;
        }

        .collapse {
            margin-left: 0.5rem;
        }

        /* === Footer === */
        .sidebar-footer {
            padding: 0.75rem 1.25rem;
        }

        .sidebar-footer a {
            font-size: 16px;
            color: #fac852ff;
        }

        .sidebar-footer a:hover {
            background: linear-gradient(90deg, #FFD27F 0%, #B37B16 100%);
            color: black !important;
            transform: translateX(4px) scale(1.02);
        }

        /* === Navbar === */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px 15px;
            background-color: #fff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.35s ease-in-out;
        }

        /* === Toggler Button === */
        .toggler-btn {
            background-color: transparent;
            cursor: pointer;
            border: 0;
            display: inline-block;
        }

        .toggler-btn i {
            font-size: 1.75rem;
            color: #333;
            font-weight: 600;
        }

        /* === Responsive === */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                z-index: 1100;
                left: 0;
                top: 0;
            }

            #sidebar.collapsed {
                margin-left: 0;
            }

            .sidebar-toggle {
                margin-left: -280px;
            }

            .close-sidebar {
                display: block;
            }

            .navbar {
                height: 9%;
                width: 100%;
                left: 0;
            }
        }

        @media (max-width: 991px) {
            .dropdown-menu-end {
                left: auto;
                right: 0;
            }
        }

        @media (max-width: 530px) {
            #notificationDropdown {
                max-width: 300px !important;
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <aside id="sidebar" class="sidebar-toggle bg-light">
            <div class="sidebar-logo">
                <img src="<?php echo base_url('assets/images/logo.jpg'); ?>" class="logo-full" alt="Full Logo">
                <i class="bi bi-x-lg close-sidebar mt-3"></i>
            </div>
            <!-- Sidebar Navigation -->
            <ul class="sidebar-nav p-0 mt-4" style="font-size: 1.15rem;">
                <!-- Profile Image & Name -->
                <!-- Dashboard -->
                <li class="sidebar-item">
                    <a href="<?= base_url('AdminController/Dashboard') ?>" class="sidebar-link" id="dashboard-link" style="font-size: 20px;">
                        <i class="bi bi-house-fill"></i>
                        <span class="ms-1">Dashboard</span>
                    </a>
                </li>

                <!-- Stock -->
                <li class="sidebar-item">
                    <a href="<?= base_url('AdminController/ProductInventory') ?>" class="sidebar-link" style="font-size: 20px;">
                        <i class="bi bi-box me-2"></i>
                        <span class="ms-1">Stock</span>
                    </a>
                </li>

                <!-- Services -->
                <li class="sidebar-item">
                    </a>



                    <a href="<?= base_url('AdminController/Orders') ?>" class="sidebar-link" id="orders-link" style="font-size: 20px;">
                        <i class="bi bi-cart-check me-2"></i>
                        <span class="ms-1">Orders</span>
                    </a>
                <li class="sidebar-item">
                    <a class="sidebar-link collapsed" data-bs-toggle="collapse" href="#drySubmenu" role="button" aria-expanded="false" aria-controls="drySubmenu" style="font-size: 20px;">
                        <i class="bi bi-droplet-half me-2"></i>
                        <span class="ms-1">Dry Cleaning</span>
                    </a>

                    <div class="collapse" id="drySubmenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="<?= base_url('AdminController/DryCleaning_Forward') ?>" class="sidebar-link" style="font-size: 18px;">
                                    <i class="bi bi-file-earmark-plus"></i>
                                    <span class="ms-1">Give to Drycleaning</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('AdminController/DryCleaning_Status') ?>" class="sidebar-link" style="font-size: 18px;">
                                    <i class="bi bi-clock-history"></i>
                                    <span class="ms-1">Status</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Billing -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link dropdown-toggle collapsed" id="billing-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#billingSubmenu" aria-expanded="false" style="font-size: 20px;">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span class="ms-1">Billing</span>
                    </a>
                    <div class="collapse" id="billingSubmenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="<?= base_url('AdminController/Billing') ?>" class="sidebar-link" id="billsection-link" style="font-size: 18px;">
                                    <i class="bi bi-file-earmark-plus"></i>
                                    <span class="ms-1">Bill Section</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('AdminController/BillHistory') ?>" class="sidebar-link" id="billhistory-link" style="font-size: 18px;">
                                    <i class="bi bi-clock-history"></i>
                                    <span class="ms-1">Bill History</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Reports -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link dropdown-toggle collapsed" id="reports-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#reportsSubmenu" aria-expanded="false" style="font-size: 20px;">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span class="ms-1">Reports</span>
                    </a>
                    <div class="collapse" id="reportsSubmenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="<?= base_url('AdminController/DailyReport') ?>" class="sidebar-link" id="dailyreport-link" style="font-size: 18px;">
                                    <i class="bi bi-calendar-day"></i>
                                    <span class="ms-1">Daily Report</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('AdminController/MonthlyReport') ?>" class="sidebar-link" id="monthlyreport-link" style="font-size: 18px;">
                                    <i class="bi bi-calendar2-month"></i>
                                    <span class="ms-1">Monthly Report</span>
                                </a>
                            </li>

                         
                        </ul>
                    </div>
                </li>
                <a href="<?= base_url('AdminController/StaffManagement') ?>" class="sidebar-link" id="dashboard-link" style="font-size: 20px;">
                    <i class="bi-person-lines-fill"></i>
                    <span class="ms-1">Staff Management</span>
                </a>
                <!-- Profile -->
                <li class="sidebar-item">

                    <a href="<?= base_url('AdminController/Profile') ?>" class="sidebar-link" id="profile-link" style="font-size: 20px;">


                        <i class="bi bi-person-fill"></i>
                        <span class="ms-1">Profile</span>
                    </a>
                </li>
            </ul>


            <!-- LOGOUT -->

            <div class="sidebar-footer mb-3">
                <a href="#" id="logout-btn" class="sidebar-link" style="font-size: 16px;">
                    <i class="bi bi-box-arrow-left"></i>
                    <span class="ms-1">Log out</span>
                </a>
            </div>


    </div>


    </aside>


    <script>
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('AdminController/login') ?>";
                }
            });
        });
    </script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.sidebar-link[data-bs-toggle="collapse"]').forEach(link => {
            const submenuId = link.getAttribute('href');
            const submenu = document.querySelector(submenuId);

            if (!submenu) return;

            link.addEventListener('dblclick', function(e) {
                e.preventDefault(); // Prevent default anchor behavior

                const bsCollapse = bootstrap.Collapse.getOrCreateInstance(submenu, {
                    toggle: false
                });

                bsCollapse.hide(); // Force close on double-click
            });
        });
    </script>



</body>

</html>