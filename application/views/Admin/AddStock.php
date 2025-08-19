<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Stock</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
   <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>

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

.image-preview {
  position: relative;
  max-height: 300px;
  overflow: hidden;
  border: 2px solid #ddd;
}

.image-preview img {
  width: 100%;
  object-fit: cover;
  border-radius: 10px;
}

.overlay-label {
  position: absolute;
  top: 10px;
  left: 10px;
  background-color: rgba(0,0,0,0.6);
  color: white;
  padding: 6px 12px;
  border-radius: 5px;
  font-size: 13px;
  display: none;
}

.view-details-btn {
  position: absolute;
  bottom: 10px;
  right: 10px;
  font-size: 12px;
}


    body {
      background: #f7f6fb;
    }

    .main-content {
      transition: all 0.3s ease;
      margin-left: 250px;
    }

    .wrapper.sidebar-collapsed .main-content {
      margin-left: 70px;
    }

    @media (max-width: 991.98px) {
      .main-content {
        margin-left: 0 !important;
      }
       .wrapper.sidebar-collapsed .main-content {
      margin-left: 170px;
    }
    }

    @media (max-width: 576px) {
      .chart-card, .stat-card {
        padding: 15px;
      }

      .main-content {
        padding: 1rem !important;
      }

      canvas {
        max-width: 100%;
        height: auto;
      }

      .d-flex.justify-content-between.align-items-center.mb-2 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
      }
        .wrapper.sidebar-collapsed .main-content {
      margin-left: 170px;
    }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
<?php $this->load->view('include/Sidebar'); ?>
    <div class="wrapper sidebar-expanded" id="dashboardWrapper">
        <div class="main-content p-4" id="mainContent">
            <!-- Navbar Include -->
            <?php $this->load->view('include/Navbar'); ?>
            <div class="container-fluid">
       <div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="fw-bold">Stock Overview</h4>
  <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addStockModal">
    <i class="bi bi-plus-circle"></i> Add Stock
  </button>
</div>

<div class="row g-4">
  <?php foreach($stock_items as $item): ?>
    <div class="col-md-4 col-sm-6">
      <div class="card shadow-sm h-100">
        <div class="position-relative">
          <img src="<?= base_url('uploads/products/'.$item->image); ?>" class="card-img-top img-fluid fixed-image" alt="<?= $item->name ?>">
          <span class="badge position-absolute top-0 start-0 m-2 px-3 py-2 
            <?= $item->status === 'Available' ? 'bg-success' : ($item->status === 'On Rent' ? 'bg-warning text-dark' : 'bg-info') ?>">
            <?= $item->status ?>
          </span>
        </div>
        <div class="card-body">
          <h6 class="card-title mb-1"><?= $item->product_name ?></h6>
          <p class="text-muted small mb-2"><?= $item->category ?> | ID: <?= $item->product_id ?></p>
          <div class="fw-bold">₹ <?= number_format($item->price, 2) ?></div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
