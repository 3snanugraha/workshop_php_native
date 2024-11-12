<?php
require '../controllers/function.php';
checkAuth();
$kategori = $_GET['kategori'];
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
      <h1 class="text-light">Export Laporan <?= $kategori; ?></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Export Laporan <?= $kategori; ?></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <i class="bi bi-file-earmark-text me-2"></i>
                Export Laporan <?= ucfirst($kategori) ?>
              </h5>

              <form id="reportForm" class="row g-3">
                <div class="col-md-4">
                  <label class="form-label">Periode Awal</label>
                  <input type="date" class="form-control" id="startDate" name="start_date" required>
                </div>
                
                <div class="col-md-4">
                  <label class="form-label">Periode Akhir</label>
                  <input type="date" class="form-control" id="endDate" name="end_date" required>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Format Export</label>
                  <select class="form-select" id="exportFormat" name="format" required>
                    <option value="excel">Excel (.xlsx)</option>
                    <option value="pdf">PDF</option>
                    <option value="csv">CSV</option>
                  </select>
                </div>

                <?php if($kategori == 'peserta' || $kategori == 'mitra'): ?>
                <div class="col-md-6">
                  <label class="form-label">Status Akun</label>
                  <select class="form-select" name="account_status">
                    <option value="all">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Non-Aktif</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Urutkan Berdasarkan</label>
                  <select class="form-select" name="sort_by">
                    <option value="created_at">Tanggal Registrasi</option>
                    <option value="name">Nama</option>
                    <option value="email">Email</option>
                  </select>
                </div>
                <?php endif; ?>

                <div class="col-12">
                  <button type="submit" class="btn btn-primary brand-bg-color rounded-pill">
                    <i class="bi bi-download me-2"></i>Export Laporan
                  </button>
                  <button type="button" onclick="previewReport()" class="btn btn-secondary rounded-pill">
                    <i class="bi bi-eye me-2"></i>Preview
                  </button>
                </div>
              </form>

              <!-- Preview Area -->
              <div id="previewArea" class="mt-4" style="display:none">
                <h6 class="text-muted mb-3">Preview Laporan</h6>
                <div class="table-responsive">
                  <table class="table table-striped table-hover" id="previewTable">
                    <!-- Dynamic content will be loaded here -->
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Add this JavaScript before closing body -->
    <script>
    $(document).ready(function() {
        // Set default dates
        let today = new Date();
        let lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);
        
        $('#startDate').val(lastMonth.toISOString().split('T')[0]);
        $('#endDate').val(today.toISOString().split('T')[0]);

        $('#reportForm').on('submit', function(e) {
            e.preventDefault();
            exportReport();
        });
    });

    function exportReport() {
        let formData = new FormData(document.getElementById('reportForm'));
        formData.append('kategori', '<?= $kategori ?>');

        $.ajax({
            url: '../controllers/export_controller.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                let blob = new Blob([response]);
                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'Laporan_<?= $kategori ?>_' + new Date().toISOString().split('T')[0] + '.' + $('#exportFormat').val();
                link.click();
            }
        });
    }

    function previewReport() {
        let formData = new FormData(document.getElementById('reportForm'));
        formData.append('kategori', '<?= $kategori ?>');
        formData.append('preview', 'true');

        $.ajax({
            url: '../controllers/export_controller.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#previewArea').show();
                $('#previewTable').html(response);
            }
        });
    }
    </script>
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

</body>

</html>