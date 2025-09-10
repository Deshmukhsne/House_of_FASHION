<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monthly Sales Report</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
  <style>
    :root {
      --primary-color: #B37B16;
      --primary-dark: #966812;
      --primary-light: #FFD27F;
      --secondary-color: #6c757d;
      --light-bg: #f8f9fa;
      --white: #ffffff;
      --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background-color: var(--light-bg);
      color: #333;
      line-height: 1.6;
    }

    .main {
      width: 100%;

      transition: var(--transition);
    }

    /* Header Section */
    .report-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: var(--white);
      padding: 2rem;
      border-radius: 10px;
      margin-bottom: 2rem;
      box-shadow: var(--shadow);
      height: 100px;
      /* Fixed height */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    /* Optional decorative elements */
    .report-header::before {
      content: '';
      position: absolute;
      top: -50px;
      right: -50px;
      width: 150px;
      height: 150px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
    }

    .report-header::after {
      content: '';
      position: absolute;
      bottom: -30px;
      left: -30px;
      width: 100px;
      height: 100px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
    }

    .report-header h2 {
      font-weight: 700;
      margin-bottom: 0.5rem;
      letter-spacing: 0.5px;
      font-size: 2.2rem;
      position: relative;
      z-index: 1;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .report-header p {
      opacity: 0.9;
      font-size: 1.1rem;
      position: relative;
      z-index: 1;
      max-width: 80%;
      margin: 0 auto;
    }

    /* Form Styling */
    .report-controls {
      background: var(--white);
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: var(--shadow);
      margin-bottom: 2rem;
    }

    .form-select {
      border-radius: 8px;
      padding: 0.75rem 1rem;
      border: 1px solid #e0e0e0;
      height: auto;
      font-size: 1rem;
      transition: var(--transition);
    }

    .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(179, 123, 22, 0.25);
    }

    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      border-radius: 8px;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      transition: var(--transition);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-size: 0.9rem;
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(179, 123, 22, 0.25);
    }

    /* Stat Cards */
    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: var(--white);
      border-radius: 10px;
      padding: 2rem;
      box-shadow: var(--shadow);
      transition: var(--transition);
      border-top: 4px solid var(--primary-color);
      position: relative;
      overflow: hidden;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    }

    .stat-label {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--secondary-color);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 0.5rem;
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      color: #343a40;
      margin-bottom: 0.5rem;
    }

    /* Chart Section */
    .chart-card {
      background: var(--white);
      border-radius: 10px;
      box-shadow: var(--shadow);
      overflow: hidden;
      width: 100%;
    }

    .chart-header {
      background: var(--primary-color);
      color: var(--white);
      padding: 1.25rem 1.5rem;
      font-weight: 600;
    }

    .chart-body {
      padding: 1.5rem;
      height: 400px;
      position: relative;
      width: 100%;
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
      .stats-container {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      }
    }

    @media (max-width: 992px) {
      .main {
        padding: 1rem;
      }

      .report-header {
        height: auto;
        padding: 1.5rem;
      }

      .report-header h2 {
        font-size: 1.8rem;
      }

      .report-header p {
        font-size: 1rem;
      }

      .chart-body {
        height: 350px;
      }
    }

    @media (max-width: 768px) {
      .stats-container {
        grid-template-columns: 1fr;
      }

      .report-controls .row {
        flex-direction: column;
        gap: 1rem;
      }

      .report-controls .col-md-5,
      .report-controls .col-md-2 {
        width: 100%;
        max-width: 100%;
      }

      .stat-card {
        padding: 1.5rem;
      }

      .stat-value {
        font-size: 1.8rem;
      }

      .chart-body {
        height: 300px;
      }
    }

    @media (max-width: 576px) {
      .main {
        padding: 0.5rem;
      }

      .container.my-5 {
        margin-top: 1rem !important;
        margin-bottom: 1rem !important;
      }

      .report-header {
        padding: 1rem;
        border-radius: 8px;
      }

      .report-header h2 {
        font-size: 1.5rem;
      }

      .report-header p {
        font-size: 0.9rem;
      }

      .report-controls {
        padding: 1rem;
      }

      .stat-card {
        padding: 1.25rem;
      }

      .stat-value {
        font-size: 1.6rem;
      }

      .stat-label {
        font-size: 0.85rem;
      }

      .chart-header {
        padding: 1rem;
      }

      .chart-body {
        padding: 1rem;
        height: 250px;
      }

      .btn-primary {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
      }
    }

    /* Chart container responsiveness */
    .chart-container-wrapper {
      width: 100%;
      overflow-x: auto;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .stat-card {
      animation: fadeInUp 0.6s ease forwards;
    }

    .stat-card:nth-child(1) {
      animation-delay: 0.1s;
    }

    .stat-card:nth-child(2) {
      animation-delay: 0.2s;
    }

    .stat-card:nth-child(3) {
      animation-delay: 0.3s;
    }

    .chart-card {
      animation: fadeInUp 0.6s ease 0.4s forwards;
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
        <div class="container my-5">
          <!-- Month Selection Form -->
          <div class="report-controls">
            <form method="get" class="row g-3 align-items-center">
              <div class="col-md-5">
                <select name="month" class="form-select">
                  <?php foreach ($months as $num => $name): ?>
                    <option value="<?= $num ?>" <?= ($num == $selected_month) ? 'selected' : '' ?>>
                      <?= $name ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-5">
                <select name="year" class="form-select">
                  <?php foreach ($years as $year): ?>
                    <option value="<?= $year ?>" <?= ($year == $selected_year) ? 'selected' : '' ?>>
                      <?= $year ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Generate Report</button>
              </div>
            </form>
          </div>

          <!-- Report Header -->
          <div class="report-header text-center">
            <h2 class="text-uppercase">Monthly Sales Report</h2>
            <p><?= $months[$selected_month] ?> <?= $selected_year ?></p>
          </div>

          <!-- Stat Cards -->
          <div class="stats-container">
            <div class="stat-card">
              <p class="stat-label">Total Orders</p>
              <div class="stat-value"><?= $report['total_orders'] ?></div>
              <small class="text-muted">All completed transactions</small>
            </div>
            <div class="stat-card">
              <p class="stat-label">Total Sales</p>
              <div class="stat-value">₹<?= number_format($report['total_sales'], 2) ?></div>
              <small class="text-muted">Gross revenue this month</small>
            </div>
            <div class="stat-card">
              <p class="stat-label">Top Product</p>
              <div class="stat-value"><?= $report['top_product']['item_name'] ?></div>
              <small class="text-muted"><?= $report['top_product']['total_qty'] ?> units sold (₹<?= number_format($report['top_product']['total_sales'], 2) ?>)</small>
            </div>
          </div>

          <!-- Chart -->
          <div class="chart-card">
            <div class="chart-header">
              Daily Sales Breakdown
            </div>
            <div class="chart-body">
              <div class="chart-container-wrapper">
                <canvas id="monthlySalesChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart.js Library -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Chart Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const ctx = document.getElementById('monthlySalesChart').getContext('2d');

      // Debug output
      console.log('Chart Data:', {
        labels: <?= json_encode($report['daily_sales']['labels']) ?>,
        data: <?= json_encode($report['daily_sales']['data']) ?>
      });

      const chartData = {
        labels: <?= json_encode($report['daily_sales']['labels']) ?>,
        datasets: [{
          label: 'Daily Sales',
          data: <?= json_encode($report['daily_sales']['data']) ?>,
          backgroundColor: 'rgba(179, 123, 22, 0.6)',
          borderColor: 'rgba(179, 123, 22, 1)',
          borderWidth: 1,
          borderRadius: 4,
          hoverBackgroundColor: 'rgba(179, 123, 22, 0.8)'
        }]
      };

      const config = {
        type: 'bar',
        data: chartData,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return '₹' + context.raw.toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  });
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return '₹' + value.toLocaleString('en-IN');
                }
              }
            },
            x: {
              ticks: {
                maxRotation: 45,
                minRotation: 45
              }
            }
          }
        }
      };

      // Destroy previous chart if exists
      if (window.monthlySalesChart instanceof Chart) {
        window.monthlySalesChart.destroy();
      }

      // Create new chart
      window.monthlySalesChart = new Chart(ctx, config);

      // Adjust chart on window resize
      window.addEventListener('resize', function() {
        if (window.monthlySalesChart instanceof Chart) {
          window.monthlySalesChart.resize();
        }
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