<?php
require '../controllers/function.php';
checkAuth();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - WorkSmart</title>
  <meta content="WorkSmart" name="description">
  <meta content="WorkSmart" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo-worksmart.png" rel="icon">
  <link href="assets/img/logo-worksmart.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/brand.css" rel="stylesheet">
  
</head>

<body>

  <?php require 'header.php'; ?>
  <?php require 'sidebar.php'; ?>

  <main id="main" class="main brand-bg-color">

    <div class="pagetitle">
      <h1 class="text-light">Data Mitra</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Data Mitra</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Full side columns -->
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Mitra</h5>
              <p class="text-dark">Berikut adalah daftar mitra yang bekerja sama dengan kami.</p>
              <!-- Fetch data mitra dari db -->
              <div class="table-responsive">
                <table class="table datatable" id="mitraTable">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                 <tbody>
                  <?php
                  $users = getUsersByRole('mitra');
                  foreach($users as $user): ?>
                    <tr>
                      <td><?= $user['first_name'] ?></td>
                      <td><?= $user['last_name'] ?></td>
                      <td><?= $user['username'] ?></td>
                      <td><?= $user['email'] ?></td>
                      <td><?= $user['phone'] ?></td>
                      <td><?= $user['role'] ?></td>
                      <td class='text-center'>
                        <div class='btn-group' role='group'>
                          <button type='button' class='btn btn-sm btn-outline-warning me-1 rounded-pill' data-bs-toggle='tooltip' title='Edit'><i class='bi bi-pencil-square'></i></button>
                          <button type='button' class='btn btn-sm btn-outline-danger rounded-pill' data-bs-toggle='tooltip' title='Delete'><i class='bi bi-trash'></i></button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>                
                 </tbody>
                </table>
              </div>

            </div>
          </div>
        </div><!-- Full side columns -->


      </div>
    </section>  
  
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer brand-bg-color">
    <div class="copyright text-light">
      &copy; Copyright <strong><span>WorkSmart</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/autohide.js"></script>

  <!-- Add this JavaScript code before closing body tag -->
  <script>
    const dataTable = new simpleDatatables.DataTable("#mitraTable", {
      searchable: true,
      fixedHeight: true,
      perPage: 10,
      drawCallback: function() {
        hideLoading();
      },
      preDrawCallback: function() {
        showLoading();
      }
    });
  </script>

</body>

</html>
