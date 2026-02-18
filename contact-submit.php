<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $phone === '' || $subject === '' || $message === '') {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO contact_messages 
        (name, email, phone, subject, message, is_read, created_at)
        VALUES (?, ?, ?, ?, ?, 0, NOW())
    ");

    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Failed to send message.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact</title>
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

<body class="contact-page">

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
        <h1 class="mb-2 mb-lg-0">Contact</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Contact</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

<section id="new-contact" class="contact section new-contact">

  <div class="container">
    <div class="contact-wrapper">

      <!-- LEFT PANEL -->
      <div class="contact-info-panel">
        <div class="contact-info-header">
          <h3>OLLSMPC Branch Offices</h3>
          <p>
            Reach out to any of our branch offices. We are committed to serving
            our members with reliable, transparent, and community-focused service.
          </p>
        </div>

        <div id="branchCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
          <div class="carousel-inner">

            <div class="carousel-item active">
              <div class="contact-info-cards">
                <div class="info-card">
                  <i class="bi bi-geo-alt-fill"></i>
                  <div>
                    <h4>Main Office – Santiago City</h4>
                    <p>Carreon St., Centro East, Santiago City</p>
                  </div>
                </div>
                <div class="info-card">
                  <i class="bi bi-telephone-fill"></i>
                  <div>
                    <h4>Contact Number</h4>
                    <p>0977-805-7365</p>
                  </div>
                </div>
              </div>
            </div>

              <div class="carousel-item">
              <div class="contact-info-cards">
                <div class="info-card">
                  <i class="bi bi-geo-alt-fill"></i>
                  <div>
                    <h4>Ramon Branch</h4>
                    <p>Bugallon Proper, Ramon, Isabela</p>
                  </div>
                </div>
                <div class="info-card">
                  <i class="bi bi-telephone-fill"></i>
                  <div>
                    <h4>Contact Number</h4>
                    <p>0967-971-7207</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="contact-info-cards">
                <div class="info-card">
                  <i class="bi bi-geo-alt-fill"></i>
                  <div>
                    <h4>Head Office</h4>
                    <p>Divisoria, Santiago Cit</p>
                  </div>
                </div>
                <div class="info-card">
                  <i class="bi bi-telephone-fill"></i>
                  <div>
                    <h4>Contact Number</h4>
                    <p>0955-704-7434</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="contact-info-cards">
                <div class="info-card">
                  <i class="bi bi-geo-alt-fill"></i>
                  <div>
                    <h4>Jones Branch</h4>
                    <p>Barangay 1, Jones, Isabela</p>
                  </div>
                </div>
                <div class="info-card">
                  <i class="bi bi-telephone-fill"></i>
                  <div>
                    <h4>Contact Number</h4>
                    <p>0975-657-0184</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="contact-info-cards">
                <div class="info-card">
                  <i class="bi bi-geo-alt-fill"></i>
                  <div>
                    <h4>San Mateo Branch</h4>
                    <p>Malasin, San Mateo, Isabela</p>
                  </div>
                </div>
                <div class="info-card">
                  <i class="bi bi-telephone-fill"></i>
                  <div>
                    <h4>Contact Number</h4>
                    <p>0966-745-9878</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="contact-info-cards">
                <div class="info-card">
                  <i class="bi bi-geo-alt-fill"></i>
                  <div>
                    <h4>Cordon Branch</h4>
                    <p>Magsaysay, Cordon, Isabela</p>
                  </div>
                </div>
                <div class="info-card">
                  <i class="bi bi-telephone-fill"></i>
                  <div>
                    <h4>Contact Number</h4>
                    <p>0975-460-6428</p>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#branchCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#branchCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>

      <!-- RIGHT PANEL -->
      <div class="contact-form-panel">
        <div class="form-container">
          <h3>Send Us a Message</h3>
          <p>
            Have questions regarding membership, loans, or services?
            Send us a message and our team will assist you.
          </p>

          <form action="contact-submit.php" method="post" class="php-email-form">

            <div class="form-floating mb-3">
              <input type="text" name="name" class="form-control" placeholder="Full Name" required>
              <label>Full Name</label>
            </div>

            <div class="form-floating mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
              <label>Email Address</label>
            </div>

            <div class="form-floating mb-3">
  <input
    type="text"
    name="phone"
    class="form-control"
    placeholder="Phone Number"
    required
  >
  <label>Phone Number</label>
</div>

            <div class="form-floating mb-3">
              <input type="text" name="subject" class="form-control" placeholder="Subject" required>
              <label>Subject</label>
            </div>

            <div class="form-floating mb-3">
              <textarea name="message" class="form-control" style="height:150px" placeholder="Message" required></textarea>
              <label>Your Message</label>
            </div>

            <div class="my-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn-submit">
                Send Message <i class="bi bi-send-fill ms-2"></i>
              </button>
            </div>

          </form>
        </div>
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