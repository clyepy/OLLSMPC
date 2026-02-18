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
  <title>About</title>
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

<body class="about-page">

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

    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">About</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">About</li>
          </ol>
        </nav>
      </div>
    </div>
<section id="about" class="about section">
  <div class="container" data-aos="fade-up">

    <!-- VISION -->
    <div class="mb-5">
      <h2>Our Vision</h2>
      <p>
        The Vision of OUR LADY OF LA SALETTE MULTI-PURPOSE COOPERATIVE is to become a strong cooperative committed to provide a variety of services and opportunities to its general membership vis-a-vis good governance, self-reliant membership and proactive operations.
      </p>
    </div>

    <!-- MISSION -->
    <div class="mb-5">
      <h2>Our Mission</h2>
      <p>
        In keeping with its vision, the OUR LADY OF LA SALETTE MULTI-PURPOSE COOPERATIVE shall strive to become a strong, innovative and pro-active cooperative thereby serving its general membership, and 
      </p>
      <ul>
        <li>
          <strong>As a strong cooperative,</strong> it aims to develop self-reliant membership vis-à-vis financial assistance and good governance
        </li>
        <li>
          <strong>As an innovative cooperative,</strong> it supports a dynamic breakthrough enhancing substantial positive result and performance.
        </li>
        <li>
          <strong>As a proactive cooperative,</strong> it charts its future directions by creating a climate supportive to proactive and operations and learning, and self-correcting systems.
        </li>
      </ul>
    </div>

    <!-- CORE VALUES -->
    <div class="mb-5">
      <h2>Core Values</h2>
      <ul>
        <li><strong>Outstanding Service:</strong> We are committed to delivering service of the highest quality and excellence in everything we do. We constantly strive to exceed expectations and set new standards.</li>
        <li><strong>Loyalty:</strong> Loyalty to our customers, partners, and team members is at the heart of our service. We build lasting relationships based on trust, respect, and mutual support.</li>
        <li><strong>Leadership:</strong> We lead by example, setting the standard for innovation and best practices in our cooperative. We aim to inspire and empower others to excel in their service roles.</li>
        <li><strong>Sustainability:</strong> We are dedicated to environmentally and socially responsible service practices. We seek sustainable solutions that benefit our communities and the world at large.</li>
        <li><strong>Mindfulness:</strong> We approach service with focus on empathy, compassion, and understanding. We actively listen to our members/customers and colleagues to meet their needs and concerns.</li>
        <li><strong>Professionalism:</strong> Professionalism is the cornerstone of our service culture. We maintain the highest ethical standards, respect confidentiality, and conduct ourselves with integrity.</li>
        <li><strong>Collaboration:</strong> We value collaboration and teamwork. We believe that the best service outcomes are achieved through open communication, cooperation, and the sharing of knowledge and resources.</li>
      </ul>
    </div>

    <!-- HISTORY -->
    <div class="mb-5">
      <h2>Our History</h2>

  <p>
    <strong>Our Lady of La Salette Multi-Purpose Cooperative (OLLSMPC)</strong>
    was founded on <strong>October 5, 1993</strong> through the initiative of
    <strong>Mr. Andres R. Cabuyadao</strong> and the officers of the
    <strong>La Salette College Employees' Association (LCEA)</strong>.
    The cooperative was established to realize the concepts and objectives
    presented by Mr. Cabuyadao in his position paper for his
    <em>Master in Business Management</em> degree.
  </p>
<br>
  <p>
    During its formation, <strong>123 employees</strong> expressed their intent
    to cooperate and contributed to the registration and initial capitalization
    of the cooperative. However, financial challenges were encountered during
    the early stages of operation. To address these difficulties, the organizers
    sought assistance from <strong>Rev. Fr. Romeo B. Gonzales, MS, PhD</strong>,
    who generously extended a Php 60,000.00 interest-free loan
    for one year. The first Chairman of the Board was
    Mr. Andy Mendoza, who was then the President of the LCEA.
  </p>
<br>
  <p>
    OLLSMPC formally began extending services to its members in
    <strong>January 1994</strong>, utilizing funds provided by the
    University of La Salette (formerly La Salette College).
    Initially, the cooperative limited its area of operations to
    <strong>Santiago City</strong> and employees of La Salette College.
  </p>
