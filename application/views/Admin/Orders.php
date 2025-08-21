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
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
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
      background: linear-gradient(90deg, #e2a93eff, #f7c872ff, #e1aa46ff);
      color: #000;
    }
    .form-control, .form-select {
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
    </div>

  <!-- Search Filter -->
<div class="mb-3">
  <input type="text" id="searchInput" onkeyup="filterTable()" 
         class="form-control" 
         placeholder="Search by customer, product, or status...">
</div>



<?php 
  $categories = array_unique(array_column($orders, 'category'));
?>
<!-- Category Filter -->
<div class="mb-3 d-flex gap-3">
  <span class="category-option active" onclick="filterCategory('all')">All</span>
  <?php foreach ($categories as $cat): ?>
    <span class="category-option" onclick="filterCategory('<?= $cat ?>')"><?= $cat ?></span>
  <?php endforeach; ?>
</div>



  <!-- Orders Table -->
  <div class="table-responsive">
  <table class="table table-bordered align-middle mt-3" id="ordersTableContainer">
    <thead class="table-dark">
      <tr>
        <th>Order Id</th>
        <th>Customer</th>
        <th>Mobile</th>
        <th>Product</th>
        <th>Main Category</th>
        <!-- <th>Image</th> -->
        <th>Quantity</th>
        <th>Issue</th>
        <th>Return</th>
        <th>Price</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($orders)) : ?>
        <?php foreach ($orders as $order) : ?>
          <tr>
            <td><?= $order['invoice_id'] ?></td>
            <td><?= $order['customer_name'] ?></td>
            <td><?= $order['customer_mobile'] ?></td>
            <td><?= $order['item_name'] ?></td>
            <td><?= $order['main_category'] ?></td>
            <!-- <td>
              <?php if (!empty($order['image'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($order['image']) ?>"
                     width="50" height="50" class="img-thumbnail"
                     style="cursor:pointer"
                     data-bs-toggle="modal"
                     data-bs-target="#imageModal"
                     onclick="showImage(this)">
              <?php else: ?>
                No Image
              <?php endif; ?>
            </td> -->
            <td><?= $order['quantity'] ?></td>
            <td><?= $order['invoice_date'] ?></td>
            <td><?= $order['return_date'] ?></td>
            <td><?= $order['price'] ?></td>
            <!-- <td><?= $order['times_rented']?></td> -->
          <td>
    <?php if ($order['status'] == 'Returned' && $order['main_category'] == 'Cloths'): ?>
        <!-- Show Dry Clean Button -->
        <button 
            class="btn btn-sm btn-warning"
            onclick="forwardToDryClean('<?= $order['invoice_id'] ?>')">
            Send to Dry Clean
        </button>

    <?php elseif ($order['status'] == 'Returned' && $order['main_category'] != 'Cloths'): ?>
        <!-- Show Add to Stock Button -->
        <button 
            class="btn btn-sm btn-success"
            onclick="addToStock('<?= $order['invoice_id'] ?>', '<?= $order['item_name'] ?>')">
            Add to Stock
        </button>

    <?php else: ?>
        <!-- Normal dropdown -->
        <select name="status" class="form-select form-select-sm"
                onchange="updateStatus(this.value, '<?= $order['invoice_id'] ?>', '<?= $order['item_name'] ?>')">
            <option value="Available" <?= ($order['status'] == 'Available') ? 'selected' : '' ?>>Available</option>
            <option value="Rented" <?= ($order['status'] == 'Rented') ? 'selected' : '' ?>>Rented</option>
            <option value="Dry Clean" <?= ($order['status'] == 'Dry Clean') ? 'selected' : '' ?>>Dry Clean</option>
            <option value="Returned" <?= ($order['status'] == 'Returned') ? 'selected' : '' ?>>Returned</option>
        </select>
    <?php endif; ?>
</td>

      <td>
              <button class="btn btn-sm btn-primary">Edit</button>
              <button class="btn btn-sm btn-danger">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="12" class="text-center">No Orders Found</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Pagination -->
<nav>
  <ul class="pagination justify-content-center" id="ordersPagination"></ul>
</nav>

<!-- Image View Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid rounded" style="max-height: 500px;">
      </div>
    </div>
  </div>
</div>

<script>
  function addToStock(invoiceId, itemName) {
    fetch("<?= base_url('updateOrderStatus') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "invoice_id=" + invoiceId + "&item_name=" + encodeURIComponent(itemName) + "&status=Available"
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({ icon: 'success', title: 'Stock Updated!', text: 'Item moved back to stock.', timer: 1500, showConfirmButton: false })
                .then(() => location.reload()); // reload to refresh table
        } else {
            Swal.fire({ icon: 'error', title: 'Failed!', text: data.msg || 'Something went wrong.' });
        }
    })
    .catch(err => console.error(err));
}

</script>
<script>
function showImage(imgElement) {
  document.getElementById('modalImage').src = imgElement.src;
}
</script>
  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
    </div>

    </div>
    </div>
    </div>

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
    <script>
      function updateStatus(newStatus, invoiceId, itemName) {
    fetch("<?= base_url('updateOrderStatus') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "invoice_id=" + invoiceId + "&item_name=" + encodeURIComponent(itemName) + "&status=" + newStatus
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({ icon: 'success', title: 'Updated!', text: 'Order status updated successfully', timer: 1500, showConfirmButton: false });
        } else {
            Swal.fire({ icon: 'error', title: 'Failed!', text: data.msg || 'Something went wrong.' });
        }
    })
    .catch(err => console.error(err));
}

  </script>
  <script>
    function filterCategory(category) {
  let rows = document.querySelectorAll("#ordersTableContainer tbody tr");
  rows.forEach(row => {
    let cellCategory = row.cells[5].textContent.trim(); // Category column
    if (category === "all" || cellCategory === category) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });

  // Highlight active category
  document.querySelectorAll(".category-option").forEach(el => el.classList.remove("active"));
  event.target.classList.add("active");
}
  </script>
<script>
    //Global filter search
    let selectedCategory = "all"; // default

// Search + Category combined filter
function filterTable() {
  let input = document.getElementById("searchInput");
  let filter = input.value.toLowerCase();
  let rows = document.querySelectorAll("#ordersTableContainer tbody tr");

  rows.forEach(row => {
    let rowText = row.textContent.toLowerCase();
    let cellCategory = row.cells[5].textContent.trim(); // category column

    // Match search text + category
    let matchesSearch = rowText.includes(filter);
    let matchesCategory = (selectedCategory === "all" || cellCategory === selectedCategory);

    if (matchesSearch && matchesCategory) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}

// Category filter
function filterCategory(category) {
  selectedCategory = category; // set global filter
  filterTable(); // re-run combined filter

  // Highlight active category
  document.querySelectorAll(".category-option").forEach(el => el.classList.remove("active"));
  event.target.classList.add("active");
}

 </script>
<script>
function forwardToDryClean(invoiceId) {
  // Redirect with invoice_id
  window.location.href = "<?= base_url('AdminController/DryCleaning_Forward/') ?>" + invoiceId;
}
</script>

<script>
function updateStatus(newStatus, invoiceId, itemName) {
    fetch("<?= base_url('updateOrderStatus') ?>", {


        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "invoice_id=" + invoiceId + "&item_name=" + encodeURIComponent(itemName) + "&status=" + newStatus
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({ icon: 'success', title: 'Updated!', text: 'Order status updated successfully', timer: 1500, showConfirmButton: false });
        } else {
            Swal.fire({ icon: 'error', title: 'Failed!', text: 'Something went wrong.' });
        }
    })
    .catch(err => console.error(err));
}
</script>


</body>

</html>







