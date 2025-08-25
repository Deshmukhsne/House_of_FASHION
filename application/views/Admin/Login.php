<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      height: 100vh;
      display: flex;
      background: linear-gradient(90deg, #f9d083 0%, #dbcfb7 100%);
    }

    .container {
      display: flex;
      width: 100%;
    }

    .left {
      width: 40%;
      display: flex;
      justify-content: center;
      align-items: center;
      background: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(20px);
      border-radius: 10px;
      padding: 40px;
      margin: 20px;
    }

    .form-wrapper {
      width: 100%;
      max-width: 320px;
    }

    .right {
      width: 60%;
      position: relative;
      overflow: hidden;
      margin-top: 20px;
      margin-bottom: 30px;
      border-top-left-radius: 10px;
      border-radius: 10px;
    }

    .slider {
      width: 100%;
      height: 100%;
      display: flex;
      animation: slide 15s linear infinite;
    }

    .slider img {
      width: 100%;
      object-fit: cover;
    }

    @keyframes slide {

      0%,
      100% {
        transform: translateX(0%);
      }

      100% {
        transform: translateX(-100%);
      }
    }

    .company-info {
      position: absolute;
      bottom: 40px;
      left: 40px;
      background: rgba(0, 0, 0, 0.5);
      padding: 20px;
      border-radius: 12px;
      color: white;
      max-width: 300px;
    }

    .company-logo {
      max-width: 100px;
      margin-bottom: 10px;
    }

    h1 {
      font-weight: 600;
      font-size: 26px;
      margin-bottom: 8px;
    }

    .left {
      display: flex;
      justify-content: center;
      align-items: center;
      height: auto;
      padding: 30px;
    }

    .form-wrapper.content {
      text-align: center;
    }

    .subtext {
      margin-bottom: 25px;
      color: #444;
      font-size: 13px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      font-size: 13px;
    }

    input,
    select {
      width: 100%;
      padding: 10px 14px;
      margin-bottom: 16px;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(8px);
      outline: none;
    }

    .submit {
      background: linear-gradient(90deg, #B37B16 0%, #FFD27F 50%, #B37B16 100%);
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 10px;
      font-size: 15px;
      cursor: pointer;
      font-weight: 600;
      margin-top: 10px;
    }

    .providers {
      display: flex;
      gap: 10px;
      margin-top: 16px;
    }

    .provider-btn {
      border: 1px solid #ccc;
      padding: 8px 16px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 500;
      background: #fff;
      font-size: 13px;
    }

    /* 📱 Mobile View Only */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .left,
      .right {
        width: 100% !important;
        margin: 10px 0;
      }

      .slider {
        flex-direction: column;
        animation: none;
      }

      .slider img {
        width: 100%;
        height: auto;
      }

      .company-info {
        position: relative;
        bottom: auto;
        left: auto;
        margin: 20px;
        background: rgba(0, 0, 0, 0.5);
      }
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <div class="container">

    <div class="left">
      <div class="form-wrapper content">
        <img src="<?php echo base_url('assets/images/favicon.png');  ?>" alt="Company Logo" class="company-logo">

        <h1>Login</h1>
        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger text-center mt-2">
            <?= $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('AdminController/AfterLogin') ?>" method="post">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>

          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>

          <button type="submit" class="submit">Submit</button>
        </form>
      </div>
    </div>

    <div class="right">
      <div class="slider">
        
        <img src="https://i.pinimg.com/736x/49/fe/5f/49fe5f62f3825eb1dbfe3021206c73e4.jpg" alt="Slide 1">
        <img src="https://i.pinimg.com/1200x/ac/66/04/ac6604a21d0b088908435b89f5ce09c4.jpg" alt="Slide 2">
        <img src="https://i.pinimg.com/736x/e9/a2/cd/e9a2cd2a9546e12268c988633da8aa96.jpg" alt="Slide 3">
        <img src="https://i.pinimg.com/736x/c3/b1/72/c3b1723db547ae91a3c3cb8f26b66142.jpg" alt="Slide 4">
      </div>
      <div class="company-info">
        <img src="<?php echo base_url('assets/images/favicon.png'); ?>" style="height:70px" ; alt="Company Logo" class="company-logo">
        <h3>House of Fashion</h3>
        <p>Empowering teams with modern tools to collaborate, plan and succeed together.</p>
      </div>
    </div>

  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {


      <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: '<?= $this->session->flashdata('error'); ?>',
          timer: 2500,
          timerProgressBar: true,
          showConfirmButton: false
        });
      <?php endif; ?>
    });
  </script>

</body>

</html>