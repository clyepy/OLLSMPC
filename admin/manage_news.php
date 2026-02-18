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

/* ---------------- DELETE ---------------- */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM news WHERE id=$id");
    header("Location: manage_news.php");
    exit;
}

/* ---------------- ADD / UPDATE ---------------- */
if (isset($_POST['save_news'])) {


    $id = $_POST['id'] ?? '';
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $author = $_POST['author'];
    $created_at = $_POST['created_at'] ?? date('Y-m-d H:i:s');


    $uploadedImages = [];

    /* Upload images */
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {

            $filename = time() . "_" . $_FILES['images']['name'][$key];
            $path = "../uploads/news/" . $filename;

            move_uploaded_file($tmp_name, $path);

            $uploadedImages[] = $filename;
        }
    }

    $imageString = implode(',', $uploadedImages);

    /* ================= UPDATE ================= */
if ($id) {

    if (!empty($imageString)) {
        $stmt = $conn->prepare("
            UPDATE news 
            SET title=?, summary=?, content=?, category=?, status=?, image=?, author=?, created_at=? 
            WHERE id=?
        ");
        $stmt->bind_param("ssssssssi", $title, $summary, $content, $category, $status, $imageString, $author, $created_at, $id);
    } else {
        $stmt = $conn->prepare("
            UPDATE news 
            SET title=?, summary=?, content=?, category=?, status=?, author=?, created_at=? 
            WHERE id=?
        ");
        $stmt->bind_param("sssssssi", $title, $summary, $content, $category, $status, $author, $created_at, $id);
    }

} else {

$stmt = $conn->prepare("
    INSERT INTO news 
    (title, summary, content, category, status, image, author, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("ssssssss", $title, $summary, $content, $category, $status, $imageString, $author, $created_at);

    }

    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }

    header("Location: manage_news.php");
    exit;
}

/* ADD CATEGORY */
if (isset($_POST['add_category'])) {

    $catName = $_POST['cat_name'];
    $catDesc = $_POST['cat_desc'];

    $filename = '';
    if (!empty($_FILES['cat_image']['name'])) {
        $filename = time() . "_" . $_FILES['cat_image']['name'];
        move_uploaded_file($_FILES['cat_image']['tmp_name'], "../uploads/categories/" . $filename);
    }

    $stmt = $conn->prepare("INSERT INTO news_categories (name, image, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $catName, $filename, $catDesc);
    $stmt->execute();

    header("Location: manage_news.php");
    exit;
}

/* DELETE CATEGORY */
if (isset($_GET['delete_cat'])) {
    $id = intval($_GET['delete_cat']);
    $conn->query("DELETE FROM news_categories WHERE id=$id");
    header("Location: manage_news.php");
    exit;
}

/* EDIT CATEGORY FETCH */
$editCat = null;
if (isset($_GET['edit_cat'])) {
    $id = intval($_GET['edit_cat']);
    $editCat = $conn->query("SELECT * FROM news_categories WHERE id=$id")->fetch_assoc();
}

/* UPDATE CATEGORY */
if (isset($_POST['update_category'])) {

    $id = $_POST['cat_id'];
    $catName = $_POST['cat_name'];
    $catDesc = $_POST['cat_desc'];

    $filename = $_POST['old_image'];

    if (!empty($_FILES['cat_image']['name'])) {
        $filename = time() . "_" . $_FILES['cat_image']['name'];
        move_uploaded_file($_FILES['cat_image']['tmp_name'], "../uploads/categories/" . $filename);
    }

    $stmt = $conn->prepare("UPDATE news_categories SET name=?, image=?, description=? WHERE id=?");
    $stmt->bind_param("sssi", $catName, $filename, $catDesc, $id);
    $stmt->execute();

    header("Location: manage_news.php");
    exit;
}

/* ---------------- FETCH ---------------- */
$news = $conn->query("SELECT * FROM news ORDER BY id DESC");

/* EDIT */
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editData = $conn->query("SELECT * FROM news WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>OLLSMPC Admin - <?= $pageTitle ?></title>
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
.card {
  background: var(--surface);
  padding: 2rem;
  border-radius: var(--radius);
  box-shadow: 0 15px 40px rgba(0,0,0,0.06);
  margin-bottom: 2rem;
}

/* ===== FORM ===== */
.news-form .form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 1.2rem;
}

.news-form label {
  font-size: .85rem;
  font-weight: 600;
  margin-bottom: .4rem;
  color: var(--muted);
}

.news-form input,
.news-form textarea,
.news-form select {
  padding: .75rem .9rem;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  font-size: .9rem;
  transition: all .2s ease;
  background: #f9fafb;
}

.news-form input:focus,
.news-form textarea:focus,
.news-form select:focus {
  outline: none;
  border-color: var(--primary);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(0,74,143,0.1);
}

.news-form textarea {
  resize: vertical;
  min-height: 120px;
}

.form-row {
  display: flex;
  gap: 1rem;
}

.form-row .form-group {
  flex: 1;
}

/* Button improvement */
.news-form .btn {
  background: var(--primary);
  padding: .75rem 1.5rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: .95rem;
  transition: all .2s ease;
}

.news-form .btn:hover {
  background: #00325f;
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.08);
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
</style>

</head>
<body>
<?php include 'sidebar.php'; ?>
<main class="main">
  <?php include 'header.php'; ?>

    <section class="content">
        <div class="container">

<h2>Manage News</h2>

<!-- ================= FORM ================= -->
<!-- ================= FORM ================= -->
<div class="card">
  <h3><?= $editData ? 'Edit News Article' : 'Add New Article' ?></h3>

  <form method="POST" enctype="multipart/form-data" class="news-form">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

    <div class="form-group">
      <label>Title</label>
      <input type="text" name="title"
             value="<?= $editData['title'] ?? '' ?>"
             required>
    </div>

    <div class="form-group">
  <label>Author</label>
  <input type="text" name="author"
         value="<?= $editData['author'] ?? '' ?>"
         placeholder="e.g. Admin, Staff Name"
         required>
</div>


    <div class="form-group">
      <label>Summary</label>
      <textarea name="summary" rows="3"><?= $editData['summary'] ?? '' ?></textarea>
    </div>

    <div class="form-group">
      <label>Content</label>
      <textarea name="content" rows="6"><?= $editData['content'] ?? '' ?></textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Category</label>
        <?php $categories = $conn->query("SELECT * FROM news_categories"); ?>

<select name="category" required>
  <option value="">Select Category</option>
  <?php while($cat = $categories->fetch_assoc()): ?>
    <option value="<?= $cat['name'] ?>"
      <?= (isset($editData['category']) && $editData['category'] == $cat['name']) ? 'selected' : '' ?>>
      <?= $cat['name'] ?>
    </option>
  <?php endwhile; ?>
</select>
      </div>

      <div class="form-group">
  <label>Publish Date</label>
  <input type="datetime-local" name="created_at"
         value="<?= isset($editData['created_at']) ? date('Y-m-d\TH:i', strtotime($editData['created_at'])) : '' ?>">
</div>


      <div class="form-group">
        <label>Status</label>
        <select name="status">
          <option value="draft"
            <?= (isset($editData['status']) && $editData['status'] == 'draft') ? 'selected' : '' ?>>
            Draft
          </option>
          <option value="published"
            <?= (isset($editData['status']) && $editData['status'] == 'published') ? 'selected' : '' ?>>
            Published
          </option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label>Upload Images (Max 3 recommended)</label>
      <input type="file" name="images[]" multiple>
    </div>

    <button type="submit" name="save_news" class="btn">
      <?= $editData ? 'Update News' : 'Publish News' ?>
    </button>

  </form>
  
</div>
<div class="card">
  <h3><?= $editCat ? 'Edit Category' : 'Add Category' ?></h3>

  <form method="POST" enctype="multipart/form-data" class="news-form">

    <input type="hidden" name="cat_id" value="<?= $editCat['id'] ?? '' ?>">
    <input type="hidden" name="old_image" value="<?= $editCat['image'] ?? '' ?>">

    <div class="form-row">

      <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="cat_name"
               value="<?= $editCat['name'] ?? '' ?>"
               required>
      </div>

      <div class="form-group">
        <label>Upload Image</label>
        <input type="file" name="cat_image" <?= $editCat ? '' : 'required' ?>>
      </div>

    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="cat_desc"><?= $editCat['description'] ?? '' ?></textarea>
    </div>

    <button type="submit"
      name="<?= $editCat ? 'update_category' : 'add_category' ?>"
      class="btn">
      <?= $editCat ? 'Update Category' : 'Add Category' ?>
    </button>

  </form>
</div>


<div class="card">
  <h3>Category List</h3>

  <table>
    <tr>
      <th>Name</th>
      <th>Image</th>
      <th>Action</th>
    </tr>

    <?php 
    $cats = $conn->query("SELECT * FROM news_categories ORDER BY id DESC");
    while($cat = $cats->fetch_assoc()): ?>
    <tr>
      <td><?= $cat['name'] ?></td>
      <td>
        <?php if($cat['image']): ?>
          <img src="../uploads/categories/<?= $cat['image'] ?>" width="50">
        <?php endif; ?>
      </td>
      <td>
        <a href="?edit_cat=<?= $cat['id'] ?>" class="edit-btn">Edit</a>
        <a href="?delete_cat=<?= $cat['id'] ?>" class="delete-btn"
           onclick="return confirm('Delete category?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>

  </table>
</div>

<table class="table table-bordered">
<tr>
    <th>Title</th>
    <th>Author</th>
    <th>Category</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = $news->fetch_assoc()): ?>
<tr>
    <td><?= $row['title'] ?></td>
    <td><?= $row['author'] ?></td>
    <td><?= $row['category'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <a href="?edit=<?= $row['id'] ?>" class="edit-btn">Edit</a>
        <a href="?delete=<?= $row['id'] ?>" class="delete-btn"
           onclick="return confirm('Delete this?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
