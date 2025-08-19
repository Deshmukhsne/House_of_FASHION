<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Management</title>
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
    .action-btns button {
      margin-right: 5px;
    }
    .top-buttons {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .btn-gold {
    background: linear-gradient(90deg, #B37B16 0%, #FFD27F 100%);
    color: #000;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
  }

  .btn-gold:hover {
    background: #b37b16;
    color: white;
  }

  .table-dark {
    background-color: #B37B16 !important;
    color: white;
  }

  .alert-success {
    background-color: #D4AF37;
    color: black;
  }

  .alert-danger {
    background-color: #b37b16;
    color: white;
  }

  .action-btns .btn {
    margin-right: 5px;
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

  <div class="top-buttons mb-3">
    <div>
     <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Add Customer</button>
    </div>
    <div>
      <a href="<?= base_url('customers/export_excel') ?>" class="btn btn-gold">Export to Excel</a>
<a href="<?= base_url('customers/export_pdf') ?>" class="btn btn-gold">Export to PDF</a>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
  <?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
  <?php endif; ?>

  <form method="get" class="row g-3 mb-3">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= $search ?>">
    </div>
    
    <div class="col-md-2">
      <button class="btn btn-gold" type="submit">Filter</button>

    </div>
  </form>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Contact</th>
        
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($customers)): ?>
        <?php foreach ($customers as $customer): ?>
          <tr>
            <td><?= $customer->id ?></td>
            <td><?= $customer->name ?></td>
            <td><?= $customer->contact ?></td>
            

            <td class="action-btns">
              <button class="btn btn-gold btn-sm" ...>View</button>
              <button class="btn btn-gold btn-sm" ...>Edit</button>
              <a href="..." class="btn btn-gold btn-sm">Delete</a>
<a href="#" class="btn btn-gold btn-sm">Order</a>
            </td>
          </tr>

          <!-- View Modal -->
          <div class="modal fade" id="viewCustomerModal<?= $customer->id ?>" tabindex="-1"
               aria-labelledby="viewCustomerLabel<?= $customer->id ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Customer Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p><strong>Name:</strong> <?= $customer->name ?></p>
                  <p><strong>Contact:</strong> <?= $customer->contact ?></p>
                  
                </div>
              </div>
            </div>
          </div>

          <!-- Edit Modal -->
          <div class="modal fade" id="editCustomerModal<?= $customer->id ?>" tabindex="-1"
               aria-labelledby="editCustomerLabel<?= $customer->id ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <form action="<?= base_url('customers/edit/' . $customer->id) ?>" method="post" enctype="multipart/form-data">


                  <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  < class="modal-body">
                    <div class="mb-3">
                      <label>Name</label>
                      <input type="text" name="name" value="<?= $customer->name ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label>Contact</label>
                      <input type="text" name="contact" value="<?= $customer->contact ?>" class="form-control" required>
                    </div>
                   
                  
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" class="text-center">No customers found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <?= $pagination ?>

  <!-- Add Modal -->
  <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <form action="<?= base_url('customers/add') ?>" method="post" enctype="multipart/form-data">

          <div class="modal-header">
            <h5 class="modal-title">Add New Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label>Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Contact</label>
              <input type="text" name="contact" class="form-control" required>
            </div>
            
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

            </div>
        </div>
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
    </script>
</body>

</html>



