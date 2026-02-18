<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
$pageTitle = "Manage Venue";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$venue_id = isset($_GET['venue']) ? intval($_GET['venue']) : 1;

/* ===============================
   LOAD VENUE LIST
================================ */

$venueList = $conn->query("SELECT id,name FROM venues ORDER BY id ASC");

/* ===============================
   FETCH VENUE DATA
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

// MAIN HALL PRICES
$stmtMain = $conn->prepare("
    SELECT * FROM venue_prices 
    WHERE venue_id=? AND section='main'
");
$stmtMain->bind_param("i", $venue_id);
$stmtMain->execute();
$mainPrices = $stmtMain->get_result()->fetch_assoc();

// TRAINING CENTER PRICES
$stmtTraining = $conn->prepare("
    SELECT * FROM venue_prices 
    WHERE venue_id=? AND section='training'
");
$stmtTraining->bind_param("i", $venue_id);
$stmtTraining->execute();
$trainingPrices = $stmtTraining->get_result()->fetch_assoc();


/* ===============================
   UPDATE VENUE INFO
================================ */

if (isset($_POST['update_venue'])) {

    $stmt = $conn->prepare("
        UPDATE venues SET
            name=?,
            subtitle=?,
            description=?,
            capacity=?,
            location_text=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssi",
        $_POST['name'],
        $_POST['subtitle'],
        $_POST['description'],
        $_POST['capacity'],
        $_POST['location_text'],
        $venue_id
    );

    $stmt->execute();
    header("Location: manage_venue.php?venue=$venue_id");
    exit;
}

/* ===============================
   UPDATE PRICES
================================ */
/* ===============================
   UPDATE PRICES (SAFE UPSERT)
================================ */

if (isset($_POST['update_prices'])) {

    $section = $_POST['section'];

    // 1️⃣ Check if row exists
    $check = $conn->prepare("
        SELECT id FROM venue_prices 
        WHERE venue_id=? AND section=?
        LIMIT 1
    ");
    $check->bind_param("is", $venue_id, $section);
    $check->execute();
    $exists = $check->get_result()->fetch_assoc();

    if ($exists) {

        // 2️⃣ UPDATE if exists
        $stmt = $conn->prepare("
            UPDATE venue_prices SET
                four_hours=?,
                eight_hours=?,
                excess_per_hour=?,
                projector_price=?,
                sound_price=?,
                aircon_text=?
            WHERE venue_id=? AND section=?
        ");

        $stmt->bind_param(
            "ddddssis",
            $_POST['four_hours'],
            $_POST['eight_hours'],
            $_POST['excess_per_hour'],
            $_POST['projector_price'],
            $_POST['sound_price'],
            $_POST['aircon_text'],
            $venue_id,
            $section
        );

    } else {

        // 3️⃣ INSERT if not exists
        $stmt = $conn->prepare("
            INSERT INTO venue_prices
            (venue_id, section, four_hours, eight_hours, excess_per_hour, projector_price, sound_price, aircon_text)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "isddddss",
            $venue_id,
            $section,
            $_POST['four_hours'],
            $_POST['eight_hours'],
            $_POST['excess_per_hour'],
            $_POST['projector_price'],
            $_POST['sound_price'],
            $_POST['aircon_text']
        );
    }

    $stmt->execute();

    header("Location: manage_venue.php?venue=$venue_id");
    exit;
}


/* ===============================
   UPLOAD IMAGE
================================ */

if (isset($_POST['upload_image']) && !empty($_FILES['image']['name'])) {

    $dir = "../Venue/uploads/venues/";
    if (!file_exists($dir)) mkdir($dir, 0755, true);

    $file = time() . "_" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $dir . $file);

    $section = $_POST['section'] ?? '';
    $image_type = $_POST['image_type'] ?? '';

    if ($section === '' || $image_type === '') {
        die("Section or Image Type missing.");
    }

    $stmt = $conn->prepare("
        INSERT INTO venue_images 
        (venue_id, image_path, image_type, section)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isss",
        $venue_id,
        $file,
        $image_type,
        $section
    );

    $stmt->execute();

    header("Location: manage_venue.php?venue=$venue_id");
    exit;
}



/* ===============================
   DELETE IMAGE
================================ */

if (isset($_GET['delete_image'])) {

    $img_id = intval($_GET['delete_image']);

    $stmt = $conn->prepare("SELECT image_path FROM venue_images WHERE id=? AND venue_id=?");
    $stmt->bind_param("ii", $img_id, $venue_id);
    $stmt->execute();
    $img = $stmt->get_result()->fetch_assoc();

    if ($img) {
        @unlink("../Venue/uploads/venues/" . $img['image_path']);

        $stmt = $conn->prepare("DELETE FROM venue_images WHERE id=?");
        $stmt->bind_param("i", $img_id);
        $stmt->execute();
    }

    header("Location: manage_venue.php?venue=$venue_id");
    exit;
}

/* ===============================
   LOAD IMAGES
================================ */

$images = $conn->prepare("SELECT * FROM venue_images WHERE venue_id=?");
$images->bind_param("i", $venue_id);
$images->execute();
$images = $images->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Venue Manager</title>
 <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --primary: #2563eb;
    --primary-dark: #1e40af;
    --bg: #f1f5f9;
    --card: rgba(255,255,255,0.75);
    --border: #e2e8f0;
    --text: #0f172a;
    --muted: #64748b;
    --danger: #ef4444;
}

