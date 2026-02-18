<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "connection.php";

// Check if event type filter exists
$type = isset($_GET['type']) ? trim($_GET['type']) : '';

if (!empty($type)) {
    $type_safe = mysqli_real_escape_string($conn, $type);
    $sql = "SELECT * FROM events 
            WHERE event_type = '$type_safe' 
            ORDER BY event_date DESC";
} else {
    $sql = "SELECT * FROM events 
            ORDER BY event_date DESC";
}

$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Events</title>
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

<body class="projects-page">

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

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Events</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Events</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

<section id="projects" class="projects section">

      <div class="container section-title">
<h2>Events</h2>
<p>
Stay updated with the official activities, programs, and celebrations of
Our Lady of La Salette Multi-Purpose Cooperative.
</p>

      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

<div class="projects-grid">

<?php if (mysqli_num_rows($result) > 0): ?>
<?php while ($row = mysqli_fetch_assoc($result)): ?>

<div class="project-item" data-aos="zoom-in">
  <div class="project-content">

    <div class="project-header">
      <span class="project-category">
        <?= htmlspecialchars($row['event_type'] ?: 'Cooperative Event') ?>
      </span>
      <span class="project-status completed">Completed</span>
    </div>

    <h3 class="project-title">
      <?= htmlspecialchars($row['title']) ?>
    </h3>

    <div class="project-details">
      <div class="project-info">
        <p>
          <?= nl2br(htmlspecialchars($row['summary'])) ?>
        </p>

        <div class="project-specs">
          <span class="spec-item">
            <i class="bi bi-calendar-event"></i>
            <?= date("F d, Y", strtotime($row['event_date'])) ?>
          </span>
        </div>
      </div>
    </div>

    <a href="event-details.php?id=<?= $row['id'] ?>" class="project-link">
      <span>View Event</span>
      <i class="bi bi-arrow-right"></i>
    </a>

  </div>

  <div class="project-visual">
    <?php if (!empty($row['banner_image'])): ?>
      <img src="<?= htmlspecialchars($row['banner_image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
    <?php else: ?>
      <img src="assets/img/event-placeholder.jpg" alt="Event image">
    <?php endif; ?>

    <div class="project-badge">
      <i class="bi bi-award"></i>
    </div>
  </div>
</div>

<?php endwhile; ?>
<?php else: ?>
  <p class="text-center">No events available.</p>
<?php endif; ?>

</div>


      </div>
    </section>


        <div class="technical-gallery" data-aos="fade-up" data-aos-delay="500">
          <div class="gallery-header">
            <h3>Events & Activities</h3>
            <p> Official programs, outreach activities, and community initiatives conducted by Our Lady of La Salette Multi-Purpose Cooperative.</p>    <a href="event-details.html" class="project-link">
          </div>
          <div class="row g-3">
            <div class="col-md-4">
              <div class="tech-item">
                <img src="assets/img/event1.jpg" alt="Blueprint Review" class="img-fluid" loading="lazy">
              </div>
            </div>
            <div class="col-md-4">
              <div class="tech-item">
                <img src="assets/img/event4.jpg" alt="Quality Control" class="img-fluid" loading="lazy">
              </div>
            </div>
            <div class="col-md-4">
              <div class="tech-item">
                <img src="assets/img/event3.jpg" alt="Final Installation" class="img-fluid" loading="lazy">
              </div>
            </div>
          </div>
        </div>
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