<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
$pageTitle = "Manage Events";

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

// Get all events
$result = mysqli_query($conn, "SELECT * FROM events");

// Handle form submission
$id = $_GET['id'] ?? "";
$isEditing = !empty($id);
$event = [];



if ($id) {
    $res = mysqli_query($conn, "SELECT * FROM events WHERE id=" . intval($id));
    $event = mysqli_fetch_assoc($res);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $event_type = $_POST['event_type'];
    $organizer = $_POST['organizer'];
    $purpose = $_POST['purpose'];
    $documentation = $_POST['documentation'];
    $tags = $_POST['tags'];
    $content = $_POST['content'];
$uploadDir = "../uploads/events/";
$banner_image = $event['banner_image'] ?? '';
$galleryArray = [];

/* ================= BANNER UPLOAD ================= */
if (!empty($_FILES['banner_image']['name'])) {
    $fileName = time() . '_' . basename($_FILES['banner_image']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $targetFile)) {
        $banner_image = "uploads/events/" . $fileName;
    }
}

/* ================= GALLERY UPLOAD ================= */
if (!empty($_FILES['gallery_images']['name'][0])) {

    foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['gallery_images']['error'][$key] === 0) {

           $fileName = uniqid() . '_' . basename($_FILES['gallery_images']['name'][$key]);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $targetFile)) {
                $galleryArray[] = "uploads/events/" . $fileName;
            }
        }
    }

} else {
    // Keep old images if editing
    if (!empty($event['gallery_images'])) {
        $galleryArray = json_decode($event['gallery_images'], true);
    }
}

$gallery_json = json_encode($galleryArray);

    if ($id) {
        $stmt = $conn->prepare("UPDATE events SET title=?, summary=?, event_date=?, location=?, event_type=?, organizer=?, purpose=?, documentation=?, tags=?, banner_image=?, gallery_images=?, content=? WHERE id=?");
        $stmt->bind_param("ssssssssssssi", $title, $summary, $event_date, $location, $event_type, $organizer, $purpose, $documentation, $tags, $banner_image, $gallery_json, $content, $id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO events (title, summary, event_date, location, event_type, organizer, purpose, documentation, tags, banner_image, gallery_images, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $title, $summary, $event_date, $location, $event_type, $organizer, $purpose, $documentation, $tags, $banner_image, $gallery_json, $content);
        $stmt->execute();
    }

    header("Location: events.php");
    exit;
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
</style>

</head>
<body>
<?php include 'sidebar.php'; ?>
<main class="main">
  <?php include 'header.php'; ?>

    <section class="content">
        <div class="container">
            <h1><?= $pageTitle ?></h1>
            <button class="btn" id="add-event-btn">➕ Add Event</button>

            <!-- EVENTS TABLE -->
            <div id="events-table" style="<?= $isEditing ? 'display:none;' : '' ?>">
                <br><table>
                    <tr>
                      <th>Title</th>
                      <th>Date</th>
                      <th>Actions</th></tr>
                       <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= date("F d, Y", strtotime($row['event_date'])) ?></td>
                            <td>
                                <a href="?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                                <a href="event-delete.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        </tbody>
                    <?php else: ?>
                        <tr><td colspan="3" class="empty">No events found.</td></tr>
                    <?php endif; ?>
                </table>
            </div>

            <!-- Event form -->
                <div id="event-form-container" style="<?= $isEditing ? '' : 'display:none;' ?>">
        <div class="card"><br>
          <button type="button" id="back-btn" class="btn secondary">Back</button>  
  <form method="post" enctype="multipart/form-data" id="event-form" class="event-form" style="margin-top:1rem;">
    <div class="form-group">
      <label>Event Title</label>
      <input type="text" name="title" value="<?= $event['title'] ?? '' ?>" placeholder="Event Title" required>
    </div>

    <div class="form-group">
      <label>Date</label>
      <input type="date" name="event_date" value="<?= $event['event_date'] ?? '' ?>" required>
    </div>

    <div class="form-group">
      <label>Event Type</label>
      <input type="text" name="event_type" value="<?= $event['event_type'] ?? '' ?>" placeholder="Event Type (e.g. Awarding Ceremony)">
    </div>

    <div class="form-group">
      <label>Organizer</label>
      <input type="text" name="organizer" value="<?= $event['organizer'] ?? '' ?>" placeholder="Organizer">
    </div>

    <div class="form-group">
      <label>Purpose</label>
      <input type="text" name="purpose" value="<?= $event['purpose'] ?? '' ?>" placeholder="Purpose">
    </div>

    <div class="form-group">
      <label>Documentation</label>
      <input type="text" name="documentation" value="<?= $event['documentation'] ?? '' ?>" placeholder="Documentation">
    </div>

    <div class="form-group">
      <label>Tags</label>
      <input type="text" name="tags" value="<?= $event['tags'] ?? '' ?>" placeholder="Tags (comma separated)">
    </div>

    <div class="form-group">
      <label>Short Summary</label>
      <textarea name="summary" placeholder="Short summary"><?= $event['summary'] ?? '' ?></textarea>
    </div>

    <div class="form-group">
      <label>Full Description</label>
      <textarea name="content" rows="6" placeholder="Full event description"><?= $event['content'] ?? '' ?></textarea>
    </div>

<div class="form-group">
  <label>Banner Image</label>
  <input type="file" name="banner_image" accept="image/*">

  <?php if (!empty($event['banner_image'])): ?>
    <img src="../<?= htmlspecialchars($event['banner_image']) ?>" width="120">
  <?php endif; ?>
</div>

<div class="form-group">
  <label>Gallery Images</label>
  <input type="file" name="gallery_images[]" multiple accept="image/*">

  <?php
  if (!empty($event['gallery_images'])):
    $images = json_decode($event['gallery_images'], true);
    foreach ($images as $img):
  ?>
    <img src="../<?= htmlspecialchars($img) ?>" width="80">
  <?php endforeach; endif; ?>
</div>


    <button type="submit" name="save" class="btn">
      <?= isset($event['id']) ? "Update Event" : "Save Event" ?>
    </button>
  </form>
        </div>
    </div>
        </div>
    </section>
</main>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const addBtn = document.getElementById('add-event-btn');
  const backBtn = document.getElementById('back-btn');
  const eventsTable = document.getElementById('events-table');
  const eventForm = document.getElementById('event-form-container');
  const form = document.getElementById('event-form');

  backBtn.style.display = 'none';

  addBtn.addEventListener('click', () => {
    form.reset();
    eventsTable.style.display = 'none';
    eventForm.style.display = 'block';
    backBtn.style.display = 'inline-block';
  });

  backBtn.addEventListener('click', () => {
    eventForm.style.display = 'none';
    eventsTable.style.display = 'block';
    backBtn.style.display = 'none';
  });
});
</script>

</body>
</html>
