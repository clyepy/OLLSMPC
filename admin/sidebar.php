<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
  overflow: hidden;
}

/* ===== SIDEBAR ===== */
.sidebar {
  width: 280px;
  background: linear-gradient(180deg, var(--primary), #00325f);
  color: #fff;
  padding: 1.5rem 1rem;
  display: flex;
  flex-direction: column;
  height: 100vh;
}

/* BRAND */
.brand {
  font-size: 1.6rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 1.5rem;
  letter-spacing: 1px;
  flex-shrink: 0;
}

/* MENU */
.menu {
  flex: 1;
  overflow-y: auto;   /* vertical scroll */
  overflow-x: hidden; /* no horizontal scroll */
}


/* Scrollbar (optional, subtle) */
.menu::-webkit-scrollbar {
  width: 6px;
}
.menu::-webkit-scrollbar-thumb {
  background: rgba(255,255,255,.25);
  border-radius: 10px;
}

/* HEADERS */
.menu h4 {
  font-size: .70rem;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: rgba(255,255,255,.6);
  margin: 1.2rem 0 .5rem;
}

/* LINKS */
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

/* LOGOUT */
.menu a.logout {
  margin-top: auto; /* 🔑 pushes it to bottom */
  background: rgba(255, 255, 255, 0.12);
}

.menu a.logout:hover {
  background: rgba(255, 255, 255, 0.25);
}
</style>
</head>

<body>

<aside class="sidebar">
  <div class="brand">OLLSMPC Admin</div>

  <nav class="menu">
    <a class="active" href="admin-panel.php"><i class="bi bi-speedometer2"></i> Dashboard</a>

    <h4>General</h4>
    <a href="settings.php"><i class="bi bi-gear"></i> Settings</a>
    <a href="messages.php"><i class="bi bi-chat-dots"></i> Messages</a>

    <h4>Content Management</h4>
    <a href="manage-homepage.php"><i class="bi bi-list-check"></i> Manage Homepage</a>
    <a href="review.php"><i class="bi bi-star"></i> Manage Reviews</a>
    <a href="events.php"><i class="bi bi-calendar-event"></i> Manage Events</a>
    <a href="teams.php"><i class="bi bi-people"></i> Manage Teams</a>
    <a href="staff.php"><i class="bi bi-person-badge"></i> Staff Profiles</a>
    <a href="manage_service.php"><i class="bi bi-tools"></i> Manage Services</a>
    <a href="branches-details.php"><i class="bi bi-geo-alt"></i> Manage Branches</a>
    <a href="manage_venue.php"><i class="bi bi-building"></i> Manage Event Venue</a>
    <a href="manage_news.php"><i class="bi bi-newspaper"></i> Manage News</a>
<br>
    <a href="index.php" class="logout">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </nav>
</aside>

</body>
</html>
