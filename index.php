<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Sanitize inputs
  $name    = trim($_POST['name'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $phone   = trim($_POST['phone'] ?? '');
  $concern = trim($_POST['concern'] ?? '');
  $message = trim($_POST['message'] ?? '');

  // Basic validation
  if (
    empty($name) ||
    empty($email) ||
    empty($phone) ||
    empty($concern) ||
    empty($message)
  ) {
    header("Location: contact.php?error=missing");
    exit;
  }

  // Insert into database
  $stmt = $conn->prepare("
    INSERT INTO messages (name, email, phone, concern, message)
    VALUES (?, ?, ?, ?, ?)
  ");

  $stmt->bind_param("sssss", $name, $email, $phone, $concern, $message);

  if ($stmt->execute()) {
    header("Location: contact-submit.php?success=1");
  } else {
    header("Location: contact-submit.php?error=failed");
  }

  $stmt->close();
  $conn->close();
}

$featured = $conn->query("
  SELECT * FROM team_members 
  WHERE role_type='featured' 
  ORDER BY sort_order
");

$compact = $conn->query("
  SELECT * FROM team_members 
  WHERE role_type='compact' 
  ORDER BY sort_order
");

/* === IMAGE BASE PATH (IMPORTANT FIX) === */
$teamImagePath = "uploads/team/";

$ads = $conn->query("SELECT * FROM homepage_ads WHERE status='active'");

$sql = "SELECT * FROM events ORDER BY event_date DESC LIMIT 6";
$result = mysqli_query($conn, $sql);

$offices = $conn->query("
    SELECT *
    FROM branches
    WHERE type IN ('Main Office','Branch Office','Satellite Office')
    ORDER BY 
        CASE 
            WHEN type='Main Office' THEN 1
            WHEN type='Branch Office' THEN 2
            ELSE 3
        END
");

/* Count offices */
$total_offices = $offices->num_rows;

/* Reset pointer */
$offices->data_seek(0);

/* First office = highlight */
$head_office = $offices->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>OLLSMPC</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

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

    <section id="hero" class="hero section">
<video class="hero-video" autoplay muted loop playsinline>
  <source src="https://assets.mixkit.co/videos/24057/24057-720.mp4" type="video/mp4">
</video>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content" data-aos="fade-right" data-aos-delay="200">
              <span class="subtitle">Ang Kooperatibang may Puso</span>
              <h1>Our Lady of La Salette Multi-Purpose Cooperative</h1>
              <p>The OLLSMPC is a strong cooperative. It aims to build a bright and strong future with pride through committed service and faith in action</p>

              <div class="hero-buttons">
                <a href="about.php" class="btn-primary">About the OLLSMPC</a>
                <a href="contact-submit.php" class="btn-secondary">Contact Us</a>
              </div>
            </div>
          </div>

<div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
<div class="hero-image">

<div class="hero-carousel">

<?php 
$first = true;
while($row = $ads->fetch_assoc()): 
?>

<div class="hero-slide <?= $first ? 'active' : '' ?>">
    <img src="uploads/ads/<?= $row['image'] ?>">
</div>

<?php 
$first = false;
endwhile; 
?>

</div>

</div>
</div>
</div>


  </div>

    </section>

    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="about-content" data-aos="fade-right" data-aos-delay="200">
              <h2>Building Excellence Since 1993</h2>
              <p class="lead">At OLLSMPC, we go beyond financial services. We are a growing community that works together to uplift every member through trust, fairness, and shared responsibility</p>
              <p>Guided by unity and mutual support, we provide savings opportunities, reliable financing, and livelihood programs that help our members build a secure future and achieve sustainable growth.</p>

              <div class="trust-badges">
                <div class="badge-item">
                  <i class="bi bi-trophy"></i>
                  <div class="badge-text">
                    <span class="count">20+</span>
                    <span class="label">Awards</span>
                  </div>
                </div>
                <div class="badge-item">
                  <i class="bi bi-people"></i>
                  <div class="badge-text">
                    <span class="count">1000+</span>
                    <span class="label">Satisfied Clients</span>
                  </div>
                </div>
                <div class="badge-item">
                  <i class="bi bi-building-check"></i>
                  <div class="badge-text">
                    <span class="count">33+</span>
                    <span class="label">Years Experience</span>
                  </div>
                </div>
              </div>

              <div class="cta-container mt-5" data-aos="fade-up" data-aos-delay="800">
                <a href="about.php" class="btn btn-primary">Learn More About Us</a>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="about-image position-relative" data-aos="fade-left" data-aos-delay="200">
              <img src="assets/img/showcase2.jpg" alt="Construction Team" class="img-fluid main-image rounded">
              <div class="image-overlay">
                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgk-nS8j3fJbxWo2uyhAzpkqSlg2Q6GmZFx9KE47k4LjYJDyLUp5WopboOJl3Tt3hrgK8qlLFKvElj0YaC2KJ4YDgOyCze1d1xUdL3tBJpGzHoCUcWp_J3gajuxaYzhC8KI_ojmuLNWcS9BaxK_C5CZgK6PL-2IUhBQm6ZupB8R0nrXcOjMNF4hjClfY1c/w332-h363/inbound6110536668023580554.png" class="img-fluid rounded">
              </div>
            </div>
          </div>
        </div>

      </div>

    </section>

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
              <img src="assets/img/showcase1.jpg" alt="Construction Services" class="img-fluid">
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-list-block">
<h3>Additional Services & Facilities</h3>
<p>
Beyond financial services, the cooperative also provides venues and
facilities that support community development, training, and events. <a href="Venue/index.php">Click Here To Book a Schedule</a>
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
          <p>Become a member or inquire today to start enjoying the benefits of
savings, loans, and cooperative facilities designed for your growth.</p>
          <a href="contact-submit.php" class="btn btn-cta">Contact Us Today</a>
        </div>
      </div>
    </section>

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

    <section id="testimonials" class="testimonials section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="testimonials-slider swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 1,
              "spaceBetween": 30,
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-slide" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-header">
                  <div class="stars-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                  </div>
                  <div class="quote-icon">
                    <i class="bi bi-quote"></i>
                  </div>
                </div>
                <div class="testimonial-body">
      <p>
        "OLLSMPC has been a reliable and trustworthy cooperative that truly puts
    its members first. Their services are well-managed, transparent, and
    designed to help members achieve financial stability and growth."
      </p>
                </div>
                <div class="testimonial-footer">
                  <div class="author-info">
                    <img src="assets/img/person/chelsea.jpg" alt="Author" class="author-avatar">
                    <div class="author-details">
                      <h4>Chelsea Leigh Pascua</h4>
                      <span class="role">Project Manager / Lead Developer</span>
                      <span class="company">OLLSMPC</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-slide" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-header">
                  <div class="stars-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                  </div>
                  <div class="quote-icon">
                    <i class="bi bi-quote"></i>
                  </div>
                </div>
                <div class="testimonial-body">
      <p>
        "What I appreciate most about OLLSMPC is how accessible and supportive
    their services are. From savings to loans, everything is handled
    efficiently, making it easy for members to manage their financial needs."
      </p>
                </div>
                <div class="testimonial-footer">
                  <div class="author-info">
                    <img src="assets/img/person/trishea.jpg" alt="Author" class="author-avatar">
                    <div class="author-details">
                      <h4>Trishea Andrea Liwanag</h4>
                      <span class="role">Assistant Developer</span>
                      <span class="company">OLLSMPC</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-slide" data-aos="fade-up" data-aos-delay="400">
                <div class="testimonial-header">
                  <div class="stars-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                  </div>
                  <div class="quote-icon">
                    <i class="bi bi-quote"></i>
                  </div>
                </div>
                <div class="testimonial-body">
      <p>
        "OLLSMPC continues to show commitment to its members through consistent,
    secure, and well-structured services. It’s a cooperative you can trust
    for long-term financial support and community growth."
      </p>
                </div>
                <div class="testimonial-footer">
                  <div class="author-info">
                    <img src="assets/img/person/karl.jpg" alt="Author" class="author-avatar">
                    <div class="author-details">
                      <h4>AJ Karl Ancheta</h4>
                      <span class="role">Assistant Developer</span>
                      <span class="company">OLLSMPC</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="swiper-navigation-wrapper">
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
          </div>

        </div>

      </div>

    </section>


<section id="certifications" class="certifications section">

<div class="container section-title">
  <h2>Our Offices</h2>
  <p>OLLSMPC offices and branches serving members across Isabela and nearby areas</p>
</div>

<div class="container" data-aos="fade-up">

<!-- ================= HEAD OFFICE ================= -->
<div class="row align-items-center mb-5 content">

<div class="col-lg-6">
  <h2>Accessible Offices for Every Member</h2>
  <p>
    Our Lady of La Salette Multi-Purpose Cooperative maintains strategically
    located offices to ensure convenient access to cooperative services,
    member support, and community engagement.
  </p>
</div>

<div class="col-lg-6">
<a href="office-details.php?id=<?= $head_office['id'] ?>" class="card-link">

<div class="badge-highlight">

<img src="uploads/branches/<?= $head_office['hero_image'] ?>"
     alt="<?= $head_office['name'] ?>"
     class="img-fluid">

<div class="badge-content">
<h4><?= htmlspecialchars($head_office['name']) ?></h4>
<p>
<i class="fa-solid fa-location-dot"></i>
<?= htmlspecialchars($head_office['location']) ?>
</p>
</div>

</div>
</a>
</div>

</div>

<!-- ================= OFFICE GRID ================= -->
<div class="certification-grid">

<?php while($office = $offices->fetch_assoc()): ?>

<div class="cert-card">

<a href="office-details.php?id=<?= $office['id'] ?>" class="card-link">

<div class="cert-icon">
<img src="uploads/branches/<?= $office['hero_image'] ?>"
     alt="<?= htmlspecialchars($office['name']) ?>">
</div>

<div class="cert-details">

<h5><?= htmlspecialchars($office['name']) ?></h5>

<span class="cert-category">
<?= htmlspecialchars($office['type']) ?>
</span>

<p>
<i class="fa-solid fa-location-dot"></i>
<?= htmlspecialchars($office['location']) ?>
</p>

</div>
</a>

</div>

<?php endwhile; ?>

</div>

<!-- ================= ACHIEVEMENTS ================= -->
<div class="achievements-banner">

<div class="row text-center">

<div class="col-lg-3 col-sm-6">
<div class="achievement-item">
<i class="bi bi-building"></i>
<h3><?= $total_offices ?></h3>
<p>Active Offices</p>
</div>
</div>

<div class="col-lg-3 col-sm-6">
<div class="achievement-item">
<i class="bi bi-geo-alt"></i>
<h3>Isabela</h3>
<p>Province Coverage</p>
</div>
</div>

<div class="col-lg-3 col-sm-6">
<div class="achievement-item">
<i class="bi bi-people"></i>
<h3>1000+</h3>
<p>Served Members</p>
</div>
</div>

<div class="col-lg-3 col-sm-6">
<div class="achievement-item">
<i class="bi bi-clock-history"></i>
<h3>33+</h3>
<p>Years of Service</p>
</div>
</div>

</div>

</div>

</div>
</section>

<section id="team" class="team section">
  <div class="container section-title">
    <h2>OLLSMPC Team</h2>
    <p>Meet the dedicated members behind OLLSMPC</p>
  </div>

  <div class="container">
    <div class="row gy-4">

      <?php if ($featured && $featured->num_rows > 0): ?>
        <?php while ($row = $featured->fetch_assoc()): ?>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="team-card featured">
              <div class="team-header">
                <div class="team-image">
<img src="uploads/team/<?= htmlspecialchars($row['image']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($row['name']) ?>">                </div>
                <div class="team-info">
                  <h4><a href="staff-details.php?id=<?= (int)$row['id'] ?>" class="team-name-link"><?= htmlspecialchars($row['name']) ?></h4>
                  <span class="position"><?= htmlspecialchars($row['position']) ?></span>
                  <div class="contact-info">
                    <?php if (!empty($row['email'])): ?>
                    <a href="mailto:<?= $row['email'] ?>" class="text-decoration-none"><i class="bi bi-envelope"></i> cesarioaggalot@gmail.com</a>
                    <?php endif; ?>
                    <?php if (!empty($row['phone'])): ?>
                    <a href="tel:<?= $row['phone'] ?>" class="text-decoration-none"><i class="bi bi-telephone"></i> 0000 000 0000</a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="team-details">
                <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                <div class="credentials">
                  <div class="cred-item">
                    <i class="bi bi-award"></i>
                    <span>Contact Now</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>

        <?php if ($compact && $compact->num_rows > 0): ?>
        <?php while ($row = $compact->fetch_assoc()): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="team-card compact">
              <div class="member-photo">
                <img src="uploads/team/<?= htmlspecialchars($row['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($row['name']) ?>">
                <div class="hover-overlay">
                  <div class="overlay-content">
                    <h5><a href="staff-details.php?id=<?= (int)$row['id'] ?>" class="team-name-link"><?= htmlspecialchars($row['name']) ?></h5>
                    <span><?= htmlspecialchars($row['position']) ?></span>
                    <div class="quick-contact">
                      <a href="mailto:<?= $row['email'] ?>"><i class="bi bi-envelope"></i></a>
                      <a href="tel:<?= $row['phone'] ?>"><i class="bi bi-telephone"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="member-summary">
                <h5><?= htmlspecialchars($row['name']) ?></h5>
                <span><?= htmlspecialchars($row['position']) ?></span>
                <div class="skills">
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>

      <!-- ================= EMPTY STATE ================= -->
      <?php if (
        (!$featured || $featured->num_rows === 0) &&
        (!$compact || $compact->num_rows === 0)
      ): ?>
        <div class="col-12 text-center text-muted">
          <p>No team members available.</p>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>

<section id="call-to-action" class="call-to-action section light-background">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row g-5 align-items-center">

      <div class="col-lg-6">
        <div class="cta-hero-content" data-aos="fade-right" data-aos-delay="200">

          <div class="badge-wrapper">
            <span class="cta-badge">
              <i class="bi bi-headset"></i>
              OLLSMPC Support & Assistance
            </span>
          </div>

          <h2>Contact OLLSMPC</h2>

          <p>
            Have questions regarding membership, loans, technical support,
            or general cooperative services? Our team is ready to assist you.
            Reach out to us through the details below or send us an inquiry.
          </p>

<div id="ctaBranchSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

  <div class="carousel-inner">

    <!-- Branch 1 -->
    <div class="carousel-item active">
      <div class="feature-highlights">
        <div class="highlight-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>Main Office – Carreon St., Centro East, Santiago City</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-telephone-fill"></i>
          <span>0977-805-7365</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-clock-fill"></i>
          <span>Mon – Sat | 8:00 AM – 5:00 PM</span>
        </div>
      </div>
    </div>

    <!-- Branch 2 -->
    <div class="carousel-item">
      <div class="feature-highlights">
        <div class="highlight-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>Cordon Branch – Magsaysay, Cordon, Isabela</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-telephone-fill"></i>
          <span>0975-460-6428</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-clock-fill"></i>
          <span>Mon – Sat | 8:00 AM – 5:00 PM</span>
        </div>
      </div>
    </div>

    <!-- Branch 3 -->
    <div class="carousel-item">
      <div class="feature-highlights">
        <div class="highlight-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>Ramon Branch – Bugallon Proper, Ramon, Isabela</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-telephone-fill"></i>
          <span>0967-971-7207</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-clock-fill"></i>
          <span>Mon – Sat | 8:00 AM – 5:00 PM</span>
        </div>
      </div>
    </div>

    <!-- Branch 4 -->
    <div class="carousel-item">
      <div class="feature-highlights">
        <div class="highlight-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>Head Office - Divisoria, Santiago City</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-telephone-fill"></i>
          <span>0955-704-7434</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-clock-fill"></i>
          <span>Mon – Sat | 8:00 AM – 5:00 PM</span>
        </div>
      </div>
    </div>

    <!-- Branch 5 -->
    <div class="carousel-item">
      <div class="feature-highlights">
        <div class="highlight-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>Jones Branch – Barangay 1, Jones, Isabela</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-telephone-fill"></i>
          <span>0975-657-0184</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-clock-fill"></i>
          <span>Mon – Sat | 8:00 AM – 5:00 PM</span>
        </div>
      </div>
    </div>

    <!-- Branch 6 -->
    <div class="carousel-item">
      <div class="feature-highlights">
        <div class="highlight-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>San Mateo Branch - Malasin, San Mateo, Isabela</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-telephone-fill"></i>
          <span>0966-745-9878</span>
        </div>
        <div class="highlight-item">
          <i class="bi bi-clock-fill"></i>
          <span>Mon – Sat | 8:00 AM – 5:00 PM</span>
        </div>
      </div>
    </div>

  </div>

  <!-- Controls -->
  <button class="carousel-control-next" type="button"
          data-bs-target="#ctaBranchSlider" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>


        </div>
      </div>

      <div class="col-lg-6">
        <div class="cta-form-section" data-aos="fade-left" data-aos-delay="300">

          <div class="form-container">
            <div class="form-header">
              <h3>Send an Inquiry</h3>
              <p>We’ll get back to you as soon as possible</p>
            </div>
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

            <div class="form-actions mt-3">
              <button type="submit" class="btn btn-primary">
                Send Message <i class="bi bi-send-fill ms-2"></i>
              </button>
            </div>

          </form>

          </div>

          <div class="trust-indicators" data-aos="fade-up" data-aos-delay="400">
            <div class="row g-3">
              <div class="col-4">
                <div class="trust-item">
                  <i class="bi bi-envelope-fill"></i>
                  <span class="trust-label">Email Support</span>
                </div>
              </div>

              <div class="col-4">
                <div class="trust-item">
                  <i class="bi bi-people-fill"></i>
                  <span class="trust-label">Member-Focused</span>
                </div>
              </div>

              <div class="col-4">
                <div class="trust-item">
                  <i class="bi bi-shield-check"></i>
                  <span class="trust-label">Trusted Cooperative</span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

</section>

<section class="dedication">
  <div class="dedication-bg"
       style="background-image:url('assets/img/dedication.jpg');"></div>
  <div class="dedication-overlay"></div>
  <div class="dedication-content reveal"><br>
    <h2><br><br><br>In Dedication</h2>
    <p class="dedication-intro">
      This section is dedicated to the individuals whose commitment, service,
      and leadership helped shape the strength and integrity of OLLSMPC.
    </p>

    <div class="dedication-grid">

      <div class="dedication-card">
        <h4>Atty. Cesario A. Aggalo</h4>
        <span>Chairman</span>
        <p>
          Your dedication, integrity, and unwavering service continue to inspire
          our cooperative and its members. Your legacy remains a guiding light
          for future generations.
        </p>
      </div>

      <div class="dedication-card">
        <h4>Eralyn S. Reyes</h4>
        <span>Chief Executive Officer</span>
        <p>
          Through your leadership and commitment, you helped strengthen the
          foundation of OLLSMPC. Your contributions will always be remembered
          with gratitude and respect.
        </p>
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

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <script src="assets/js/main.js"></script>
<div class="floating-actions">

  <div class="floating-dot call-dot" title="Customer Support">
    <a href="contact-submit.php">🎧</a>
  </div>

  <div class="floating-dot menu-dot" id="menuToggle">
    ☰
  </div>

  <div class="floating-menu" id="floatingMenu">
    <a href="FAQ.php">Frequently Ask Questions</a>
    <a href="reviews.php">Reviews</a>
    <a href="AWARD/index.php">Awards</a>
    <a href="term.php">Term</a>
    <a href="Venue/index.php">Venue</a>
  </div>


</div>

<script>
  const menuToggle = document.getElementById("menuToggle");
  const floatingMenu = document.getElementById("floatingMenu");

  menuToggle.addEventListener("click", () => {
    floatingMenu.style.display =
      floatingMenu.style.display === "flex" ? "none" : "flex";
  });

  document.addEventListener("click", (e) => {
    if (!menuToggle.contains(e.target) && !floatingMenu.contains(e.target)) {
      floatingMenu.style.display = "none";
    }
  });
</script>
<script>
  const slides = document.querySelectorAll('.hero-slide');
  let index = 0;
  let startX = 0;
  let auto;

  function updateSlides() {
    slides.forEach(s => s.className = 'hero-slide');
    slides[index].classList.add('active');
    slides[(index + 1) % slides.length].classList.add('next');
    slides[(index - 1 + slides.length) % slides.length].classList.add('prev');
  }

  function nextSlide() {
    index = (index + 1) % slides.length;
    updateSlides();
  }

  function prevSlide() {
    index = (index - 1 + slides.length) % slides.length;
    updateSlides();
  }

  function startAuto() {
    auto = setInterval(nextSlide, 3000);
  }

  function stopAuto() {
    clearInterval(auto);
  }

  updateSlides();
  startAuto();

  const carousel = document.querySelector('.hero-carousel');

  carousel.addEventListener('touchstart', e => {
    startX = e.touches[0].clientX;
    stopAuto();
  });

  carousel.addEventListener('touchend', e => {
    let diff = e.changedTouches[0].clientX - startX;
    if (diff > 50) prevSlide();
    if (diff < -50) nextSlide();
    startAuto();
  });

  carousel.addEventListener('mousedown', e => {
    startX = e.clientX;
    stopAuto();
  });

  carousel.addEventListener('mouseup', e => {
    let diff = e.clientX - startX;
    if (diff > 50) prevSlide();
    if (diff < -50) nextSlide();
    startAuto();
  });
</script>
<script>
const slides = document.querySelectorAll('.hero-slide');
let index = 0;

function showSlide(i){

slides.forEach(slide => slide.classList.remove('active'));
slides[i].classList.add('active');

}

setInterval(() => {
index++;
if(index >= slides.length) index = 0;
showSlide(index);
}, 4000);
</script>



</body>

</html>