/* ===== BASE ===== */
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #e2e8f0, #f8fafc);
    color: var(--text);
    display: flex;
    min-height: 100vh;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 260px;
    background: linear-gradient(180deg, #0f172a, #1e293b);
    color: white;
    padding: 30px 20px;
}

/* ===== MAIN ===== */
.main {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.topbar {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    padding: 20px 35px;
    border-bottom: 1px solid var(--border);
}

.content {
    flex: 1;
    padding: 40px;
    overflow-y: auto;
}

/* ===== TITLE ===== */
.content h2 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 35px;
}

/* ===== CARD ===== */
.card {
    border: 1px solid var(--border) !important;
    border-radius: 22px !important;
    background: var(--card);
    backdrop-filter: blur(14px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    transition: 0.3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.08);
}

.card-body {
    padding: 35px !important;
}

.card h5 {
    font-size: 17px;
    font-weight: 600;
    margin-bottom: 25px;
}

/* ===== FORM ===== */
.form-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    margin-bottom: 6px;
}

.form-control,
.form-select {
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 12px 15px;
    font-size: 14px;
    transition: all .2s ease;
    background: #ffffff;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
}

/* ===== BUTTONS ===== */
.btn {
    border-radius: 14px;
    font-weight: 500;
    padding: 10px 20px;
    transition: 0.2s ease;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(37,99,235,.25);
}

.btn-dark {
    background: #0f172a;
    border: none;
}

.btn-dark:hover {
    background: #1e293b;
}

.btn-danger {
    background: var(--danger);
    border: none;
    color: #ffffff
}

.btn-danger:hover {
    background: #dc2626;
}

/* ===== IMAGE GRID ===== */
.image-card {
    border-radius: 20px;
    overflow: hidden;
    background: white;
    box-shadow: 0 8px 30px rgba(0,0,0,.07);
    transition: 0.3s ease;
}

.image-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,.12);
}

.image-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.image-card-body {
    padding: 20px;
    text-align: center;
}

.badge {
    background: rgba(37,99,235,.1);
    color: var(--primary-dark);
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
}
  .sidebar {
    width: 280px;
    background: linear-gradient(180deg, var(--primary), #00325f);
    color: #fff;
    padding: 1.5rem 1rem;
    display: flex;
    flex-direction: column;
  }

  .brand {
    font-size: 1.6rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 2rem;
    letter-spacing: 1px;
    color: #fff;
  }

  .menu {
    flex: 1;
  }

  .menu h4 {
    font-size: .70rem;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: rgba(255,255,255,.6);
    margin: 1.2rem 0 .5rem;
  }

  .menu a {
    display: flex;
    gap: .60rem;
    padding: .60rem 1rem;
    margin-bottom: .3rem;
    border-radius: 12px;
    color: #fff;
    text-decoration: none;
    font-size: .95rem;
    transition: background .25s, transform .2s;
  }

  .menu a:hover,
  .menu a.active {
    background: rgba(255,255,255,.2);
    transform: translateX(5px);
  }

  /* ===== MAIN ===== */
  .main {
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .topbar {
    background: var(--surface);
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
  }

    a {
  text-decoration: none;
}

  .topbar h2 {
    margin: 0;
    font-size: 1.4rem;
  }

  .user {
    display: flex;
    align-items: center;
    gap: .75rem;
  }

  .avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--primary);
    display: grid;
    place-items: center;
    font-weight: 600;
    color: #fff;
  }

