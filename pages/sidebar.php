  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar brand-bg-color-secondary">

    <ul class="sidebar-nav" id="sidebar-nav">
      <?php if($_SESSION['role'] == 'admin'): ?>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="mentor.php">
            <i class="bi bi-person-video3"></i>
            <span>Mentor</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="peserta.php">
            <i class="bi bi-people"></i>
            <span>Peserta</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#laporan-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-text"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="laporan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="laporan-keuangan.php">
                <i class="bi bi-circle"></i><span>Keuangan</span>
              </a>
            </li>
            <li>
              <a href="laporan-mitra.php">
                <i class="bi bi-circle"></i><span>Mitra</span>
              </a>
            </li>
            <li>
              <a href="laporan-peserta.php">
                <i class="bi bi-circle"></i><span>Peserta</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="mitra.php">
            <i class="bi bi-building"></i>
            <span>Mitra</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="kalender.php">
            <i class="bi bi-calendar3"></i>
            <span>Kalender</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="pesan.php">
            <i class="bi bi-envelope"></i>
            <span>Pesan</span>
          </a>
        </li>

      <?php elseif($_SESSION['role'] == 'peserta'): ?>
        <!-- Menu untuk peserta -->

      <?php elseif($_SESSION['role'] == 'mitra'): ?>
        <!-- Menu untuk mitra -->

      <?php endif; ?>
    </ul>

  </aside>
  <!-- End Sidebar-->