<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Billing Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->load->view('CommonLinks'); ?>
  <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .card-header {
      background-color: #000;
      color: #FFD27F;
    }

    .report-header h2 {
      font-weight: 700;
      color: #B37B16;
    }

    .stat-box {
      background: #fff;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      transition: 0.3s;
    }

    .stat-box:hover {
      transform: translateY(-5px);
    }

    .stat-label {
      font-weight: 600;
      color: #a86d01;
    }

    .stat-value {
      font-size: 1.8rem;
      color: #000;
    }

    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
      color: #333;
    }

    .card-header {
      background: linear-gradient(90deg, #b37b16, #ffd27f);
      color: #fff;
      font-weight: 600;
      letter-spacing: 0.5px;
      border: none;
    }

    .report-header h2 {
      font-weight: 800;
      color: #b37b16;
      letter-spacing: 1px;
    }

    .stat-box {
      background: #fff;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .stat-box:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .stat-label {
      font-weight: 600;
      font-size: 0.95rem;
      color: #b37b16;
      margin-bottom: 8px;
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      color: #212529;
    }

    small {
      color: #666;
      font-size: 0.85rem;
    }

    form input[type="date"] {
      border-radius: 8px;
      border: 1px solid #ccc;
      padding: 8px 12px;
    }

    form button {
      border-radius: 8px;
      background-color: #b37b16;
      border: none;
    }

    form button:hover {
      background-color: #a06e12;
    }

    .card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
    }

    .card-body {
      background: #fff;
    }

    /* Responsive styles for the report content */
    @media (max-width: 992px) {
      .stat-value {
        font-size: 1.6rem;
      }
      
      .stat-box {
        padding: 15px;
      }
    }

    @media (max-width: 768px) {
      .report-header h2 {
        font-size: 1.5rem;
      }
      
      .stat-value {
        font-size: 1.4rem;
      }
      
      .stat-label {
        font-size: 0.85rem;
      }
      
      .stat-box {
        margin-bottom: 15px;
        padding: 12px;
      }
      
      .card-header {
        font-size: 0.9rem;
        padding: 10px 15px;
      }
      
      form .col-md-4 {
        margin-bottom: 10px;
      }
      
      form .col-md-2 {
        margin-bottom: 15px;
      }
    }

    @media (max-width: 576px) {
      .report-header h2 {
        font-size: 1.3rem;
      }
      
      .stat-value {
        font-size: 1.2rem;
      }
      
      .stat-box {
        padding: 10px;
      }
      
      .text-muted {
        font-size: 0.9rem;
      }
      
      .container-fluid.p-4 {
        padding: 1rem !important;
      }
      
      .container.my-5 {
        margin-top: 2rem !important;
        margin-bottom: 2rem !important;
      }
    }

    /* Ensure proper spacing on mobile */
    @media (max-width: 400px) {
      .report-header h2 {
        font-size: 1.2rem;
      }
      
      .stat-value {
        font-size: 1.1rem;
      }
      
      small {
        font-size: 0.75rem;
      }
      
      form input[type="date"] {
        padding: 6px 8px;
        font-size: 0.9rem;
      }
      
      form button {
        padding: 6px 12px;
        font-size: 0.9rem;
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
        <!-- In your daily_sales_report.php view file -->
        <div class="container-fluid p-4">
          <div class="container my-5">
            <!-- Report Header -->
            <div class="text-center mb-5 report-header">
              <h2 class="text-uppercase">Daily Sales Report</h2>
              <p class="text-muted"><?= date('F j, Y', strtotime($report_date)) ?></p>

              <!-- Date selector form -->
              <form method="get" action="" class="mb-4">
                <input type="hidden" name="page" value="DailyReport">
                <div class="row justify-content-center">
                  <div class="col-md-4 col-sm-6 col-8">
                    <input type="date" name="date" class="form-control" value="<?= $report_date ?>">
                  </div>
                  <div class="col-md-2 col-sm-4 col-4">
                    <button type="submit" class="btn btn-primary w-100">View Report</button>
                  </div>
                </div>
              </form>
            </div>

            <div class="row text-center mb-4 align-items-stretch">
              <div class="col-lg-4 col-md-6 mb-3 d-flex">
                <div class="stat-box w-100 h-100">
                  <p class="stat-label mb-1">Total Orders</p>
                  <div class="stat-value"><?= $report['total_orders'] ?></div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-3 d-flex">
                <div class="stat-box w-100 h-100">
                  <p class="stat-label mb-1">Total Sales</p>
                  <div class="stat-value">₹ <?= number_format($report['total_sales'], 2) ?></div>
                </div>
              </div>
              <div class="col-lg-4 col-md-12 mb-3 d-flex">
                <div class="stat-box w-100 h-100">
                  <p class="stat-label mb-1">Top Product</p>
                  <div class="stat-value">
                    <?= $report['top_product']['item_name'] ?>
                  </div>
                  <small>Qty: <?= $report['top_product']['total_qty'] ?> |
                    Sales: ₹<?= number_format($report['top_product']['total_sales'], 2) ?></small>
                </div>
              </div>
            </div>

          </div>

          <!-- Chart -->
          <div class="card shadow-sm">
            <div class="card-header">
              Hourly Sales
            </div>
            <div class="card-body">
              <canvas id="hourlySalesChart" height="100"></canvas>
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

        // Hourly Sales Chart
        const ctx = document.getElementById('hourlySalesChart').getContext('2d');
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: <?= json_encode($report['hourly_sales']['hours']) ?>,
            datasets: [{
              label: 'Sales (₹)',
              data: <?= json_encode($report['hourly_sales']['sales']) ?>,
              borderColor: '#B37B16',
              backgroundColor: 'rgba(179, 123, 22, 0.2)',
              fill: true,
              tension: 0.4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'top'
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Amount (₹)'
                }
              },
              x: {
                title: {
                  display: true,
                  text: 'Time of Day'
                }
              }
            }
          }
        });
        
        // Make chart responsive by adjusting container height on resize
        function adjustChartHeight() {
          const chartContainer = document.getElementById('hourlySalesChart').parentElement;
          if (window.innerWidth < 768) {
            chartContainer.style.height = '300px';
          } else {
            chartContainer.style.height = 'auto';
          }
        }
        
        // Initial adjustment
        adjustChartHeight();
        
        // Adjust on window resize
        window.addEventListener('resize', adjustChartHeight);
      </script>
</body>

</html>