</style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<main class="main">
    <?php include 'header.php'; ?>
<div class="content">

<div class="container-fluid">

  <div class="row g-4">
<form method="POST" enctype="multipart/form-data"> 

    <!-- ================= PRICES ================= -->
    <br><div class="col-lg-6">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
          <h5 class="fw-semibold mb-3">
            <i class="bi bi-cash-stack me-2 text-primary"></i> Edit Prices
          </h5>

          <form method="POST">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label small">Section</label>
                <select name="section" class="form-select" required>
                  <option value="">Select Section</option>
                  <option value="main">Main Hall</option>
                  <option value="training">Training Center</option>
                </select>
              </div>
              <div class="col-6">
                <label class="form-label small">4 Hours</label>
                <input type="number" step="0.01" name="four_hours" class="form-control"
                  value="<?= $prices['four_hours'] ?>">
              </div>

              <div class="col-6">
                <label class="form-label small">8 Hours</label>
                <input type="number" step="0.01" name="eight_hours" class="form-control"
                  value="<?= $prices['eight_hours'] ?>">
              </div>

              <div class="col-6">
                <label class="form-label small">Excess per Hour</label>
                <input type="number" step="0.01" name="excess_per_hour" class="form-control"
                  value="<?= $prices['excess_per_hour'] ?>">
              </div>

              <div class="col-6">
                <label class="form-label small">Projector Price</label>
                <input type="number" step="0.01" name="projector_price" class="form-control"
                  value="<?= $prices['projector_price'] ?>">
              </div>

              <div class="col-6">
                <label class="form-label small">Sound Price</label>
                <input type="number" step="0.01" name="sound_price" class="form-control"
                  value="<?= $prices['sound_price'] ?>">
              </div><br>

              <div class="col-12 text-end">
                <button name="update_prices" class="btn btn-primary px-4 rounded-3">
                  Update Prices
                </button>
              </div>

            </div>
          </form>

        </div>
      </div>
    </div>

    <!-- ================= IMAGE UPLOAD ================= -->
    <div class="col-lg-6">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
          <h5 class="fw-semibold mb-3">
            <i class="bi bi-image me-2 text-primary"></i> Upload Image
          </h5>

          <form method="POST" enctype="multipart/form-data">
            <div class="row g-3">

              <div class="col-12">
                <label class="form-label small">Section</label>
                <select name="section" class="form-select" required>
                  <option value="">Select Section</option>
                  <option value="main">Main Hall</option>
                  <option value="training">Training Center</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label small">Image Type</label>
                <select name="image_type" class="form-select" required>
                  <option value="">Select Type</option>
                  <option value="main">Main</option>
                  <option value="secondary">Secondary</option>
                  <option value="hero">Hero</option>
                  <option value="card">Card</option>
                  <option value="gallery">Gallery</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label small">Choose Image</label>
                <input type="file" name="image" class="form-control" required>
              </div><br>

              <div class="col-12 text-end">
                <button name="upload_image"  class="btn btn-primary px-4 rounded-3">
                  Upload Image
                </button>
              </div>

            </div>
          </form>

        </div>
      </div>
    </div>

  </div>

  <!-- ================= IMAGE LIST ================= -->
  <div class="card shadow-sm border-0 rounded-4 mt-4">
    <div class="card-body p-4">
      <h5 class="fw-semibold mb-4">
        <i class="bi bi-collection me-2 text-primary"></i> Existing Images
      </h5>

      <div class="row g-4">
        <?php while($img=$images->fetch_assoc()): ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
    <div class="image-card">

            <img src="../Venue/uploads/venues/<?= $img['image_path'] ?>"
              class="img-fluid"
              style="height:200px; object-fit:cover;">

 <div class="image-card-body">
            <div class="badge mb-3">
                <?= ucfirst($img['image_type']) ?>
            </div><br>

            <div>
                <a href="?venue=<?= $venue_id ?>&delete_image=<?= $img['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete image?')">
                    <i class="bi bi-trash"></i> Delete
                </a>
            </div>

          </div>
        </div>
        <?php endwhile; ?>
      </div>

</body>
</html>
