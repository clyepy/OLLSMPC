<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include "../connection.php";
$pageTitle = "Manage Members";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$action = $_GET['action'] ?? 'list';
$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* =========================
   DELETE
========================= */
if ($action === 'delete' && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM team_members WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: teams.php");
    exit;
}

/* =========================
   ADD / EDIT SUBMIT
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = $_POST['name'];
    $position    = $_POST['position'];
    $description = $_POST['description'];
    $email       = $_POST['email'];
    $phone       = $_POST['phone'];
    $role_type   = $_POST['role_type'];
    $sort_order  = (int)$_POST['sort_order'];

    $image = $_POST['old_image'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/team/" . $image);
    }

    if ($action === 'edit') {
        $stmt = $conn->prepare("
            UPDATE team_members SET
              name=?, position=?, description=?, email=?, phone=?,
              role_type=?, sort_order=?, image=?
            WHERE id=?
        ");
        $stmt->bind_param(
            "ssssssisi",
            $name, $position, $description, $email, $phone,
            $role_type, $sort_order, $image, $id
        );
    } else {
        $stmt = $conn->prepare("
            INSERT INTO team_members
            (name, position, description, email, phone, image, role_type, sort_order)
            VALUES (?,?,?,?,?,?,?,?)
        ");
        $stmt->bind_param(
            "sssssssi",
            $name, $position, $description, $email, $phone,
            $image, $role_type, $sort_order
        );
    }

    $stmt->execute();
    header("Location: teams.php");
    exit;
}

/* =========================
   FETCH DATA
========================= */
$members = $conn->query("SELECT * FROM team_members ORDER BY role_type, sort_order");

$editData = null;
if ($action === 'edit' && $id > 0) {
    $stmt = $conn->prepare("SELECT * FROM team_members WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Team</title>
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

  a {
  text-decoration: none;
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
    .form-card {
  background:#fff;
  max-width:900px;
  margin:auto;
  border-radius:16px;
  padding:2rem;
}
.form-grid {
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:1rem;
}
.form-group { display:flex; flex-direction:column; }
.form-group label { font-weight:600; margin-bottom:.3rem; }
.form-group input,
.form-group textarea,
.form-group select {
  padding:.55rem;
  border-radius:8px;
  border:1px solid #ccc;
}
</style>
</head>

<body>
<?php include 'sidebar.php'; ?>
<main class="main">
<?php include 'header.php'; ?>

<section class="content">

<?php if ($action === 'list'): ?>

<h2>Team Members</h2>
<a href="teams.php?action=add" class="btn primary">➕ Add Member</a>
<br><br>

<table>
<tr>
  <th>Photo</th><th>Name</th><th>Position</th><th>Type</th><th>Order</th><th>Actions</th>
</tr>
<?php while($row = $members->fetch_assoc()): ?>
<tr>
  <td><img src="../uploads/team/<?= htmlspecialchars($row['image']) ?>" width="50"></td>
  <td><?= htmlspecialchars($row['name']) ?></td>
  <td><?= htmlspecialchars($row['position']) ?></td>
  <td><?= ucfirst($row['role_type']) ?></td>
  <td><?= (int)$row['sort_order'] ?></td>
  <td>
    <a class="btn warning" href="teams.php?action=edit&id=<?= $row['id'] ?>">Edit</a>
    <a class="btn danger" href="teams.php?action=delete&id=<?= $row['id'] ?>"
       onclick="return confirm('Delete this member?')">Delete</a>
  </td>
</tr>
<?php endwhile; ?>
</table>

<?php else: ?>

<div class="form-card">
<h3><?= $action === 'edit' ? 'Edit' : 'Add' ?> Team Member</h3>
<form method="post" enctype="multipart/form-data">

<input type="hidden" name="old_image" value="<?= $editData['image'] ?? '' ?>">

<div class="form-grid">
  <div class="form-group">
    <label>Name</label>
    <input name="name" required value="<?= $editData['name'] ?? '' ?>">
  </div>
  <div class="form-group">
    <label>Position</label>
    <input name="position" value="<?= $editData['position'] ?? '' ?>">
  </div>
</div>

<div class="form-group">
  <label>Description</label>
  <textarea name="description"><?= $editData['description'] ?? '' ?></textarea>
</div>

<div class="form-grid">
  <div class="form-group">
    <label>Email</label>
    <input name="email" value="<?= $editData['email'] ?? '' ?>">
  </div>
  <div class="form-group">
    <label>Phone</label>
    <input name="phone" value="<?= $editData['phone'] ?? '' ?>">
  </div>
</div>

<div class="form-grid">
  <div class="form-group">
    <label>Role Type</label>
    <select name="role_type">
      <option value="featured" <?= ($editData['role_type'] ?? '')=='featured'?'selected':'' ?>>Featured</option>
      <option value="compact" <?= ($editData['role_type'] ?? '')=='compact'?'selected':'' ?>>Compact</option>
    </select>
  </div>
  <div class="form-group">
    <label>Sort Order</label>
    <input type="number" name="sort_order" value="<?= $editData['sort_order'] ?? 0 ?>">
  </div>
</div>

<div class="form-group">
  <label>Image</label>
  <input type="file" name="image">
</div>

<br>
<a href="teams.php" class="btn">Cancel</a>
<button class="btn primary">Save</button>

</form>
</div>

<?php endif; ?>

</section>
</main>
</body>
</html>
