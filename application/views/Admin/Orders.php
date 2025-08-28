<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->load->view('CommonLinks'); ?>
  <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }

    .golden-btn {
      background: linear-gradient(90deg, #B37B16, #FFD27F, #B37B16);
      color: #000;
      font-weight: 600;
    }

    .golden-btn:hover {
      background: linear-gradient(90deg, #e2a93e, #f7c872, #e1aa46);
      color: #000;
    }

    .form-control,
    .form-select {
      border: 1px solid #D4AF37;
    }

    .modal-title {
      color: #D4AF37;
    }

    .table img {
      width: 80px;
      border-radius: 8px;
    }

    .badge {
      font-size: 0.8rem;
    }

    .category-option {
      cursor: pointer;
      padding: 6px 12px;
      border-bottom: 2px solid transparent;
      color: #333;
      font-weight: 500;
    }

    .category-option:hover {
      color: #000;
    }

    .category-option.active {
      border-bottom: 2px solid #000;
      color: #000;
    }
    
    /* Status badges */
    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
    }
    
    .status-available {
      background-color: #d4edda;
      color: #155724;
    }
    
    .status-rented {
      background-color: #d1ecf1;
      color: #0c5460;
    }
    
    .status-dryclean {
      background-color: #fff3cd;
      color: #856404;
    }
    
    .status-returned {
      background-color: #d6d8d9;
      color: #383d41;
    }
    
    .status-overdue {
      background-color: #f8d7da;
      color: #721c24;
    }
    
    /* Action buttons */
    .btn-action {
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem;
      margin: 2px;
    }
    
    /* Table improvements */
    .table th {
      background-color: #343a40;
      color: white;
      font-weight: 600;
    }
    
    .table-hover tbody tr:hover {
      background-color: rgba(212, 175, 55, 0.1);
    }
    
    /* Highlighting styles */
    .highlight-today {
      background-color: rgba(220, 53, 69, 0.2) !important; /* Red for today */
    }
    
    .highlight-tomorrow {
      background-color: rgba(255, 193, 7, 0.3) !important; /* Yellow for tomorrow */
    }
    
    .highlight-available {
      background-color: rgba(40, 167, 69, 0.15) !important; /* Green for available */
    }
    
    .highlight-overdue {
      background-color: rgba(220, 53, 69, 0.1) !important; /* Light red for overdue */
    }

    /* ====== Responsive Table (Mobile Only) ====== */
    @media (max-width: 768px) {
      table thead {
        display: none;
        /* Hide header */
      }

      table,
      table tbody,
      table tr,
      table td {
        display: block;
        width: 100%;
      }

      table tbody tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fff;
        padding: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      }

      table tbody td {
        text-align: right;
        padding: 10px;
        font-size: 14px;
        border: none !important;
        border-bottom: 1px solid #eee;
        position: relative;
      }

      table tbody td:last-child {
        border-bottom: none;
      }

      table tbody td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 50%;
        font-weight: bold;
        text-align: left;
        color: #444;
      }
      
      .btn-action {
        width: 100%;
        margin-bottom: 5px;
      }
      
      .status-badge {
        display: inline-block;
        margin-bottom: 5px;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Rental Orders</h2>
          <button class="btn golden-btn" data-bs-toggle="modal" data-bs-target="#reminderModal">
            View Reminders
          </button>
        </div>

        <!-- Search and Filter Section -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-3 mb-md-0">
                <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control"
                  placeholder="Search by customer, product, or status...">
              </div>
              <div class="col-md-6">
                <div class="d-flex gap-3 flex-wrap">
                  <span class="category-option active" onclick="filterCategory('all')">All</span>
                  <?php 
                  // Extract categories from orders if not provided
                  $categories = isset($categories) ? $categories : [];
                  if (empty($categories) && !empty($orders)) {
                    $categories = array();
                    foreach ($orders as $order) {
                      if (!empty($order['category']) && !in_array($order['category'], $categories)) {
                        $categories[] = $order['category'];
                      }
                    }
                  }
                  
                  if (!empty($categories)): 
                    foreach ($categories as $cat): ?>
                      <span class="category-option" onclick="filterCategory('<?= $cat ?>')"><?= $cat ?></span>
                  <?php endforeach; endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Orders Table -->
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle mt-3" id="ordersTableContainer">
            <thead class="table-dark">
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Mobile</th>
                <th>Product</th>
                <th>Category</th>
                <th>Qty</th>
                <th>Issue Date</th>
                <th>Return Date</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              // Initialize variables
              $today = isset($today) ? $today : new DateTime();
              $tomorrow = clone $today;
              $tomorrow->modify('+1 day');
              $reminderCustomers = isset($reminderCustomers) ? $reminderCustomers : [];
              
              if (!empty($orders)) : ?>
                <?php foreach ($orders as $order) :
                  $highlight = "";
                  $statusClass = "";
                  $statusText = $order['status'];
                  
                  // Check if return date is valid and not empty
                  $isValidReturnDate = (!empty($order['return_date']) && $order['return_date'] != "0000-00-00");
                  
                  // Highlight available items in green
                  if ($order['status'] == 'Available') {
                    $highlight = "highlight-available";
                  }
                  // Check for due dates if rented
                  elseif ($order['status'] == "Rented" && $isValidReturnDate) {
                    try {
                      $returnDate = new DateTime($order['return_date']);
                      
                      // Check if return date is today (red)
                      if ($returnDate->format('Y-m-d') == $today->format('Y-m-d')) {
                        $highlight = "highlight-today";
                        $statusClass = "status-overdue";
                        $statusText = "Due Today";
                        $reminderCustomers[] = $order['customer_name'];
                      } 
                      // Check if return date is tomorrow (yellow)
                      elseif ($returnDate->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
                        $highlight = "highlight-tomorrow";
                        $statusClass = "status-rented";
                        $statusText = "Due Tomorrow";
                        $reminderCustomers[] = $order['customer_name'];
                      }
                      // Check if return date is in the past (overdue)
                      elseif ($returnDate < $today) {
                        $highlight = "highlight-overdue";
                        $statusClass = "status-overdue";
                        $statusText = "Overdue";
                        $reminderCustomers[] = $order['customer_name'];
                      }
                    } catch (Exception $e) {
                      // Handle invalid date format
                      $highlight = "";
                    }
                  } else {
                    switch($order['status']) {
                      case 'Available': $statusClass = 'status-available'; break;
                      case 'Rented': $statusClass = 'status-rented'; break;
                      case 'Dry Clean': $statusClass = 'status-dryclean'; break;
                      case 'Returned': $statusClass = 'status-returned'; break;
                      default: $statusClass = 'status-available';
                    }
                  }
                ?>
                  <tr class="<?= $highlight ?>">
                    <td data-label="Order ID"><?= $order['invoice_id'] ?></td>
                    <td data-label="Customer"><?= $order['customer_name'] ?></td>
                    <td data-label="Mobile"><?= $order['customer_mobile'] ?></td>
                    <td data-label="Product"><?= $order['item_name'] ?></td>
                    <td data-label="Category"><?= $order['main_category'] ?></td>
                    <td data-label="Qty"><?= $order['quantity'] ?></td>
                    <td data-label="Issue Date"><?= $order['invoice_date'] ?></td>
                    <td data-label="Return Date"><?= $isValidReturnDate ? $order['return_date'] : 'N/A' ?></td>
                    <td data-label="Price">₹<?= $order['price'] ?></td>
                    <td data-label="Status">
                      <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                    </td>
                    <td data-label="Actions">
                      <?php if ($order['status'] == 'Returned' && $order['main_category'] == 'Cloths'): ?>
                        <div class="d-flex flex-wrap">
                          <button class="btn btn-warning btn-sm btn-action" 
                                  onclick="forwardToDryClean('<?= $order['invoice_id'] ?>')">
                            Dry Clean
                          </button>
                          <button class="btn btn-info btn-sm btn-action" 
                                  onclick="forwardToTailor('<?= $order['invoice_id'] ?>')">
                            Tailor
                          </button>
                        </div>
                      <?php elseif ($order['status'] == 'Returned' && $order['main_category'] != 'Cloths'): ?>
                        <button class="btn btn-success btn-sm btn-action" 
                                onclick="addToStock('<?= $order['invoice_id'] ?>', '<?= $order['item_name'] ?>')">
                          Add to Stock
                        </button>
                      <?php else: ?>
                        <select name="status" class="form-select form-select-sm" 
                                onchange="updateStatus(this.value, '<?= $order['invoice_id'] ?>', '<?= $order['item_name'] ?>')">
                          <option value="Available" <?= ($order['status'] == 'Available') ? 'selected' : '' ?>>Available</option>
                          <option value="Rented" <?= ($order['status'] == 'Rented') ? 'selected' : '' ?>>Rented</option>
                          <option value="Dry Clean" <?= ($order['status'] == 'Dry Clean') ? 'selected' : '' ?>>Dry Clean</option>
                          <option value="Returned" <?= ($order['status'] == 'Returned') ? 'selected' : '' ?>>Returned</option>
                        </select>
                      <?php endif; ?>
                      
                      <div class="mt-2 d-flex flex-wrap">
                        <button class="btn btn-primary btn-sm btn-action">Edit</button>
                        <button class="btn btn-danger btn-sm btn-action">Delete</button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="11" class="text-center py-4">No Orders Found</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <nav>
          <ul class="pagination justify-content-center" id="ordersPagination"></ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- Reminder Modal -->
  <div class="modal fade" id="reminderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reminders ⚠️</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php if (!empty($reminderCustomers)): ?>
            <p class="fw-bold">These customers have items due soon or overdue:</p>
            <ul>
              <?php foreach(array_unique($reminderCustomers) as $customer): ?>
                <li><?= $customer ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p>No reminders at this time.</p>
          <?php endif; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function addToStock(invoiceId, itemName) {
      fetch("<?= base_url('updateOrderStatus') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "invoice_id=" + invoiceId + "&item_name=" + encodeURIComponent(itemName) + "&status=Available"
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Stock Updated!',
                text: 'Item moved back to stock.',
                timer: 1500,
                showConfirmButton: false
              })
              .then(() => location.reload());
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Failed!',
              text: data.msg || 'Something went wrong.'
            });
          }
        })
        .catch(err => console.error(err));
    }

    function updateStatus(newStatus, invoiceId, itemName) {
      fetch("<?= base_url('updateOrderStatus') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "invoice_id=" + invoiceId + "&item_name=" + encodeURIComponent(itemName) + "&status=" + newStatus
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Updated!',
              text: 'Order status updated successfully',
              timer: 1500,
              showConfirmButton: false
            }).then(() => location.reload());
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Failed!',
              text: data.msg || 'Something went wrong.'
            });
          }
        })
        .catch(err => console.error(err));
    }

    function forwardToDryClean(invoiceId) {
      window.location.href = "<?= base_url('AdminController/DryCleaning_Forward/') ?>" + invoiceId;
    }

    function forwardToTailor(invoiceId) {
      fetch("<?= base_url('AdminController/ForwardToTailor/') ?>" + invoiceId, {
          method: "POST",
      })
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              Swal.fire({
                  icon: 'success',
                  title: 'Sent!',
                  text: 'Item forwarded to Tailor.',
                  timer: 1500,
                  showConfirmButton: false
              }).then(() => location.reload());
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Failed!',
                  text: data.msg || 'Something went wrong.'
              });
          }
      })
      .catch(err => console.error(err));
    }

    // Filters
    let selectedCategory = "all";

    function filterTable() {
      let input = document.getElementById("searchInput");
      let filter = input.value.toLowerCase();
      let rows = document.querySelectorAll("#ordersTableContainer tbody tr");

      rows.forEach(row => {
        let rowText = row.textContent.toLowerCase();
        let cellCategory = row.cells[4].textContent.trim(); // Category is in 5th cell (index 4)

        let matchesSearch = rowText.includes(filter);
        let matchesCategory = (selectedCategory === "all" || cellCategory === selectedCategory);

        row.style.display = (matchesSearch && matchesCategory) ? "" : "none";
      });
    }

    function filterCategory(category) {
      selectedCategory = category;
      filterTable();
      document.querySelectorAll(".category-option").forEach(el => el.classList.remove("active"));
      event.target.classList.add("active");
    }

    // Auto-show reminder modal if there are reminders
    document.addEventListener("DOMContentLoaded", function() {
      <?php if (!empty($reminderCustomers)): ?>
        // Show the reminder modal automatically
        var reminderModal = new bootstrap.Modal(document.getElementById('reminderModal'));
        reminderModal.show();
      <?php endif; ?>
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar toggler
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