<br>
  <p>
    From a modest beginning, OLLSMPC steadily expanded its reach and services.
    Its area of operation now covers the entire
    <strong>Region II (Cagayan Valley)</strong>. The cooperative amended its
    Articles of Cooperation to increase its authorized capitalization from
    Php 1,000,000.00 to
    >Php 50,000,000.00, reflecting its strong growth and stability.
  </p>
<br>
  <p>
    Membership has grown significantly from the original 123 members to
    2,744 members coming from the provinces of
    Cagayan, Isabela, Quirino, Nueva Vizcaya, and Ifugao.
    As of January 31, 2025, these members comprise the
    General Assembly, the highest governing body of the cooperative.
  </p>
<br>
  <p>
    OLLSMPC is governed by a seven (7)-member Board of Directors,
    assisted by a Secretary and Legal Counsel. The day-to-day management and
    operations are handled by full-time branch managers and dedicated staff.
  </p>
<br>
  <p>
    Within the cooperative sector, OLLSMPC is recognized as a
    model and multi-awarded cooperative. It has received several
    <strong>Faustino N. Dy Awards</strong> for outstanding performance in Isabela.
    At the national level, its most recent recognition is the
    <strong>2023 Villar Awards on Poverty Reduction</strong>, where it was honored
    as an Outstanding Community Enterprise.
  </p>
<br>
  <p>
    These achievements are attributed to OLLSMPC’s
    quality asset management, robust membership growth,
    efficient records management, computerized accounting system,
    and responsive outreach programs,
    all of which continue to strengthen the cooperative and uplift its members.
  </p>
    </div>

    <!-- BENEFITS -->
    <div class="mb-5">
      <h2>Benefits of Membership</h2>

      <h4>Mortuary Assistance</h4>
      <ul>
        <li><strong>Php 20,000.00</strong> – 5 years member, minimum Php 25,000 investment, availed services Php 100,000+</li>
        <li><strong>Php 15,000.00</strong> – 3 years member, minimum Php 15,000 investment, availed services Php 100,000+</li>
        <li><strong>Php 10,000.00</strong> – 3 years member, minimum Php 10,000 investment, availed services Php 100,000+</li>
        <li><strong>Php 5,000.00</strong> – Minimum Php 5,000 investment</li>
      </ul>

            <div class="card p-4 mb-4">
        <h4>Important Notice</h4>
    <p>
      Claims filed <strong>30 days after confinement or death</strong> shall not be processed by the Cooperative.
      Members must have at least <strong>3 months of membership</strong> and a minimum of
      <strong>Php 3,000.00 Paid-Up Capital</strong> with <strong>Damayan Deposit</strong> to be entitled to benefits.
    </p>
      </div>

      <h4><br><br>Damayan Program (Hospitalization Assistance)</h4>
      <p><strong>Member:</strong> 50% of bill or (members × Php 10)</p>
      <p><strong>Spouse:</strong> 40% of bill or (members × Php 8)</p>
      <p><strong>Dependents:</strong> 30% of bill or (members × Php 6)</p>
    </div>

    <!-- MEMBERSHIP POLICIES -->
    <div class="mb-5">
      <h2>Membership Policies</h2>

      <h4>Pre-Membership Education Seminar (PMES)</h4>
      <p>1. All prospective members must undergo Pre-Membership Education Seminar (PMES).</p>
      <p>2. A certification that the prospective member has attended the seminar shall be issued by the person who conducted the seminar</p>
      <p>3. The eligibility requirement must be paid before a prospective member is accepted into the cooperative</p>

      <h4>Membership Fees</h4>
      <ul>
        <li>Membership Fee – Php 200</li>
        <li>Orientation Fee – Php 100</li>
        <li>Share Capital – Php 4,000</li>
        <li>Annual Dues – Php 50</li>
        <li>Damayan Fund – Php 250</li>
        <li><strong>Total – Php 4,600</strong></li>
      </ul>

      <p>4. An accepted member must be approved by the Board of Directors ti be considered as regular member of the cooperative</p>
      <p>5. Mobile Orientation - for a minimum of 10 prospect membership for orientation</p>

      <h4>Documentary Requirements</h4>
      <ul>
        <li>Application Form</li>
        <li>TIN or Resident Certificate</li>
        <li>Barangay Clearance</li>
        <li>Photocopy of Valid ID</li>
        <li>2pcs 2×2 ID Pictures</li>
        <li>Proof of Income</li>
      </ul>
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

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <script src="assets/js/main.js"></script>

</body>

</html>