<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
$pageTitle = "Manage Service";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$uploadDir = "../uploads/services/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // delete features first
    mysqli_query($conn, "DELETE FROM service_features WHERE service_id=$id");

    // delete service
    mysqli_query($conn, "DELETE FROM services WHERE id=$id");

    header("Location: manage_service.php");
    exit;
}

/* ================= EDIT LOAD ================= */
$editService = null;
$editFeatures = [];

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editService = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM services WHERE id=$id")
    );

    $featuresRes = mysqli_query($conn, 
        "SELECT * FROM service_features WHERE service_id=$id"
    );

    while ($f = mysqli_fetch_assoc($featuresRes)) {
        $editFeatures[] = $f['feature_text'];
    }
}

/* ================= SAVE ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['service_id'] ?? "";
    $category_id = intval($_POST['category_id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $features = $_POST['features'] ?? [];

    // Handle image upload
    $imagePath = $_POST['old_image'] ?? "";

    if (!empty($_FILES['image']['name'])) {
        $fileName = uniqid() . "_" . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = "uploads/services/" . $fileName;
        }
    }

    if ($id) {
        // UPDATE
        $stmt = $conn->prepare("UPDATE services 
            SET category_id=?, title=?, description=?, image=? 
            WHERE id=?");
        $stmt->bind_param("isssi", $category_id, $title, $description, $imagePath, $id);
        $stmt->execute();

        mysqli_query($conn, "DELETE FROM service_features WHERE service_id=$id");

        $service_id = $id;

    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO services 
            (category_id, title, description, image) 
            VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $category_id, $title, $description, $imagePath);
        $stmt->execute();

        $service_id = $stmt->insert_id;
    }

    // Insert features
    foreach ($features as $feature) {
        if (!empty(trim($feature))) {
            $stmt = $conn->prepare("INSERT INTO service_features 
                (service_id, feature_text) VALUES (?, ?)");
            $stmt->bind_param("is", $service_id, $feature);
            $stmt->execute();
        }
    }

    header("Location: manage_service.php");
    exit;
}

$categories = mysqli_query($conn, "SELECT * FROM service_categories");
$services = mysqli_query($conn, "
    SELECT s.*, c.name as category_name 
    FROM services s 
    JOIN service_categories c ON s.category_id = c.id
    ORDER BY c.id ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Services</title>
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
}

/* CARD */
.card {
  background: var(--surface);
  border-radius: var(--radius);
  padding: 1.5rem;
  box-shadow: 0 10px 30px var(--shadow);
  margin-bottom: 2rem;
}

/* FORM */
.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  font-weight: 600;
  display: block;
  margin-bottom: .4rem;
}

.form-control {
  width: 100%;
  padding: .6rem;
  border-radius: 10px;
  border: 1px solid #d1d5db;
  font-size: .9rem;
}

textarea {
  resize: vertical;
}

.feature-input {
  margin-bottom: .5rem;
}

/* BUTTONS */
.btn {
  padding: .6rem 1.2rem;
  border-radius: 10px;
  border: none;
  cursor: pointer;
  font-weight: 500;
  font-size: .9rem;
  transition: .2s ease;
}

.btn-primary {
  background: var(--primary);
  color: #fff;
}

.btn-primary:hover {
  background: #00325f;
}

.btn-secondary {
  background: var(--accent);
  color: #000;
}

.btn-danger {
  background: #dc3545;
  color: #fff;
}

.btn-warning {
  background: #ffc107;
  color: #000;
}

/* TABLE */
.table {
  width: 100%;
  border-collapse: collapse;
  background: var(--surface);
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: 0 10px 30px var(--shadow);
}

.table th, .table td {
  padding: 1rem;
  text-align: left;
}

.table th {
  background: #f1f3f6;
  font-weight: 600;
}

.table tr {
  border-bottom: 1px solid #eee;
}

.table tr:hover {
  background: #fafafa;
}

/* IMAGE PREVIEW */
.preview-img {
  border-radius: 8px;
  margin-top: .5rem;
}

/* PAGE TITLE */
.page-title {
  font-size: 1.6rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  color: var(--primary);
}
</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<main class="main">
<?php include 'header.php'; ?>

<div class="content">

<div class="page-title">
  <i class="bi bi-gear"></i> Manage Services
</div><br>

<!-- FORM -->
<div class="card">
<form method="POST" enctype="multipart/form-data">

<input type="hidden" name="service_id" value="<?= $editService['id'] ?? '' ?>">
<input type="hidden" name="old_image" value="<?= $editService['image'] ?? '' ?>">

<div class="form-group">
<label>Category</label>
<select name="category_id" class="form-control" required>
<option value="">Select Category</option>
<?php
mysqli_data_seek($categories, 0);
while ($cat = mysqli_fetch_assoc($categories)):
?>
<option value="<?= $cat['id'] ?>"
<?= (isset($editService['category_id']) && $editService['category_id']==$cat['id'])?'selected':'' ?>>
<?= $cat['name'] ?>
</option>
<?php endwhile; ?>
</select>
</div>

<div class="form-group">
<label>Service Title</label>
<input type="text" name="title" class="form-control"
value="<?= $editService['title'] ?? '' ?>" required>
</div>

<div class="form-group">
<label>Description</label>
<textarea name="description" rows="4" class="form-control" required><?= $editService['description'] ?? '' ?></textarea>
</div>

<div class="form-group">
<label>Image</label>
<input type="file" name="image" class="form-control">
<?php if (!empty($editService['image'])): ?>
<img src="../<?= $editService['image'] ?>" width="120" class="preview-img">
<?php endif; ?>
</div>

<div class="form-group">
<label>Features</label>
<div id="feature-container">
<?php
if ($editFeatures) {
  foreach ($editFeatures as $feat) {
    echo '<input type="text" name="features[]" class="form-control feature-input" value="'.htmlspecialchars($feat).'">';
  }
} else {
  echo '<input type="text" name="features[]" class="form-control feature-input">';
}
?>
</div>
<button type="button" onclick="addFeature()" class="btn btn-secondary" style="margin-top:.5rem;">
<i class="bi bi-plus-circle"></i> Add Feature
</button>
</div>

<button class="btn btn-primary">
<i class="bi bi-save"></i>
<?= $editService ? "Update Service" : "Add Service" ?>
</button>

</form>
</div>

<!-- TABLE -->
<table class="table">
<thead>
<tr>
<th>Category</th>
<th>Title</th>
<th>Image</th>
<th>Actions</th>
</tr>
</thead>

<tbody>
<?php while ($row = mysqli_fetch_assoc($services)): ?>
<tr>
<td><?= $row['category_name'] ?></td>
<td><?= $row['title'] ?></td>
<td>
<?php if ($row['image']): ?>
<img src="../<?= $row['image'] ?>" width="70" class="preview-img">
<?php endif; ?>
</td>
<td>
<a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
<i class="bi bi-pencil"></i>
</a>

<a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
onclick="return confirm('Delete this service?')">
<i class="bi bi-trash"></i>
</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>
</main>

<script>
function addFeature() {
  let container = document.getElementById('feature-container');
  let input = document.createElement('input');
  input.type = "text";
  input.name = "features[]";
  input.className = "form-control feature-input";
  container.appendChild(input);
}
</script>

</body>
</html>
