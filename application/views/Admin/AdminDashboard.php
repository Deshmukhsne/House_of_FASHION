<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            color: #343a40;
            min-height: 100vh;
        }

        #sidebar {
            background: #343a40;
            min-width: 240px;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 2px 0 12px rgb(0 0 0 / 0.1);
        }

        #sidebar.collapsed {
            min-width: 80px;
        }

        .main {
            flex-grow: 1;
            background: #fff;
            min-height: 100vh;
            box-shadow: inset 0 0 10px rgb(0 0 0 / 0.05);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 10px 20px rgb(0 0 0 / 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: auto;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgb(0 0 0 / 0.15);
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            font-weight: 600;
            font-size: 1.25rem;
            color: #212529;
        }

        .stat-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-number {
            font-weight: 700;
            font-size: 2.25rem;
            margin-top: 0.15rem;
            color: #212529;
        }

        .card .bi {
            opacity: 0.85;
            transition: opacity 0.3s ease;
        }

        .card:hover .bi {
            opacity: 1;
        }

        .badge {
            font-weight: 600;
            padding: 0.4em 0.75em;
            font-size: 0.85rem;
            border-radius: 20px;
        }

        .category-badge {
            padding: 0.25em 0.75em;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #fff;
            display: inline-block;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.15);
        }

        .saree-badge {
            background: linear-gradient(135deg, #ffda06, #f7b731);
        }

        .dress-badge {
            background: linear-gradient(135deg, #ee8011, #d35400);
        }

        .accessories-badge {
            background: linear-gradient(135deg, #6bb819, #28a745);
        }

        .btn-group .btn {
            border-radius: 30px !important;
            padding: 0.4rem 1.3rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
            color: #495057;
            border: 2px solid transparent;
        }

        .btn-group .btn:hover {
            background-color: #f8f9fa;
        }

        .btn-group .btn.active {
            background: #ffda06;
            color: #212529;
            border-color: #ffda06;
            box-shadow: 0 4px 10px rgb(255 218 6 / 0.5);
        }

        table.table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.08);
        }

        table.table thead {
            background: #ffda06;
            color: #212529;
        }

        table.table thead th {
            font-weight: 700;
            border: none;
        }

        table.table tbody tr:hover {
            background-color: #fff7cc;
            color: #212529;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .list-group-item {
            border-radius: 12px;
            margin-bottom: 0.5rem;
            box-shadow: 0 5px 12px rgb(0 0 0 / 0.05);
            transition: background-color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #fffae6;
            color: #212529;
            cursor: pointer;
        }

        .payment-chart-legend span.badge {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 8px;
            vertical-align: middle;
        }

        @media (max-width: 767.98px) {
            .btn-group {
                justify-content: center;
                display: flex;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <?php $this->load->view('include/sidebar'); ?>

        <div class="main">
            <?php $this->load->view('include/navbar'); ?>

            <div class="container-fluid p-4">
                <div class="row g-4">
                    <!-- Stat Cards -->
                    <div class="container-fluid p-4">
                        <div class="row g-4">
                            <!-- Stat Cards -->
                            <!-- application/views/Admin/AdminDashboard.php -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card p-3">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="stat-label">TOTAL REVENUE</h6>
                                            <h3 class="stat-number">₹<?php echo number_format($total_revenue, 2); ?></h3>
                                        </div>
                                        <i class="bi bi-currency-rupee fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card p-3">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="stat-label">TOTAL STOCK</h6>
                                            <h3 class="stat-number"><?php echo $total_stock_quantity; ?> items</h3>

                                        </div>
                                        <i class="bi bi-graph-up-arrow fs-1 text-info"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card p-3">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="stat-label">TOTAL STOCK VALUE</h6>
                                            <h3 class="stat-number">₹<?php echo number_format($total_stock_value, 2); ?></h3>

                                        </div>
                                        <i class="bi bi-graph-up-arrow fs-1 text-info"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- application/views/Admin/AdminDashboard.php -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card p-3">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="stat-label">DEPOSIT</h6>
                                            <h3 class="stat-number">₹<?php echo number_format($total_deposits, 2); ?></h3>
                                        </div>
                                        <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-5">
                                <!-- Revenue Analytics -->
                                <div class="col-lg-8 col-md-12 mb-4 mb-lg-0">
                                    <div class="card h-100" style="height: 400px;">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Revenue Analytics</h5>
                                        </div>
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <canvas id="revenueChart" style="max-height: 200px; width: 100%;"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Methods -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card h-100" style="height: 400px;">
                                        <div class="card-header">
                                            <h5 class="mb-0">Payment Methods</h5>
                                        </div>
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <canvas id="paymentChart" style="max-height: 200px; width: 100%;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="row">
                                    <!-- Product-wise Sales -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h4 class="mb-0">Product-wise Sales</h4>
                                                <input type="text" id="searchBox" class="form-control w-50" placeholder="Search...">
                                            </div>

                                            <div class="card-body">
                                                <table class="table table-bordered" id="salesTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Product</th>
                                                            <th>MRP</th>
                                                            <th>Rent</th>
                                                            <th>Items Sold</th>
                                                            <th>Revenue</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($sales as $s): ?>
                                                            <tr>
                                                                <td><?= $s->category_name ?></td>
                                                                <td><?= $s->item_name ?></td>
                                                                <td><?= $s->mrp ?></td>
                                                                <td>₹<?= $s->price ?></td>
                                                                <td><?= $s->items_rented ?></td>
                                                                <td>₹<?= number_format($s->revenue ?? 0, 2) ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Recent Transactions</h5>
                                                <a href="<?= base_url('AdminController/BillHistory') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="list-group list-group-flush">
                                                    <?php if (!empty($recent_transactions)) : ?>
                                                        <?php foreach ($recent_transactions as $tx) : ?>
                                                            <a href="#" class="list-group-item list-group-item-action">
                                                                <div class="d-flex w-100 justify-content-between">
                                                                    <h6 class="mb-1"><?= $tx->invoice_no ?></h6>
                                                                    <?php if ($tx->due_amount > 0): ?>
                                                                        <small class="text-warning">₹<?= number_format($tx->due_amount, 2) ?> (Pending)</small>
                                                                    <?php else: ?>
                                                                        <small class="text-success">₹<?= number_format($tx->paid_amount, 2) ?></small>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <small class="text-muted">
                                                                    <?= ucfirst($tx->payment_mode) ?> - <?= date('d M Y', strtotime($tx->invoice_date)) ?>
                                                                </small>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <p class="p-3 text-muted">No recent transactions found</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById("searchBox").addEventListener("keyup", function() {
                                            let input = this.value.toLowerCase(); // get typed text
                                            let rows = document.querySelectorAll("#salesTable tbody tr");

                                            rows.forEach(row => {
                                                let category = row.cells[0].textContent.toLowerCase();
                                                let product = row.cells[1].textContent.toLowerCase();

                                                // show row if input matches category OR product (or empty = show all)
                                                if (category.includes(input) || product.includes(input)) {
                                                    row.style.display = "";
                                                } else {
                                                    row.style.display = "none";
                                                }
                                            });
                                        });
                                    </script>


                                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Revenue Chart
                                            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                                            const revenueChart = new Chart(revenueCtx, {
                                                type: 'line',
                                                data: {
                                                    labels: <?php echo json_encode($revenue_analytics['labels']); ?>,
                                                    datasets: [{
                                                        label: 'Daily Revenue',
                                                        data: <?php echo json_encode($revenue_analytics['datasets']['total_revenue']); ?>,
                                                        borderColor: '#ffda06',
                                                        backgroundColor: 'rgba(255, 218, 6, 0.15)',
                                                        tension: 0.3,
                                                        fill: true,
                                                        pointRadius: 4,
                                                        pointHoverRadius: 6,
                                                        borderWidth: 3
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    plugins: {
                                                        legend: {
                                                            position: 'top',
                                                            labels: {
                                                                font: {
                                                                    weight: '600'
                                                                }
                                                            }
                                                        },
                                                        tooltip: {
                                                            callbacks: {
                                                                label: ctx => `Revenue: ₹${ctx.raw.toLocaleString('en-IN')}`
                                                            },
                                                            backgroundColor: 'rgba(0,0,0,0.75)',
                                                            titleFont: {
                                                                weight: '700'
                                                            },
                                                            bodyFont: {
                                                                weight: '500'
                                                            }
                                                        }
                                                    },
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            ticks: {
                                                                callback: val => '₹' + val.toLocaleString('en-IN'),
                                                                font: {
                                                                    weight: '600'
                                                                }
                                                            },
                                                            grid: {
                                                                color: '#e9ecef'
                                                            }
                                                        },
                                                        x: {
                                                            ticks: {
                                                                font: {
                                                                    weight: '600'
                                                                }
                                                            },
                                                            grid: {
                                                                display: false
                                                            }
                                                        }
                                                    }
                                                }
                                            });

                                            // Payment Chart
                                            // Payment Chart
                                            const paymentCtx = document.getElementById('paymentChart').getContext('2d');
                                            const paymentChart = new Chart(paymentCtx, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: <?php echo json_encode($payment_stats['labels']); ?>,
                                                    datasets: [{
                                                        data: <?php echo json_encode($payment_stats['amounts']); ?>,
                                                        backgroundColor: ['#f3ac29', '#8d6213'],
                                                        borderWidth: 0
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    cutout: '70%',
                                                    plugins: {
                                                        legend: {
                                                            position: 'bottom',
                                                            labels: {
                                                                font: {
                                                                    weight: '600',
                                                                    size: 14
                                                                }
                                                            }
                                                        },
                                                        tooltip: {
                                                            callbacks: {
                                                                label: ctx => {
                                                                    const label = ctx.label || '';
                                                                    const value = ctx.raw || 0;
                                                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                                                    const percent = Math.round((value / total) * 100);
                                                                    return `${label}: ₹${value.toLocaleString('en-IN')} (${percent}%)`;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
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

                                    <?php if ($this->session->flashdata('login_success')) : ?>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', () => {
                                                Swal.fire({
                                                    title: "Login Successful!",
                                                    text: "<?= $this->session->flashdata('login_success') ?>",
                                                    icon: "success",
                                                    showConfirmButton: false,
                                                    timer: 2000
                                                });
                                            });
                                        </script>
                                    <?php endif; ?>
</body>

</html>