<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";

$venue_id = isset($_GET['venue']) ? intval($_GET['venue']) : 1;

/* ===============================
   FETCH VENUE
================================ */
$stmt = $conn->prepare("SELECT * FROM venues WHERE id=?");
$stmt->bind_param("i", $venue_id);
$stmt->execute();
$venue = $stmt->get_result()->fetch_assoc();

if (!$venue) {
    die("Venue not found.");
}

/* ===============================
   FETCH PRICES
================================ */
/* ===============================
   FETCH PRICES PER SECTION
================================ */

// MAIN HALL PRICES
$stmtMain = $conn->prepare("
    SELECT * FROM venue_prices 
    WHERE venue_id=? AND section='main'
    LIMIT 1
");
$stmtMain->bind_param("i", $venue_id);
$stmtMain->execute();
$mainPrices = $stmtMain->get_result()->fetch_assoc();

// If no row exists, prevent undefined warnings
if (!$mainPrices) {
    $mainPrices = [
        'four_hours' => 0,
        'eight_hours' => 0,
        'excess_per_hour' => 0,
        'projector_price' => 0,
        'sound_price' => 0,
        'aircon_text' => ''
    ];
}


// TRAINING CENTER PRICES
$stmtTraining = $conn->prepare("
    SELECT * FROM venue_prices 
    WHERE venue_id=? AND section='training'
    LIMIT 1
");
$stmtTraining->bind_param("i", $venue_id);
$stmtTraining->execute();
$trainingPrices = $stmtTraining->get_result()->fetch_assoc();

// If no row exists, prevent undefined warnings
if (!$trainingPrices) {
    $trainingPrices = [
        'four_hours' => 0,
        'eight_hours' => 0,
        'excess_per_hour' => 0,
        'projector_price' => 0,
        'sound_price' => 0,
        'aircon_text' => ''
    ];
}

/* ===============================
   FETCH IMAGES
================================ */
$images = [];

$stmt3 = $conn->prepare("SELECT * FROM venue_images WHERE venue_id=?");
$stmt3->bind_param("i", $venue_id);
$stmt3->execute();
$result = $stmt3->get_result();

while ($row = $result->fetch_assoc()) {
    $images[$row['image_type']][] = $row['image_path'];
}

$uploadPath = "uploads/venues/";
$placeholder = "assets/img/default.jpg";

/* ===============================
   SAFE IMAGE HELPERS
================================ */
$mainImage      = !empty($images['main'][0])      ? $uploadPath . $images['main'][0]      : $placeholder;
$secondaryImage = !empty($images['secondary'][0]) ? $uploadPath . $images['secondary'][0] : $placeholder;
$heroImage      = !empty($images['hero'][0])      ? $uploadPath . $images['hero'][0]      : $placeholder;

$cardImages     = [];
if (!empty($images['card'])) {
    foreach ($images['card'] as $img) {
        $cardImages[] = $uploadPath . $img;
    }
}

$galleryImages  = [];
if (!empty($images['gallery'])) {
    foreach ($images['gallery'] as $img) {
        $galleryImages[] = $uploadPath . $img;
    }
}

$section = "main";

$stmt3 = $conn->prepare("
    SELECT * FROM venue_images 
    WHERE venue_id=? AND section=?
");
$stmt3->bind_param("is", $venue_id, $section);
$stmt3->execute();
$result = $stmt3->get_result();

$mainImages = [];

while ($row = $result->fetch_assoc()) {
    $mainImages[$row['image_type']][] = $row['image_path'];
}


$section = "training";

$stmt4 = $conn->prepare("
    SELECT * FROM venue_images 
    WHERE venue_id=? AND section=?
");
$stmt4->bind_param("is", $venue_id, $section);
$stmt4->execute();
$result2 = $stmt4->get_result();

$trainingImages = [];

while ($row = $result2->fetch_assoc()) {
    $trainingImages[$row['image_type']][] = $row['image_path'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>OLLSMPC Rochdale Event Venue and Training Center</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
 <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">
  <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
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
            <li><a href="../index.php">Home</a></li>
            <li><a href="../about.php">About</a></li>
            <li><a href="../services.php">Services</a></li>
            <li><a href="../event.php">Events</a></li> 
            <li><a href="../team.php">Team</a></li>
            <li class="dropdown"><a href="#"><span>Others</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="../FAQ.php">Frequently Ask Questions</a></li>
                <li><a href="../reviews.php">Reviews</a></li>
                <li><a href="AWARD/index.php">Awards</a></li>
                <li><a href="../term.php">Term</a></li>
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



    <!-- About Home Section -->
    <section id="about1-home" class="about1-home section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-center">

          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            
  <div class="about1-content">

  <h2>Rochdale Event Venue & Training Center</h2>
  <p class="lead">
    From the glow of the lights to the warmth of the ambiance, OLLSMPC Events Venue is designed
    to turn ordinary gatherings into extraordinary celebrations.
  </p>

  <p class="text-secondary fw-semibold fst-italic mb-2">
    Rochdale Event Venue and Training Center is designed to accommodate both social and professional gatherings.
</p>



  <div class="stats-row">

    <div class="stat-item">
      <div class="stat-number">Spacious</div>
      <div class="stat-label">Modern Facilities</div>
    </div>

    <div class="stat-item">
      <div class="stat-number">Reliable</div>
      <div class="stat-label">Event Support</div>
    </div>

    <div class="stat-item">
      <div class="stat-number">Accessible</div>
      <div class="stat-label">Prime Location</div>
    </div>

  </div>

  <div class="about1-actions">
    <a href="../contact-submit.php" class="btn-secondary">Inquire Now</a>
  </div>

  
</div>




</div>

<!-- End About Content -->

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="about1-images">
              <div class="main-image">
                <img src="<?= $mainImage ?>" alt=" Main View" class="img-fluid">
              </div>
              <div class="secondary-image">
                <img src="<?= $secondaryImage ?>" alt="error" class="img-fluid">
              </div>
              
            </div>
          </div><!-- End About Images -->

        </div>

      </div>

    </section><!-- /About Home Section -->

    <!-- Rooms Showcase Section -->
    <section id="rooms-showcase" class="rooms-showcase section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Rochdale Event Venue</span>
        <h2>Rochdale Event Venue</h2>
        <p>Spacious and elegant venue</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5">
          <div class="col-xl-8" data-aos="zoom-in" data-aos-delay="200">
            <div class="hero-room-showcase">
              <div class="showcase-image-container">
                <img src="<?= !empty($mainImages['hero'][0]) 
        ? $uploadPath . $mainImages['hero'][0] 
        : $placeholder ?>" alt="Rochdale Main Function Hall" class="img-fluid">
                <div class="room-category-badge">
                  <span>Main Hall</span>
                </div>
                <div class="room-details-overlay">
                  <div class="room-specs">
                    <span class="spec-item">
                      <i class="bi bi-people"></i>
                      <span>Up to 150 Guests</span>
                    </span>
                    <span class="spec-item">
                      <i class="bi bi-house"></i>
                      <span>Spacious Layout</span>
                    </span>
                    <span class="spec-item">
                      <i class="bi bi-geo-alt"></i>
                      <span>Top Floor Location</span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="showcase-content">
                <div class="room-title-section">
                  <h2>Rochdale Main Function Hall</h2>
                  <div class="room-rating">
                    <div class="stars">
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                    </div>
                    <span class="rating-text">Highly Recommended Venue</span>
                  </div>
                </div>
                <p class="room-description">Our main function hall is ideal for weddings, birthdays, debuts, seminars, trainings, and large gatherings. It offers comfort, elegance, and flexibility to suit
              any type of event.</p>
                <div class="amenities-grid">
                  <div class="amenity-item">
                    <i class="bi bi-tv"></i>
                    <span>Projector & Screen (₱<?= number_format($mainPrices['projector_price']) ?>)</span>
                  </div>
                  <div class="amenity-item">
                    <i class="bi bi-mic"></i>
                    <span>Sound System (₱<?= number_format($mainPrices['sound_price']) ?>)</span>
                  </div>
                  <div class="amenity-item">
                    <i class="bi bi-snow"></i>
                    <span><?= htmlspecialchars($mainPrices['aircon_text']) ?></span>
                  </div>
                </div>
                <div class="booking-section">
                  <div class="price-display">
                    <span class="currency">₱</span>
                    <span class="amount"><?= number_format($mainPrices['four_hours']) ?></span>
                    <span class="period"> / 4 Hours</span>
                  </div>

                  
              <div class="price-display secondary">
                <span class="currency">₱</span>
                <span class="amount"><?= number_format($mainPrices['eight_hours']) ?></span>
                <span class="period"> / 8 Hours</span>
              </div>
                 <span class="excess-note">
                Excess Time: ₱<?= number_format($mainPrices['excess_per_hour']) ?> per hour
                 </span>
                </div>
              </div>
            </div>
          </div><!-- End Hero Room -->

<div class="col-xl-4">
  <div class="room-list-container">

    <!-- Main Hall View -->
    <div class="standard-room-card" data-aos="slide-left" data-aos-delay="200">

      <div class="card-image">
        <img src="<?= !empty($mainImages['card'][0]) 
        ? $uploadPath . $mainImages['card'][0] 
        : $placeholder ?>"
             alt="Rochdale Main Hall"
             class="img-fluid">
      </div>

      <div class="card-content ">
        <h4>Main Hall View</h4>
        <p>
          Wide and elegant space ideal for weddings,
          seminars, and grand celebrations.
        </p>
        <div class="features-list">
                    <span><i class="bi bi-people"></i>Group Friendly</span>
                    <span><i class="bi bi-controller"></i>Decor Friendly</span>
                  </div>
        
      </div>

    </div>


    <!-- Entrance & Accessibility -->
    <div class="standard-room-card" data-aos="slide-left" data-aos-delay="300">

      <div class="card-image">
        <img src="<?= !empty($mainImages['card'][1]) 
        ? $uploadPath . $mainImages['card'][1] 
        : $placeholder ?>"
             alt="Rochdale Entrance"
             class="img-fluid">
      </div>

      <div class="card-content ">
        <h4>Easy Access</h4>
        <p>
          Conveniently located along Maharlika Highway
          with easy access for guests.
        </p>

        <div class="features-list">
                    <span><i class="bi bi-geo-alt-fill"></i>Accessible</span>
                    <span><i class="bi bi-car-front"></i>Parking Available</span>
                  </div>
      </div>

    </div>


    <!-- Event Setup -->
    <div class="standard-room-card" data-aos="slide-left" data-aos-delay="400">

      <div class="card-image">
        <img src="<?= !empty($mainImages['card'][2]) 
        ? $uploadPath . $mainImages['card'][2] 
        : $placeholder ?>"
             alt="Rochdale Event Setup"
             class="img-fluid">
      </div>

      <div class="card-content ">
        <h4>Flexible Setup</h4>
        <p>
          Layouts can be arranged for formal,
          corporate, and social gatherings.
        </p>

        <div class="features-list">
                    <span><i class="bi bi-heart"></i>In any occasion</span>
                    <span><i class="bi bi-chevron-bar-contract"></i>Cuztomizable</span>
                  </div>
      </div>

      </div>

    </div>

  </div>
</div>


        </div>



         <section id="rooms-showcase" class="rooms-showcase section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Training Center</span>
        <h2>Training Center</h2>
        <p>Spacious and elegant venue</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5">
          <div class="col-xl-8" data-aos="zoom-in" data-aos-delay="200">
            <div class="hero-room-showcase">
              <div class="showcase-image-container">
                <img src="<?= !empty($trainingImages['hero'][0]) 
        ? $uploadPath . $trainingImages['hero'][0] 
        : $placeholder ?>" alt="Rochdale Main Function Hall" class="img-fluid">
                <div class="room-category-badge">
                  <span>Beside Rochdale</span>
                </div>
                <div class="room-details-overlay">
                  <div class="room-specs">
                    <span class="spec-item">
                      <i class="bi bi-people"></i>
                      <span>Up to 50 Guests</span>
                    </span>
                    <span class="spec-item">
                      <i class="bi bi-house"></i>
                      <span>Spacious Layout</span>
                    </span>
                    <span class="spec-item">
                      <i class="bi bi-geo-alt"></i>
                      <span>Top Floor</span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="showcase-content">
                <div class="room-title-section">
                  <h2>Training Center</h2>
                  <div class="room-rating">
                    <div class="stars">
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                    </div>
                    <span class="rating-text">Highly Recommended Training Venue</span>
                  </div>
                </div>
                <p class="room-description">Our Training Center is perfect for seminars, workshops, meetings, and learning sessions. Designed to provide a focused and productive environment, the space can be arranged for both small and medium-sized groups.</p>
                <div class="amenities-grid">
                  
                  <div class="amenity-item">
                    <i class="bi bi-tv"></i>
                    <span>Projector & Screen (₱<?= number_format($trainingPrices['projector_price']) ?>)</span>
                  </div>
                  <div class="amenity-item">
                    <i class="bi bi-mic"></i>
                    <span>Sound System (₱<?= number_format($trainingPrices['sound_price']) ?>)</span>
                  </div>
                  <div class="amenity-item">
                    <i class="bi bi-snow"></i>
                    <span><?= htmlspecialchars($trainingPrices['aircon_text']) ?></span>
                  </div>
                </div>
                <div class="booking-section">
                  <div class="price-display">
                    <span class="currency">₱</span>
                    <span class="amount"><?= number_format($trainingPrices['four_hours']) ?></span>
                    <span class="period"> / 4 Hours</span>
                  </div>

                  <div class="price-display">
                    <span class="currency">₱</span>
                    <span class="amount"><?= number_format($trainingPrices['eight_hours']) ?></span>
                    <span class="period"> / 8 Hours</span>
                  </div>

                  <span class="excess-note">Excess Time: ₱<?= number_format($trainingPrices['excess_per_hour']) ?> per hour</span>




                </div>
              </div>
            </div>
          </div><!-- End Hero Room -->

          <div class="col-xl-4">
            <div class="room-list-container">
              <div class="standard-room-card" data-aos="slide-left" data-aos-delay="250">
                <div class="card-image">
                  <img src="<?= !empty($trainingImages['card'][0]) 
        ? $uploadPath . $trainingImages['card'][0] 
        : $placeholder ?>" alt="Executive Room" class="img-fluid">
                  <div class="view-link">
                    <i class="bi bi-arrow-up-right"></i>
                  </div>
                </div>
                <div class="card-content">
                  <h4>Seminar & Meeting Setup</h4>
                 <p>Flexible layout for cooperative assemblies, corporate meetings, and educational sessions.</p>
              <div class="features-list">
                <span><i class="bi bi-briefcase"></i>Seminar Layout</span>
                <span><i class="bi bi-building"></i>Quiet Space</span>
                  </div>
                  
                </div>
              </div><!-- End Standard Room -->

              <div class="standard-room-card" data-aos="slide-left" data-aos-delay="300">
                <div class="card-image">
                  <img src="<?= !empty($trainingImages['card'][1]) 
        ? $uploadPath . $trainingImages['card'][1] 
        : $placeholder ?>" alt="Garden View" class="img-fluid">
                  <div class="view-link">
                    <i class="bi bi-arrow-up-right"></i>
                  </div>
                </div>
                <div class="card-content text-center">
              <h4>Workshops & Training</h4>
              <p>Designed for hands-on learning, interactive workshops, and skill development sessions.</p>
              <div class="features-list">
                <span><i class="bi bi-tools"></i>Interactive Setup</span>
                <span><i class="bi bi-lightbulb"></i>Engaging Environment</span>
              </div>
                  
                </div>
              </div><!-- End Standard Room -->

              <div class="standard-room-card" data-aos="slide-left" data-aos-delay="350">
                <div class="card-image">
                  <img src="<?= !empty($trainingImages['card'][2]) 
        ? $uploadPath . $trainingImages['card'][2] 
        : $placeholder ?>" alt="Celebration Setup" class="img-fluid">
                  <div class="view-link">
                    <i class="bi bi-arrow-up-right"></i>
                  </div>
                </div>
                <div class="card-content text-center">
              <h4>Technology & Support</h4>
              <p>High-quality AV equipment, WiFi, and staff assistance to ensure smooth learning sessions.</p>
              <div class="features-list">
                <span><i class="bi bi-tv"></i>Projector & Screen</span>
                <span><i class="bi bi-mic"></i>Sound System</span>
              </div>
                  </div>
                 
                </div>
              </div><!-- End Standard Room -->

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Location Cards Section -->

    <!-- Gallery Showcase Section -->
    <section id="gallery-showcase" class="gallery-showcase section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="gallery-carousel swiper init-swiper" data-aos="fade-up" data-aos-delay="200">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 1000
              },
              "slidesPerView": 1,
              "spaceBetween": 20,
              "centeredSlides": true,
              "breakpoints": {
                "576": {
                  "slidesPerView": 2,
                  "centeredSlides": false
                },
                "768": {
                  "slidesPerView": 3,
                  "centeredSlides": false
                },
                "992": {
                  "slidesPerView": 4,
                  "centeredSlides": false
                },
                "1200": {
                  "slidesPerView": 5,
                  "centeredSlides": false
                }
              }
            }
          </script>
          <div class="swiper-wrapper">
            <?php if (!empty($images['gallery'])): ?>
    <?php foreach ($images['gallery'] as $gallery): ?>
            <div class="swiper-slide">
              <div class="gallery-item">
                <img src="<?= $uploadPath . $gallery ?>" class="img-fluid" loading="lazy">
                <a href="<?= $uploadPath . $gallery ?>" class="gallery-overlay glightbox">
                    <i class="bi bi-eye"></i>
                </a>
              </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
          </div>
        </div>
      </div>

    </section><!-- /Gallery Showcase Section -->

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
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>