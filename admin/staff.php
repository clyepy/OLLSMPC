<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
$pageTitle = "Manage Profiles";
session_start();


if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

/* =========================
   HANDLE SELECTION
========================= */
$staff_id = isset($_GET['staff_id']) ? (int)$_GET['staff_id'] : null;
$staff = null;

if ($staff_id) {
  $stmt = $conn->prepare("SELECT * FROM team_members WHERE id=?");
  $stmt->bind_param("i", $staff_id);
  $stmt->execute();
  $staff = $stmt->get_result()->fetch_assoc();
}

/* =========================
   UPDATE STAFF
========================= */
if (isset($_POST['update_staff'])) {

  $id = (int)$_POST['id'];
  $image = $_POST['current_image'];

  if (!empty($_FILES['image']['name'])) {
    $image = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/team/" . $image);
  }

  $stmt = $conn->prepare("
    UPDATE team_members SET
      name=?, position=?, department=?, email=?, phone=?,
      years_of_service=?, status=?, office=?,
      intro=?, description=?, background=?,
      responsibilities=?, qualifications=?, commitment=?,
      role_type=?, sort_order=?, image=?
    WHERE id=?
  ");

  $stmt->bind_param(
    "sssssisssssssssisi",
    $_POST['name'],
    $_POST['position'],
    $_POST['department'],
    $_POST['email'],
    $_POST['phone'],
    $_POST['years_of_service'],
    $_POST['status'],
    $_POST['office'],
    $_POST['intro'],
    $_POST['description'],
    $_POST['background'],
    $_POST['responsibilities'],
    $_POST['qualifications'],
    $_POST['commitment'],
    $_POST['role_type'],
    $_POST['sort_order'],
    $image,
    $id
  );

  $stmt->execute();
  header("Location: staff.php?staff_id=" . $id);
  exit;
}

/* =========================
   DELETE STAFF
========================= */
if (isset($_POST['delete_staff'])) {
  $id = (int)$_POST['id'];
  $conn->query("DELETE FROM team_members WHERE id=$id");
  header("Location: staff.php");
  exit;
}

/* =========================
   STAFF LIST
========================= */
$staff_list = $conn->query("
  SELECT id, name, position, image
  FROM team_members
  ORDER BY role_type, sort_order, name
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Staff Admin</title>
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
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
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

  .content {
    padding: 2rem;
    overflow-y: auto;
    flex: 1;
  }

  .btn {
    background: var(--primary);
    color: #fff;
    border: none;
    padding: .6rem 1.2rem;
    border-radius: 10px;
    cursor: pointer;
    font-size: .9rem;
  }

  .btn.secondary {
    background: var(--accent);
    color: #000;
  }
.card h3 {
  margin-bottom: 1rem;
  color: var(--primary);
}

.event-form .form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 1rem;
}

.event-form label {
  font-weight: 600;
  margin-bottom: .25rem;
}

.event-form input[type="text"],
.event-form input[type="date"],
.event-form textarea,
.event-form input[type="file"] {
  padding: .5rem;
  border-radius: 8px;
  border: 1px solid #d1d5db;
  font-size: .9rem;
}

.event-form textarea {
  resize: vertical;
}

.event-form .btn {
  margin-top: 1rem;
  background: var(--primary);
  color: #fff;
  border-radius: 10px;
  padding: .6rem 1.2rem;
  font-size: .95rem;
  cursor: pointer;
  border: none;
  transition: background .2s;
}

.event-form .btn:hover {
  background: #00325f;
}

    .container {
        max-width: 950px;
        margin: auto;
        background: #ffffff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    h1 {
        margin-bottom: 20px;
        color: #333;
    }

    .add-btn {
        display: inline-block;
        margin-bottom: 15px;
        padding: 10px 15px;
        background: #fbfbfc;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
    }

    .add-btn:hover {
        background: #ffffff;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
    }

    th {
        background: #f1f3f6;
        color: #333;
        font-weight: 600;
        border-bottom: 2px solid #ddd;
    }

    tr {
        border-bottom: 1px solid #eee;
    }

    tr:hover {
        background: #fafafa;
    }

    .actions a {
        text-decoration: none;
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 4px;
        margin-right: 5px;
    }

    .edit-btn {
        background: #ffc107;
        color: #000;
    }

    .edit-btn:hover {
        background: #e0a800;
    }

    .delete-btn {
        background: #dc3545;
        color: #fff;
    }

    .delete-btn:hover {
        background: #b52a37;
    }

    .empty {
        text-align: center;
        padding: 20px;
        color: #777;
    }
    .staff-layout {
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 1.5rem;
}

/* LEFT PANEL */
.staff-list {
  background: var(--surface);
  border-radius: var(--radius);
  padding: 1rem;
  height: calc(100vh - 180px);
  display: flex;
  flex-direction: column;
}

.staff-items {
  overflow-y: auto;
  margin-top: .75rem;
}

.staff-item {
  display: flex;
  gap: .75rem;
  padding: .6rem;
  border-radius: 10px;
  text-decoration: none;
  color: var(--text);
  align-items: center;
  transition: background .2s;
}

.staff-item:hover {
  background: #f1f5f9;
}

.staff-item.active {
  background: rgba(0,74,143,.1);
}

.staff-avatar {
  width: 42px;
  height: 50px;
  border-radius: 50%;
  background: var(--primary);
  color: #fff;
  display: grid;
  place-items: center;
  font-weight: 600;
}

.staff-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

.staff-item small {
  display: block;
  color: var(--muted);
}

/* RIGHT PANEL */
.staff-card {
  background: var(--surface);
  border-radius: var(--radius);
  padding: 1.5rem;
}

.card-header {
  border-bottom: 1px solid #e5e7eb;
  margin-bottom: 1.2rem;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.form-grid .full {
  grid-column: 1 / -1;
}

.form-grid label {
  font-weight: 600;
  font-size: .85rem;
  margin-bottom: .25rem;
  display: block;
}

.form-grid input,
.form-grid select,
.form-grid textarea {
  width: 100%;
  padding: .55rem;
  border-radius: 8px;
  border: 1px solid #d1d5db;
}

.image-row {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.preview {
  height: 70px;
  border-radius: 10px;
}

.card-actions {
  margin-top: 1.5rem;
  display: flex;
  gap: 1rem;
}

.btn.primary {
  background: var(--primary);
  color: #fff;
}

.btn.danger {
  background: #dc2626;
  color: #fff;
}

.empty-state {
  background: var(--surface);
  padding: 2rem;
  border-radius: var(--radius);
  text-align: center;
  color: var(--muted);
}
</style>
</head>

<body>
<?php include 'sidebar.php'; ?>
<main class="main">
<?php include 'header.php'; ?>

<section class="content">
<div class="staff-layout">

<!-- LEFT PANEL -->
<aside class="staff-list">
<h4>Team Members</h4>

<div class="staff-items">
<?php while ($s = $staff_list->fetch_assoc()): ?>
<a href="?staff_id=<?= $s['id'] ?>"
   class="staff-item <?= ($staff_id == $s['id']) ? 'active' : '' ?>">

<div class="staff-avatar">
<?php if ($s['image']): ?>
<img src="../uploads/team/<?= htmlspecialchars($s['image']) ?>">
<?php else: ?>
<?= strtoupper(substr($s['name'], 0, 1)) ?>
<?php endif; ?>
</div>

<div>
<strong><?= htmlspecialchars($s['name']) ?></strong>
<small><?= htmlspecialchars($s['position']) ?></small>
</div>
</a>
<?php endwhile; ?>
</div>
</aside>

<!-- RIGHT PANEL -->
<div class="staff-editor">

<?php if ($staff): ?>
<form method="POST" enctype="multipart/form-data" class="staff-card">

<input type="hidden" name="id" value="<?= $staff['id'] ?>">
<input type="hidden" name="current_image" value="<?= $staff['image'] ?>">

<div class="card-header">
<h3>Edit Staff Member</h3>
</div>

<div class="form-grid">

<div>
<label>Name</label>
<input name="name" value="<?= htmlspecialchars($staff['name']) ?>" required>
</div>

<div>
<label>Position</label>
<input name="position" value="<?= htmlspecialchars($staff['position']) ?>">
</div>

<div>
<label>Email</label>
<input name="email" value="<?= htmlspecialchars($staff['email']) ?>">
</div>

<div>
<label>Phone</label>
<input name="phone" value="<?= htmlspecialchars($staff['phone']) ?>">
</div>

<div>
<label>Department</label>
<input name="department" value="<?= htmlspecialchars($staff['department']) ?>">
</div>

<div>
<label>Years of Service</label>
<input type="number" name="years_of_service" value="<?= (int)$staff['years_of_service'] ?>">
</div>

<div>
<label>Status</label>
<select name="status">
<option value="Active" <?= $staff['status']=="Active"?'selected':'' ?>>Active</option>
<option value="Inactive" <?= $staff['status']=="Inactive"?'selected':'' ?>>Inactive</option>
</select>
</div>

<div>
<label>Office</label>
<input name="office" value="<?= htmlspecialchars($staff['office']) ?>">
</div>

<div class="full">
<label>Intro</label>
<textarea name="intro"><?= htmlspecialchars($staff['intro']) ?></textarea>
</div>

<div class="full">
<label>Description</label>
<textarea name="description"><?= htmlspecialchars($staff['description']) ?></textarea>
</div>

<div class="full">
<label>Background</label>
<textarea name="background"><?= htmlspecialchars($staff['background']) ?></textarea>
</div>

<div class="full">
<label>Responsibilities</label>
<textarea name="responsibilities"><?= htmlspecialchars($staff['responsibilities']) ?></textarea>
</div>

<div class="full">
<label>Qualifications</label>
<textarea name="qualifications"><?= htmlspecialchars($staff['qualifications']) ?></textarea>
</div>

<div class="full">
<label>Commitment</label>
<textarea name="commitment"><?= htmlspecialchars($staff['commitment']) ?></textarea>
</div>

<div>
<label>Role Type</label>
<select name="role_type">
<option value="featured" <?= $staff['role_type']=="featured"?'selected':'' ?>>Featured</option>
<option value="compact" <?= $staff['role_type']=="compact"?'selected':'' ?>>Compact</option>
</select>
</div>

<div>
<label>Sort Order</label>
<input type="number" name="sort_order" value="<?= (int)$staff['sort_order'] ?>">
</div>

<div class="full image-upload">
<label>Profile Photo</label>
<div class="image-row">
<?php if ($staff['image']): ?>
<img src="../uploads/team/<?= htmlspecialchars($staff['image']) ?>" class="preview">
<?php endif; ?>
<input type="file" name="image">
</div>
</div>

</div>

<div class="card-actions">
<button name="update_staff" class="btn primary">Save Changes</button>
<button name="delete_staff"
        onclick="return confirm('Delete this staff member?')"
        class="btn danger">
Delete
</button>
</div>

</form>

<?php else: ?>
<div class="empty-state">
Select a staff member to manage.
</div>
<?php endif; ?>

</div>
</div>
</section>
</main>
</body>
</html>
