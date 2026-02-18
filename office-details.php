<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "connection.php";

/* ==========================
   STRICT BRANCH LOADING
========================== */
if (!isset($_GET['id'])) {
    die("No branch selected.");
}

$branch_id = intval($_GET['id']);

/* ==========================
   FETCH BRANCH
========================== */
$stmt = $conn->prepare("SELECT * FROM branches WHERE id=?");
$stmt->bind_param("i", $branch_id);
$stmt->execute();
$branch = $stmt->get_result()->fetch_assoc();

if (!$branch) {
    die("Branch not found.");
}

/* ==========================
   FETCH GALLERY
========================== */
$gallery_stmt = $conn->prepare("
    SELECT * FROM branch_gallery 
    WHERE branch_id=?
    ORDER BY id DESC
");
$gallery_stmt->bind_param("i", $branch_id);
$gallery_stmt->execute();
$gallery_result = $gallery_stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Office Details</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="service-details-page">

  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
<a href="index.php" class="logo d-flex align-items-center">
  <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" alt="OLLSMPC Logo">
  <h1 class="sitename">OLLSMPC</h1>
</a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="event.php">Events</a></li> 
            <li><a href="team.php">Team</a></li>
            <li class="dropdown"><a href="#"><span>Others</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="FAQ.php">Frequently Ask Questions</a></li>
                <li><a href="reviews.php">Reviews</a></li>
                <li><a href="AWARD/index.php">Awards</a></li>
                <li><a href="term.php">Term</a></li>
              </ul>
            </li>
            <li><a href="contact-submit.php">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

<div class="page-title light-background">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Office Details</h1>
  </div>
</div>

<section id="service-details" class="service-details section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <!-- ✅ ROW START -->
    <div class="row">

      <!-- ✅ SIDEBAR -->
      <div class="col-lg-4 order-lg-2">
        <div class="service-sidebar" data-aos="fade-left" data-aos-delay="200">

          <div class="service-overview-card">
            <div class="service-icon"><i class="bi bi-building"></i></div>
            <h3><?= htmlspecialchars($branch['name']) ?></h3>
            <p><?= nl2br(htmlspecialchars($branch['overview'])) ?></p>

            <div class="service-stats">
              <div class="stat-item">
                <span class="stat-number"><?= intval($branch['active_members']) ?></span>
                <span class="stat-label">Active Members</span>
              </div>
              <div class="stat-item">
                <span class="stat-number"><?= intval($branch['years_service']) ?></span>
                <span class="stat-label">Years of Service</span>
              </div>
            </div>
          </div>

          <div class="quick-info-card">
            <h4>Branch Information</h4>
            <div class="info-grid">
              <div class="info-row">
                <span class="label">Location:</span>
                <span class="value"><?= htmlspecialchars($branch['location']) ?></span>
              </div>
              <div class="info-row">
                <span class="label">Office Hours:</span>
                <span class="value"><?= htmlspecialchars($branch['hours']) ?></span>
              </div>
              <div class="info-row">
                <span class="label">Branch Type:</span>
                <span class="value"><?= htmlspecialchars($branch['type']) ?></span>
              </div>
            </div>
          </div>

          <div class="contact-action-card">
            <h4>Branch Manager</h4>
            <p class="contact-text">
              Managed by <?= htmlspecialchars($branch['manager_name']) ?>.
            </p>
            <div class="contact-methods">
              <a href="tel:<?= htmlspecialchars($branch['manager_phone']) ?>" class="contact-btn">
                <i class="bi bi-telephone-fill"></i>
                <span>Call Manager</span>
              </a>
              <a href="mailto:<?= htmlspecialchars($branch['manager_email']) ?>" class="contact-btn">
                <i class="bi bi-envelope-fill"></i>
                <span>Email Manager</span>
              </a>
            </div>
          </div>

        </div>
      </div>

      <!-- ✅ MAIN CONTENT -->
      <div class="col-lg-8 order-lg-1">
        <div class="service-main-content">

          <div class="hero-section" data-aos="zoom-in" data-aos-delay="150">
            <img src="uploads/branches/<?= htmlspecialchars($branch['hero_image']) ?>">
            <div class="hero-overlay">
              <div class="hero-badge">
                <i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($branch['type']) ?>
              </div>
            </div>
          </div>

          <div class="content-section" data-aos="fade-up" data-aos-delay="200">
            <h1><?= htmlspecialchars($branch['name']) ?></h1>
            <div class="content-intro">
              <p><?= nl2br(htmlspecialchars($branch['overview'])) ?></p>
            </div>
          </div>

<div class="capabilities-grid" data-aos="fade-up" data-aos-delay="250">
  <h2>Services Available in This Branch</h2>

  <div class="row g-4">
    <div class="col-md-6">
      <div class="capability-card">
        <div class="capability-icon">
          <i class="bi bi-cash-stack"></i>
        </div>
        <h4>Loan Processing</h4>
        <p>Handles personal, emergency, and special loan applications.</p>
      </div>
    </div>

    <div class="col-md-6">
      <div class="capability-card">
        <div class="capability-icon">
          <i class="bi bi-piggy-bank"></i>
        </div>
        <h4>Savings & Deposits</h4>
        <p>Manages regular, special, and time deposit accounts.</p>
      </div>
    </div>

    <div class="col-md-6">
      <div class="capability-card">
        <div class="capability-icon">
          <i class="bi bi-person-check"></i>
        </div>
        <h4>Membership Services</h4>
        <p>New member registration and account updates.</p>
      </div>
    </div>

    <div class="col-md-6">
      <div class="capability-card">
        <div class="capability-icon">
          <i class="bi bi-clipboard-data"></i>
        </div>
        <h4>Records & Inquiries</h4>
        <p>Member records, certifications, and account inquiries.</p>
      </div>
    </div>
  </div>
</div>

          <div class="methodology-section" data-aos="fade-up" data-aos-delay="300">
            <div class="manager-profile text-center mb-3">
              <img src="uploads/managers/<?= htmlspecialchars($branch['manager_photo']) ?>"
                   class="img-fluid rounded-circle"
                   style="width:120px;height:120px;object-fit:cover;">
              <h5 class="mt-2 mb-0"><?= htmlspecialchars($branch['manager_name']) ?></h5>
            </div>

            <h2>Branch Management</h2>
            <div class="methodology-timeline">
              <div class="timeline-item">
                <div class="timeline-content">
                  <p><?= nl2br(htmlspecialchars($branch['manager_bio'])) ?></p>

                  <?php if (!empty($branch['manager_experience'])): ?>
                    <ul class="phase-features">
                      <?php foreach (preg_split("/\R/", $branch['manager_experience']) as $exp): ?>
                        <?php if (trim($exp)): ?>
                          <li><?= htmlspecialchars($exp) ?></li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
    <!-- ✅ ROW END -->

 <div class="portfolio-showcase mt-5" data-aos="fade-up" data-aos-delay="350">
  <div class="row g-4 mt-3">

    <?php while ($img = $gallery_result->fetch_assoc()): ?>
      <div class="col-lg-6">
        <div class="project-showcase-item">
          <div class="project-image">

            <img src="uploads/branches/<?= htmlspecialchars($img['image_url']) ?>" 
                 class="img-fluid">

            <div class="project-overlay">
              <div class="project-info">
                <h4><?= htmlspecialchars($img['title']) ?></h4>

                <a href="uploads/branches/<?= htmlspecialchars($img['image_url']) ?>" 
                   class="view-btn glightbox">
                   <i class="bi bi-eye"></i>
                </a>

              </div>
            </div>

          </div>
        </div>
      </div>
    <?php endwhile; ?>

  </div>
</div>


  </div>
</section>
</main>

<footer id="footer" class="footer dark-background">

  <div class="container footer-top">
    <div class="row gy-4">

      <div class="col-lg-5 col-md-12 footer-about">
        <a href="index.html" class="logo d-flex align-items-center">
          <img src="https://tse2.mm.bing.net/th/id/OIP.AT9YKEwkahvV_Z8_Ph_SjgHaHa?rs=1&pid=ImgDetMain&o=7&rm=3" alt="OLLSMPC Logo">
          <span class="sitename">OLLSMPC</span>
        </a>

        <p>
          OLLSMPC is committed to providing reliable financial services,
          empowering members, and strengthening communities through
          cooperation, transparency, and integrity.
        </p>

        <div class="social-links d-flex mt-4">
          <a href="https://www.facebook.com/share/18Md4ovapL/"><i class="bi bi-facebook"></i></a>
          <a href="mailto:ollsmpc.helpdesk@gmail.com"><i class="bi bi-envelope"></i></a>
          <a href="tel:+639557047434"><i class="bi bi-telephone"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="event.php">Events</a></li>
          <li><a href="contact-submit.php">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-6 footer-links">
        <h4>Services</h4>
        <ul>
          <li><a href="services.ph">Savings Deposit</a></li>
          <li><a href="services.ph">Loan Services</a></li>
          <li><a href="services.ph">Specialized Loan Programs</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Contact Us</h4>
        <p>
          <strong>Phone:</strong>
          <span>(0977) 805-7365</span>
        </p>
        <p>
          <strong>Email:</strong>
          <span>ollsmpc.helpdesk@gmail.com</span>
        </p>
      </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>
      © <span>2026</span>
      <strong class="px-1 sitename">OLLSMPC</strong>
      <span>All Rights Reserved</span>
    </p>
  </div>
</footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>