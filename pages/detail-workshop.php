<?php
$workshop_id = $_GET['workshop_id'];
require '../controllers/function.php';
$data = getWorkshopById($workshop_id);
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
  
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/brand.css" rel="stylesheet">
  
</head>

<body>

  <?php require 'header.php'; ?>
  <?php require 'sidebar.php'; ?>

  <main id="main" class="main brand-bg-color">

    <div class="pagetitle">
      <h1 class="text-light">Tentang Kelas Ini</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Tentang Kelas Ini</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Full side columns -->
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 text-left">
                        <h5 class="card-title brand-color">Tentang Kelas Ini</h5>
                        <h5 class="brand-color">Training Overview</h5>
                        <h6><?= $data['training_overview']; ?></h6>
                        
                        <h5 class="brand-color mt-4">Kompetensi yang Dilatih</h5>
                        <h6><?= $data['trained_competencies']; ?></h6>
                        
                        <h5 class="brand-color mt-4">Sesi Pelatihan</h5>
                        <h6><?= $data['training_session']; ?></h6>
                        
                        <h5 class="brand-color mt-4">Persyaratan</h5>
                        <h6><?= $data['requirements']; ?></h6>
                        
                        <h5 class="brand-color mt-4">Manfaat</h5>
                        <h6><?= $data['benefits']; ?></h6>
                    </div>
                    <div class="col-lg-6 text-center mt-2">
                        <!-- Workshop Summary -->
                        <div class="card">
                            <div class="card-body">
                                <img src="assets/img/workshops/<?= $data['banner']; ?>" alt="Workshop Banner" class="rounded-3 img-fluid mb-3" style="max-height: 200px; object-fit: cover;">
                                <h5 class="card-title"><?= $data['title']; ?></h5>
                                <h4 class="text-primary mb-0">Rp. <?= number_format($data['price'], 0, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- Konten Detail Kelas -->
                    <div class="row mt-5">
                        <div class="col-lg-8">
                            <div class="workshop-details">
                                <div class="info-block mb-4">
                                    <h4 class="text-dark"><i class="bi bi-info-circle-fill text-primary"></i> Informasi Workshop</h4>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="bi bi-calendar-event text-success"></i> Mulai: <?= date('d F Y H:i', strtotime($data['start_date'])) ?></li>
                                                <li class="mb-2"><i class="bi bi-calendar-check text-danger"></i> Selesai: <?= date('d F Y H:i', strtotime($data['end_date'])) ?></li>
                                                <li class="mb-2"><i class="bi bi-geo-alt text-warning"></i> Lokasi: <?= $data['location'] ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="bi bi-currency-dollar text-info"></i> Harga: Rp <?= number_format($data['price'], 0, ',', '.') ?></li>
                                                <li class="mb-2"><i class="bi bi-clock-history text-primary"></i> Durasi: <?= ceil((strtotime($data['end_date']) - strtotime($data['start_date'])) / (60 * 60 * 24)) ?> hari</li>
                                                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Status: <?= ucfirst($data['status']) ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Daftar Sekarang</h5>
                                    <div class="d-grid gap-2">
                                        <?php if($data['status'] == 'active'): ?>
                                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#registerWorkshopModal">
                                                <i class="bi bi-cart-fill"></i> Beli Sekarang
                                            </button>
                                            <button class="btn btn-outline-info" type="button">
                                                <i class="bi bi-chat-text-fill"></i> Tanya Informasi
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-secondary" type="button" disabled>
                                                Workshop Tidak Tersedia
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="card-title">Share Workshop</h5>
                                    <div class="d-flex justify-content-around">
                                        <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-facebook"></i></a>
                                        <a href="#" class="btn btn-sm btn-info"><i class="bi bi-twitter"></i></a>
                                        <a href="#" class="btn btn-sm btn-success"><i class="bi bi-whatsapp"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-envelope"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
          </div>
        </div>
        <!-- Full side columns -->


      </div>
    </section>  
  </main>
  </main><!-- End #main -->

  <?php require "modals.php";?>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer brand-bg-color">
    <div class="copyright text-light">
      © Copyright <strong><span>WorkSmart</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  
  <!-- DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/autohide.js"></script>

  <!-- Initialize DataTable -->
  <script>
    $(document).ready(function() {
      $('#participantTable').DataTable({
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
          {
            extend: 'copy',
            className: 'btn btn-sm btn-primary'
          },
          {
            extend: 'excel',
            className: 'btn btn-sm btn-success'
          },
          {
            extend: 'pdf',
            className: 'btn btn-sm btn-danger'
          },
          {
            extend: 'print',
            className: 'btn btn-sm btn-info'
          }
        ],  
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records...",
          lengthMenu: "_MENU_ records per page",
          info: "Showing _START_ to _END_ of _TOTAL_ entries",
          paginate: {
            first: '<i class="bi bi-chevron-double-left"></i>',
            previous: '<i class="bi bi-chevron-left"></i>',
            next: '<i class="bi bi-chevron-right"></i>',
            last: '<i class="bi bi-chevron-double-right"></i>'
          }
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']],
        drawCallback: function() {
          $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
      });
    });
  </script>

</body>

</html>