<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Services</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

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

<body class="services-page">

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
        <h1 class="mb-2 mb-lg-0">Services</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Services</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Services Section -->
<section id="services" class="services section">

      <div class="container section-title">
        <h2>Services</h2>
        <p>Our Lady of La Salette Multi-Purpose Cooperative provides a wide range of financial services designed to empower members, promote savings discipline, and support sustainable personal and business growth.</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
<div class="service-card">
  <div class="service-icon">
    <i class="bi bi-piggy-bank"></i>
  </div>
  <h3>Savings Deposit</h3>
  <p>
    Our savings programs help members build financial security through
    flexible and rewarding deposit options.
  </p>
  <div class="service-features">
    <span><i class="bi bi-check-circle"></i> Premium Time Deposit</span>
    <span><i class="bi bi-check-circle"></i> Special Savings Deposit</span>
    <span><i class="bi bi-check-circle"></i> Regular Savings Deposit</span>
  </div>
</div>

          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
<div class="service-card featured">
  <div class="service-badge">Most Availed</div>
  <div class="service-icon">
    <i class="bi bi-cash-stack"></i>
  </div>
  <h3>Loan Services</h3>
  <p>
    We provide affordable and accessible loan programs to meet personal,
    educational, business, and emergency needs of our members.
  </p>
  <div class="service-features">
    <span><i class="bi bi-check-circle"></i> General Purpose Loan</span>
    <span><i class="bi bi-check-circle"></i> Salary Loan</span>
    <span><i class="bi bi-check-circle"></i> Emergency Loan</span>
  </div>
  <a href="service-details.php" class="service-link">View All Services <i class="bi bi-arrow-right"></i></a>
</div>

          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
<div class="service-card">
  <div class="service-icon">
    <i class="bi bi-building"></i>
  </div>
  <h3>Specialized Loan Programs</h3>
  <p>
    Designed to support long-term investments, livelihood, and major
    purchases for our members.
  </p>
  <div class="service-features">
    <span><i class="bi bi-check-circle"></i> Agricultural Loan</span>
    <span><i class="bi bi-check-circle"></i> Commercial Loan</span>
    <span><i class="bi bi-check-circle"></i> Real Estate Mortgage Loan</span>
  </div>
</div>

          </div>
        </div>

        <div class="row mt-5">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-image-block">
              <img src="assets/img/showcase2.jpg"  alt="Construction Services" class="img-fluid">
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-list-block">
<h3>Additional Services & Facilities</h3>
<p>
Beyond financial services, the cooperative also provides venues and
facilities that support community development, training, and events.
</p>

              <div class="service-list">
<div class="service-list-item">
  <div class="service-list-icon">
    <i class="bi bi-building"></i>
  </div>
  <div class="service-list-content">
    <h4>Event Venue – The Rochdale</h4>
    <p>
      A modern and accessible venue ideal for meetings, celebrations,
      seminars, and cooperative events.
    </p>
  </div>
</div>

<div class="service-list-item">
  <div class="service-list-icon">
    <i class="bi bi-mortarboard"></i>
  </div>
  <div class="service-list-content">
    <h4>Training Center</h4>
    <p>
      A dedicated space for skills training, seminars, and capacity-building
      programs for members and partner organizations.
    </p>
  </div>
</div>
              </div>
            </div>
          </div>
        </div>

        <div class="cta-container text-center mt-5" data-aos="fade-up" data-aos-delay="300">
            <video class="cta-video" autoplay muted loop playsinline>
    <source src="https://assets.mixkit.co/videos/914/914-720.mp4" type="video/mp4" />
  </video>
    <div class="cta-container text-center">
          <h3>Interested in Our Services?</h3>
          <p>ecome a member or inquire today to start enjoying the benefits of
savings, loans, and cooperative facilities designed for your growth.</p>
          <a href="#" class="btn btn-cta">Contact Us Today</a>
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