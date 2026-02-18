<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$pageTitle = "Dashboard";

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OLLSMPC Admin - <?= $pageTitle; ?></title>
   <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --primary: #004a8f;
    --secondary: #f4f7fb;
    --surface: #ffffff;
    --accent: #f0b429;
    --text: #1f2937;
    --muted: #6b7280;
    --radius: 16px;
    --shadow: rgba(0,0,0,0.12);
  }

  * { box-sizing: border-box; }
  body {
    margin: 0;
    font-family: 'Inter', system-ui, sans-serif;
    background: var(--secondary);
    color: var(--text);
    display: flex;
    height: 100vh;
  }

  /* ===== SIDEBAR ===== */
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
    box-shadow: 0 6px 20px var(--shadow);
    z-index: 10;
  }

  .topbar h2 {
    margin: 0;
    font-size: 1.6rem;
    color: var(--primary);
  }

  .user {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--primary);
    display: grid;
    place-items: center;
    font-weight: 600;
    color: #fff;
    font-size: 1rem;
  }

  .content {
    padding: 2.5rem;
    overflow-y: auto;
    flex: 1;
  }

  /* ===== DASHBOARD CARDS ===== */
  .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.8rem;
    margin-bottom: 2rem;
  }

  .card {
    background: linear-gradient(145deg, #ffffff, #e6f0ff);
    padding: 1.6rem;
    border-radius: var(--radius);
    box-shadow: 0 6px 18px var(--shadow);
    transition: transform .25s, box-shadow .25s;
    cursor: pointer;
  }

  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px var(--shadow);
  }

  .card .icon {
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: .6rem;
  }

  .card h4 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--primary);
  }

  .card p {
    margin: .3rem 0 0;
    font-size: .9rem;
    color: var(--muted);
  }

  /* ===== BUTTONS ===== */
  .btn {
    background: var(--primary);
    color: #fff;
    border: none;
    padding: .65rem 1.3rem;
    border-radius: 14px;
    cursor: pointer;
    font-size: .95rem;
    transition: background .2s, transform .2s;
  }

  .btn:hover {
    background: #00325f;
    transform: translateY(-2px);
  }

  .btn.secondary {
    background: var(--accent);
    color: #000;
  }
  .card-link {
  text-decoration: none;
  color: inherit;
}

</style>
</head>
<body>
  <?php include 'sidebar.php'; ?>

  <main class="main">
    <?php include 'header.php'; ?>

    <section class="content">
      <h3>Welcome to OLLSMPC Admin Panel</h3>
      <p>Select an option from the sidebar to manage content.</p>

      <!-- ===== Dashboard Cards ===== -->
<div class="cards">
  <a href="manage-homepage.php" class="card-link">
    <div class="card">
      <div class="icon"><i class="bi bi-house-door"></i></div>
      <h4>Homepage</h4>
      <p>Update homepage content</p>
    </div>
  </a>

  <a href="manage_service.php" class="card-link">
    <div class="card">
      <div class="icon"><i class="bi bi-list-task"></i></div>
      <h4>Services</h4>
      <p>Manage services content</p>
    </div>
  </a>

  <a href="branches-details.php" class="card-link">
    <div class="card">
      <div class="icon"><i class="bi bi-geo-alt"></i></div>
      <h4>Branches</h4>
      <p>Manage branch offices</p>
    </div>
  </a>

  <a href="staff.php" class="card-link">
    <div class="card">
      <div class="icon"><i class="bi bi-person-badge"></i></div>
      <h4>Teams</h4>
      <p>Manage staff profiles</p>
    </div>
  </a>

  <a href="events.php" class="card-link">
    <div class="card">
      <div class="icon"><i class="bi bi-megaphone"></i></div>
      <h4>Events</h4>
      <p>Update events content</p>
    </div>
  </a>

  <a href="review.php" class="card-link">
    <div class="card">
      <div class="icon"><i class="bi bi-chat-left-text"></i></div>
      <h4>Reviews</h4>
      <p>Manage member reviews</p>
    </div>
  </a>

    <a href="manage_venue.php" class="card-link">
    <div class="card">
      <div class="icon"><i class="bi bi-building"></i></div>
      <h4>Venue</h4>
      <p>Manage Event Venue</p>
    </div>
  </a>
</div>
    </section>
  </main>
</body>
</html>
