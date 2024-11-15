<?php 
require_once '../controllers/function.php';
$workshops = getWorkshopsWithMitra();
$isLogin = checkUserSession();
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>WorkSmart - Workshop Marketplace</title>
  <meta name="description" content="WorkSmart - Platform jual beli workshop dan pelatihan terbaik">
  <meta name="keywords" content="workshop, pelatihan, marketplace workshop, training, skill development">

  <!-- Favicons -->
  <link href="assets/img/logo-worksmart.png" rel="icon">
  <link href="assets/img/logo-worksmart.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="landingpage/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="landingpage/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="landingpage/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="landingpage/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="landingpage/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="landingpage/assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo-worksmart.png" alt="">
        <h1 class="sitename">WorkSmart</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#workshops">Workshop</a></li>
          <?php if($isLogin) { ?>
          <li class="dropdown"><a href="#"><span>Akun</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Profil Saya</a></li>
              <li><a href="#">Workshop Saya</a></li>
              <li><a href="#">Riwayat Transaksi</a></li>
              <li><a href="#">Pengaturan</a></li>
              <li><a href="#">Keluar</a></li>
            </ul>
          </li>
          <?php } ?>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <?php if ($isLogin) { ?>
        <a class="btn-getstarted" href="dashboard.php">Dashboard</a>        
      <?php } else { ?>
            <a class="btn-getstarted" href="index.php">Daftar</a>
      <?php } ?>

    </div>
  </header>  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <div class="company-badge mb-4">
                <i class="bi bi-mortarboard-fill me-2"></i>
                Belajar dan Berkembang dengan Workshop dari Para Ahli
              </div>

              <?php if($isLogin){ ?>
              <div class="welcome-badge" data-aos="fade-down" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; padding: 10px 20px; border-radius: 50px; display: inline-block; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <i class="bi bi-hand-wave-fill me-2"></i>
                Selamat datang, <?= htmlspecialchars($_SESSION['first_name']) ?>! 👋
              </div>
              <?php } ?>

              <h1 class="mb-4">
                Temukan Workshop yang <br>
                Dipimpin Ahli untuk <br>
                <span class="accent-text">Pengembangan Profesional Anda</span>
              </h1>

              <p class="mb-4 mb-md-5">
                Bergabung dengan ribuan profesional yang meningkatkan keterampilan mereka melalui workshop pilihan kami.
                Belajar dari para ahli industri, dapatkan pengetahuan praktis, dan kembangkan karir Anda.
              </p>

              <div class="hero-buttons">
                <a href="#workshops" class="btn btn-primary me-0 me-sm-2 mx-1">Jelajahi Workshop</a>
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn btn-link mt-2 mt-sm-0 glightbox">
                  <i class="bi bi-play-circle me-1"></i>
                  Lihat Cara Kerjanya
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
              <img src="landingpage/assets/img/illustration-1.webp" alt="Ilustrasi Workshop Online" class="img-fluid">

              <div class="customers-badge">
                <div class="customer-avatars">
                  <img src="landingpage/assets/img/avatar-1.webp" alt="Peserta Workshop 1" class="avatar">
                  <img src="landingpage/assets/img/avatar-2.webp" alt="Peserta Workshop 2" class="avatar">
                  <img src="landingpage/assets/img/avatar-3.webp" alt="Peserta Workshop 3" class="avatar">
                  <img src="landingpage/assets/img/avatar-4.webp" alt="Peserta Workshop 4" class="avatar">
                  <img src="landingpage/assets/img/avatar-5.webp" alt="Peserta Workshop 5" class="avatar">
                  <span class="avatar more">5K+</span>
                </div>
                <p class="mb-0 mt-2">Lebih dari 5.000 profesional telah bergabung dengan komunitas pembelajaran kami</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-mortarboard"></i>
              </div>
              <div class="stat-content">
                <h4>500+ Workshop</h4>
                <p class="mb-0">Sesi Dipimpin Ahli</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-people"></i>
              </div>
              <div class="stat-content">
                <h4>200+ Pelatih</h4>
                <p class="mb-0">Ahli Industri</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-star"></i>
              </div>
              <div class="stat-content">
                <h4>4.8/5 Rating</h4>
                <p class="mb-0">Kepuasan Peserta</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-globe"></i>
              </div>
              <div class="stat-content">
                <h4>20+ Kategori</h4>
                <p class="mb-0">Topik Beragam</p>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section>
    <!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-center justify-content-between">

          <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200">
            <span class="about-meta">TENTANG WORKSMART</span>
            <h2 class="about-title">Gerbang Menuju Pertumbuhan Profesional Anda</h2>
            <p class="about-description">WorkSmart adalah tujuan utama Anda untuk workshop dan program pelatihan profesional berkualitas tinggi. Kami menghubungkan para profesional yang ambisius dengan para ahli terkemuka industri untuk memberikan pengalaman pembelajaran transformatif yang meningkatkan pertumbuhan karir Anda.</p>

            <div class="row feature-list-wrapper">
              <div class="col-md-6">
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle-fill"></i> Workshop dipimpin ahli</li>
                  <li><i class="bi bi-check-circle-fill"></i> Sesi interaktif langsung</li>
                  <li><i class="bi bi-check-circle-fill"></i> Jadwal belajar fleksibel</li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle-fill"></i> Sertifikasi industri</li>
                  <li><i class="bi bi-check-circle-fill"></i> Proyek praktik langsung</li>
                  <li><i class="bi bi-check-circle-fill"></i> Kesempatan networking</li>
                </ul>
              </div>
            </div>

            <div class="info-wrapper">
              <div class="row gy-4">
                <div class="col-lg-5">
                  <div class="profile d-flex align-items-center gap-3">
                    <img src="landingpage/assets/img/avatar-1.webp" alt="Profil CEO" class="profile-image">
                    <div>
                      <h4 class="profile-name">Sarah Johnson</h4>
                      <p class="profile-position">Pendiri & Pelatih Utama</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="contact-info d-flex align-items-center gap-2">
                    <i class="bi bi-telephone-fill"></i>
                    <div>
                      <p class="contact-label">Informasi Workshop</p>
                      <p class="contact-number">+62 812-3456-7890</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
            <div class="image-wrapper">
              <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                <img src="landingpage/assets/img/about-5.webp" alt="Pelatihan Workshop" class="img-fluid main-image rounded-4">
                <img src="landingpage/assets/img/about-2.webp" alt="Diskusi Grup" class="img-fluid small-image rounded-4">
              </div>
              <div class="experience-badge floating">
                <h3>5+ <span>Tahun</span></h3>
                <p>Menghadirkan workshop berkualitas</p>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section>
    <!-- /About Section -->s

    <!-- Workshops Section -->
    <section id="workshops" class="workshops section">

      <!-- Section Title -->
      <div class="container section-title text-center" data-aos="fade-up">
        <span class="subtitle">Eksplorasi Workshop</span>
        <h2>Program Unggulan Kami</h2>
        <p class="lead">Tingkatkan skillset Anda melalui workshop interaktif yang dirancang khusus untuk profesional modern</p>
      </div>

      <!-- Search Bar with Animation -->
      <div class="container mb-5">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="search-wrapper glass-effect" data-aos="zoom-in">
              <div class="input-group">
                <input type="text" class="form-control search-input" placeholder="Temukan workshop impianmu..." id="workshopSearch">
                <select class="form-select custom-select" style="max-width: 180px;">
                  <option selected>Pilih Kategori</option>
                  <option>Digital Marketing</option>
                  <option>Leadership</option>
                  <option>Data Science</option>
                  <option>UI/UX Design</option>
                  <option>Business Strategy</option>
                </select>
                <button class="btn btn-primary" type="button">
                  <i class="bi bi-search"></i> Explore
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <!-- Interactive Filter Options -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="filter-buttons d-flex gap-3 flex-wrap justify-content-center" data-aos="fade-up">
              <button class="btn btn-pill active">
                <i class="bi bi-grid"></i> Semua
              </button>
              <button class="btn btn-pill">
                <i class="bi bi-star"></i> Trending
              </button>
              <button class="btn btn-pill">
                <i class="bi bi-clock"></i> Terbaru
              </button>
              <button class="btn btn-pill">
                <i class="bi bi-calendar-event"></i> Upcoming
              </button>
              <button class="btn btn-pill">
                <i class="bi bi-trophy"></i> Best Seller
              </button>
            </div>
          </div>
        </div>

        <div class="row gy-4">
          <!-- Workshop Cards with Enhanced Design -->
          <?php foreach ($workshops as $workshop): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card workshop-card hover-effect">
              <div class="card-badge">
                <span class="badge <?= $workshop['status'] === 'active' ? 'bg-success' : 'bg-danger' ?>">
                  <?= $workshop['status'] === 'active' ? 'Masih dibuka' : 'Ditutup' ?>
                </span>
              </div>
              <div class="card-image-wrapper">
                <img src="assets/img/workshops/<?= htmlspecialchars($workshop['banner']) ?>" class="card-img-top" alt="<?= htmlspecialchars($workshop['title']) ?>">
                <div class="overlay">
                  <div class="overlay-content">

                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="category-badge">
                  <span class="badge bg-soft-primary"><?= htmlspecialchars($workshop['category']) ?></span>
                </div>
                <h3 class="card-title h5"><?= htmlspecialchars($workshop['title']) ?></h3>
                <p class="card-text text-muted"><?= htmlspecialchars(substr($workshop['description'], 0, 120)) ?>...</p>
                <div class="workshop-info">
                  <div class="info-item">
                    <i class="bi bi-calendar-event"></i>
                    <span><?= date('d M Y', strtotime($workshop['start_date'])) ?></span>
                  </div>
                  <div class="info-item">
                    <i class="bi bi-geo-alt"></i>
                    <span><?= $workshop['location'] ?></span>
                  </div>
                  <div class="info-item">
                    <i class="bi bi-tag"></i>
                    <span>Rp <?= number_format($workshop['price'], 0, ',', '.') ?></span>
                  </div>
                </div>
                <div class="action-buttons mt-3">
                  <button class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#workshopModal<?= $workshop['workshop_id'] ?>">
                    <i class="bi bi-info-circle me-2"></i>Detail Workshop
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Enhanced Workshop Modal -->
          <div class="modal fade" id="workshopModal<?= $workshop['workshop_id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header gradient-bg">
                  <h5 class="modal-title text-white"><?= htmlspecialchars($workshop['title']) ?></h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="workshop-image-wrapper">
                        <img src="assets/img/workshops/<?= htmlspecialchars($workshop['banner']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($workshop['title']) ?>">
                        <div class="workshop-highlights">
                          <div class="highlight-item">
                            <i class="bi bi-people-fill"></i>
                            <span>30 Peserta</span>
                          </div>
                          <div class="highlight-item">
                            <i class="bi bi-clock-fill"></i>
                            <span>24 Jam</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="workshop-details">
                        <div class="detail-item">
                          <i class="bi bi-calendar-check-fill"></i>
                          <div>
                            <strong>Jadwal</strong>
                            <p>Mulai: <?= date('d M Y H:i', strtotime($workshop['start_date'])) ?><br>
                               Selesai: <?= date('d M Y H:i', strtotime($workshop['end_date'])) ?></p>
                          </div>
                        </div>
                        <div class="detail-item">
                          <i class="bi bi-geo-alt-fill"></i>
                          <div>
                            <strong>Lokasi</strong>
                            <p><?= htmlspecialchars($workshop['location']) ?></p>
                          </div>
                        </div>
                        <div class="detail-item">
                          <i class="bi bi-tag-fill"></i>
                          <div>
                            <strong>Investasi</strong>
                            <p>Rp <?= number_format($workshop['price'], 0, ',', '.') ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="workshop-content mt-4">
                    <div class="content-section">
                      <h5><i class="bi bi-book me-2"></i>Overview Pelatihan</h5>
                      <p><?= nl2br(htmlspecialchars($workshop['training_overview'])) ?></p>
                    </div>
                    <div class="content-section">
                      <h5><i class="bi bi-trophy me-2"></i>Kompetensi yang Dilatih</h5>
                      <p><?= nl2br(htmlspecialchars($workshop['trained_competencies'])) ?></p>
                    </div>
                    <div class="content-section">
                      <h5><i class="bi bi-calendar3 me-2"></i>Sesi Pelatihan</h5>
                      <p><?= nl2br(htmlspecialchars($workshop['training_session'])) ?></p>
                    </div>
                    <div class="content-section">
                      <h5><i class="bi bi-check-circle me-2"></i>Persyaratan</h5>
                      <p><?= nl2br(htmlspecialchars($workshop['requirements'])) ?></p>
                    </div>
                    <div class="content-section">
                      <h5><i class="bi bi-gift me-2"></i>Manfaat</h5>
                      <p><?= nl2br(htmlspecialchars($workshop['benefits'])) ?></p>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                  <?php if($isLogin): ?>
                    <a href="detail-workshop.php?workshop_id=<?= $workshop['workshop_id'] ?>" class="btn btn-primary">
                      <i class="bi bi-arrow-right-circle me-2"></i>Daftar Sekarang
                    </a>
                  <?php else: ?>
                    <a href="register.php" class="btn btn-primary">
                      <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Enhanced Pagination -->
        <nav class="mt-5" aria-label="Workshop navigation">
          <ul class="pagination pagination-rounded justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous" id="prevPage">
                <i class="bi bi-chevron-left"></i>
              </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next" id="nextPage">
                <i class="bi bi-chevron-right"></i>
              </a>
            </li>
          </ul>
        </nav>

      </div>

    </section>
    <!-- /Workshops Section -->


    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimoni</h2>
        <p>Dengarkan apa yang dikatakan peserta workshop tentang pengalaman belajar mereka dengan WorkSmart</p>
      </div>
      <!-- End Section Title -->

      <div class="container">

        <div class="row g-5">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-item">
              <img src="landingpage/assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
              <h3>John Anderson</h3>
              <h4>Manajer Pemasaran</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Workshop Pemasaran Digital melampaui ekspektasi saya. Pendekatan praktis dan contoh dunia nyata membantu saya menerapkan strategi segera dalam pekerjaan saya. Sangat direkomendasikan untuk profesional pemasaran!</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="testimonial-item">
              <img src="landingpage/assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
              <h3>Emily Chen</h3>
              <h4>Desainer UX</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Workshop UI/UX Design adalah yang saya butuhkan untuk memajukan karir saya. Instrukturnya berpengetahuan luas dan proyek praktik membantu saya membangun portofolio yang kuat. Sangat sepadan!</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="testimonial-item">
              <img src="landingpage/assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
              <h3>Michael Roberts</h3>
              <h4>Manajer Proyek</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Workshop Manajemen Proyek Profesional memberikan cakupan komprehensif tentang metodologi penting. Materi persiapan sertifikasi sangat berharga, dan saya lulus ujian PMP dalam percobaan pertama!</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="testimonial-item">
              <img src="landingpage/assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
              <h3>Sarah Thompson</h3>
              <h4>Analis Bisnis</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Workshop Analisis Data mengubah pendekatan saya dalam analisis bisnis. Keterampilan praktis yang saya dapatkan membuat saya lebih efisien dalam peran saya dan membuka peluang karir baru. Terima kasih, WorkSmart!</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->

        </div>

      </div>

    </section>
    <!-- /Testimonials Section -->

    <!-- Bagian Statistik -->
    <section id="stats" class="stats section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="5000" data-purecounter-duration="1" class="purecounter"></span>
              <p>Peserta Dilatih</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="50" data-purecounter-duration="1" class="purecounter"></span>
              <p>Workshop Tersedia</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="2000" data-purecounter-duration="1" class="purecounter"></span>
              <p>Jam Pelatihan</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="25" data-purecounter-duration="1" class="purecounter"></span>
              <p>Instruktur Ahli</p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section>
    <!-- /Bagian Statistik -->

    <!-- Bagian FAQ -->
    <section class="faq-9 faq section light-background" id="faq">

      <div class="container">
        <div class="row">

          <div class="col-lg-5" data-aos="fade-up">
            <h2 class="faq-title">Pertanyaan yang Sering Diajukan Tentang Workshop Kami</h2>
            <p class="faq-description">Temukan jawaban untuk pertanyaan umum tentang program workshop kami, proses pendaftaran, dan pengalaman belajar.</p>
            <div class="faq-arrow d-none d-lg-block" data-aos="fade-up" data-aos-delay="200">
              <svg class="faq-arrow" width="200" height="211" viewBox="0 0 200 211" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M198.804 194.488C189.279 189.596 179.529 185.52 169.407 182.07L169.384 182.049C169.227 181.994 169.07 181.939 168.912 181.884C166.669 181.139 165.906 184.546 167.669 185.615C174.053 189.473 182.761 191.837 189.146 195.695C156.603 195.912 119.781 196.591 91.266 179.049C62.5221 161.368 48.1094 130.695 56.934 98.891C84.5539 98.7247 112.556 84.0176 129.508 62.667C136.396 53.9724 146.193 35.1448 129.773 30.2717C114.292 25.6624 93.7109 41.8875 83.1971 51.3147C70.1109 63.039 59.63 78.433 54.2039 95.0087C52.1221 94.9842 50.0776 94.8683 48.0703 94.6608C30.1803 92.8027 11.2197 83.6338 5.44902 65.1074C-1.88449 41.5699 14.4994 19.0183 27.9202 1.56641C28.6411 0.625793 27.2862 -0.561638 26.5419 0.358501C13.4588 16.4098 -0.221091 34.5242 0.896608 56.5659C1.8218 74.6941 14.221 87.9401 30.4121 94.2058C37.7076 97.0203 45.3454 98.5003 53.0334 98.8449C47.8679 117.532 49.2961 137.487 60.7729 155.283C87.7615 197.081 139.616 201.147 184.786 201.155L174.332 206.827C172.119 208.033 174.345 211.287 176.537 210.105C182.06 207.125 187.582 204.122 193.084 201.144C193.346 201.147 195.161 199.887 195.423 199.868C197.08 198.548 193.084 201.144 195.528 199.81C196.688 199.192 197.846 198.552 199.006 197.935C200.397 197.167 200.007 195.087 198.804 194.488ZM60.8213 88.0427C67.6894 72.648 78.8538 59.1566 92.1207 49.0388C98.8475 43.9065 106.334 39.2953 114.188 36.1439C117.295 34.8947 120.798 33.6609 124.168 33.635C134.365 33.5511 136.354 42.9911 132.638 51.031C120.47 77.4222 86.8639 93.9837 58.0983 94.9666C58.8971 92.6666 59.783 90.3603 60.8213 88.0427Z" fill="currentColor"></path>
              </svg>
            </div>
          </div>

          <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>Bagaimana cara mendaftar workshop?</h3>
                <div class="faq-content">
                  <p>Pendaftaran sangat mudah! Telusuri workshop yang tersedia, pilih kursus yang Anda inginkan, dan klik tombol "Daftar". Anda dapat melakukan pembayaran secara online dengan aman dan menerima konfirmasi pendaftaran segera.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Metode pembayaran apa yang diterima?</h3>
                <div class="faq-content">
                  <p>Kami menerima berbagai metode pembayaran termasuk kartu kredit/debit, transfer bank, dan dompet digital. Semua pembayaran diproses secara aman melalui mitra gateway pembayaran terpercaya kami.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Apakah workshop dilakukan secara online atau tatap muka?</h3>
                <div class="faq-content">
                  <p>Kami menawarkan workshop online dan tatap muka. Setiap daftar workshop menunjukkan format dengan jelas. Workshop online dilakukan melalui platform pembelajaran interaktif kami, sementara sesi tatap muka diadakan di pusat pelatihan yang ditentukan.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Apa yang terjadi jika saya melewatkan sesi workshop?</h3>
                <div class="faq-content">
                  <p>Untuk workshop online, rekaman tersedia bagi peserta yang terdaftar. Untuk sesi tatap muka, kami menawarkan kelas pengganti jika memungkinkan. Silakan hubungi tim dukungan kami untuk pengaturan khusus.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Apakah Anda memberikan sertifikat setelah selesai?</h3>
                <div class="faq-content">
                  <p>Ya, semua peserta menerima sertifikat digital setelah berhasil menyelesaikan workshop. Sertifikat ini dapat diunduh langsung dari dashboard akun Anda.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Bagaimana kebijakan pengembalian dana Anda?</h3>
                <div class="faq-content">
                  <p>Kami menawarkan pengembalian dana penuh jika pembatalan dilakukan 7 hari sebelum tanggal mulai workshop. Pengembalian dana sebagian tersedia hingga 48 jam sebelum workshop. Silakan tinjau kebijakan pengembalian dana lengkap kami untuk detail lebih lanjut.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- /Bagian FAQ -->

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">WorkSmart</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Jl. Sudirman No. 123</p>
            <p>Jakarta, Indonesia 12345</p>
            <p class="mt-3"><strong>Telepon:</strong> <span>+62 812 3456 7890</span></p>
            <p><strong>Email:</strong> <span>info@worksmart.id</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Tautan Cepat</h4>
          <ul>
            <li><a href="#">Beranda</a></li>
            <li><a href="#">Tentang Kami</a></li>
            <li><a href="#">Workshop</a></li>
            <li><a href="#">Syarat Layanan</a></li>
            <li><a href="#">Kebijakan Privasi</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Kategori Workshop</h4>
          <ul>
            <li><a href="#">Keterampilan Bisnis</a></li>
            <li><a href="#">Pemasaran Digital</a></li>
            <li><a href="#">Kepemimpinan</a></li>
            <li><a href="#">Pengembangan Diri</a></li>
            <li><a href="#">Keterampilan Profesional</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Untuk Peserta</h4>
          <ul>
            <li><a href="#">Cara Mendaftar</a></li>
            <li><a href="#">Metode Pembayaran</a></li>
            <li><a href="#">Jadwal Workshop</a></li>
            <li><a href="#">Sertifikat</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Untuk Instruktur</h4>
          <ul>
            <li><a href="#">Menjadi Instruktur</a></li>
            <li><a href="#">Ajukan Workshop</a></li>
            <li><a href="#">Sumber Daya</a></li>
            <li><a href="#">Panduan</a></li>
            <li><a href="#">Dukungan</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Hak Cipta</span> <strong class="px-1 sitename">WorkSmart</strong> <span>Seluruh Hak Dilindungi</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
      </div>
    </div>

  </footer>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
   <!-- Bootstrap JavaScript (required for modal functionality) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script src="landingpage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="landingpage/assets/vendor/php-email-form/validate.js"></script>
  <script src="landingpage/assets/vendor/aos/aos.js"></script>
  <script src="landingpage/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="landingpage/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="landingpage/assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="landingpage/assets/js/main.js"></script>
  <script>
        document.addEventListener('DOMContentLoaded', function() {
        const workshopsContainer = document.querySelector('.row.gy-4');
        const searchInput = document.getElementById('workshopSearch');
        const categorySelect = document.querySelector('.search-wrapper select');
        const filterButtons = document.querySelectorAll('.filter-buttons .btn');

        let workshops = Array.from(workshopsContainer.children);
        
        // Search filter
        searchInput.addEventListener('input', filterWorkshops);
        
        // Category filter
        categorySelect.addEventListener('change', filterWorkshops);
        
        // Active filter buttons
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                filterWorkshops();
            });
        });

        function filterWorkshops() {
            let searchQuery = searchInput.value.toLowerCase();
            let selectedCategory = categorySelect.value;
            let activeFilter = document.querySelector('.filter-buttons .btn.active')?.textContent.trim();

            // Make sure the activeFilter exists
            if (!activeFilter) return;

            let filteredWorkshops = workshops.filter(workshop => {
                let titleElement = workshop.querySelector('.card-title');
                let descriptionElement = workshop.querySelector('.card-text');
                let categoryElement = workshop.querySelector('.badge.bg-primary');

                if (!titleElement || !descriptionElement || !categoryElement) return false;

                let title = titleElement.textContent.toLowerCase();
                let description = descriptionElement.textContent.toLowerCase();
                let category = categoryElement.textContent;

                let matchesSearch = title.includes(searchQuery) || description.includes(searchQuery);
                let matchesCategory = selectedCategory === 'Semua Kategori' || category.includes(selectedCategory);
                let matchesFilter = (activeFilter === 'Semua' || activeFilter === category);

                return matchesSearch && matchesCategory && matchesFilter;
            });

            // Clear and append filtered workshops
            workshopsContainer.innerHTML = '';
            filteredWorkshops.forEach(workshop => {
                workshopsContainer.appendChild(workshop);
            });
        }

    });

    document.addEventListener('DOMContentLoaded', function() {
          const paginationLinks = document.querySelectorAll('.pagination .page-link');
          const totalPages = Math.ceil(workshops.length / itemsPerPage);
          const prevPageLink = document.getElementById('prevPage');
          const nextPageLink = document.getElementById('nextPage');

          function updatePagination() {
              paginationLinks.forEach((link, index) => {
                  const pageNum = index + 1;
                  if (pageNum > totalPages) {
                      link.parentElement.style.display = 'none';
                  } else {
                      link.parentElement.style.display = 'block';
                  }
              });
          }

          paginationLinks.forEach(link => {
              link.addEventListener('click', function(e) {
                  e.preventDefault();
                  const newPage = parseInt(this.textContent);
                  if (isNaN(newPage)) return;  // In case the link is not a number

                  paginateWorkshops(newPage);
                  updatePagination();
              });
          });

          prevPageLink.addEventListener('click', function(e) {
              e.preventDefault();
              if (currentPage > 1) {
                  currentPage--;
                  paginateWorkshops(currentPage);
                  updatePagination();
              }
          });

          nextPageLink.addEventListener('click', function(e) {
              e.preventDefault();
              if (currentPage < totalPages) {
                  currentPage++;
                  paginateWorkshops(currentPage);
                  updatePagination();
              }
          });

          function paginateWorkshops(page) {
              const totalWorkshops = Array.from(workshopsContainer.children);
              const startIndex = (page - 1) * itemsPerPage;
              const endIndex = startIndex + itemsPerPage;

              totalWorkshops.forEach(workshop => workshop.style.display = 'none');
              totalWorkshops.slice(startIndex, endIndex).forEach(workshop => workshop.style.display = 'block');

              currentPage = page;
          }

          // Initialize pagination
          paginateWorkshops(1);
          updatePagination();
   });


  </script>
</body>

</html>