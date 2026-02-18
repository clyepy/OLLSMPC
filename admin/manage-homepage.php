<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
$pageTitle = "Manage Advertisement";

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$message = "";

/* =========================
   UPLOAD ADVERTISEMENT
========================= */
if(isset($_POST['upload_ad'])){

    if($_FILES['ad_image']['name'] != ""){

        $filename = time() . "_" . $_FILES['ad_image']['name'];
        $tempname = $_FILES['ad_image']['tmp_name'];
        $folder = "../uploads/ads/" . $filename;

        if(move_uploaded_file($tempname, $folder)){

            $stmt = $conn->prepare("INSERT INTO homepage_ads (image,status) VALUES (?, 'active')");
            $stmt->bind_param("s",$filename);
            $stmt->execute();

            $message = "Advertisement uploaded successfully!";
        }
    }
}

/* =========================
   FETCH ADS
========================= */
$ads = $conn->query("SELECT * FROM homepage_ads ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Homepage Ads</title>
 <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

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
    padding: .7rem 1.2rem;
    border-radius: 10px;
    cursor: pointer;
    font-size: .9rem;
  }

  .btn.secondary {
    background: var(--accent);
    color: #000;
  }
  .card{
    border-radius:15px;
}

.ad-preview{
    height:110px;
    object-fit:cover;
    border-radius:10px;
}
.dropzone {
  border: 2px dashed var(--primary);
  border-radius: 12px;
  background: #f9fbff;
  padding: 2rem;
  text-align: center;
}

.dropzone .dz-message {
  font-size: .95rem;
  color: var(--muted);
}
.toggle-ad {
  transition: all .2s ease;
}

.toggle-ad i {
  font-size: 1.2rem;
}

</style>
</head>

<body>
<?php include 'sidebar.php'; ?>
<main class="main">
    <?php include 'header.php'; ?>
<div class="content">
<div class="container-fluid p-4">

<!-- Page Title -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">
        <i class="bi bi-megaphone"></i> Homepage Advertisements
    </h4>
</div>

<?php if($message): ?>
<div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<div class="row g-4">

<!-- Upload Section -->
<div class="col-lg-4">
<div class="card shadow-sm border-0 h-100">
<div class="card-body">

<h6 class="fw-semibold mb-3">
<i class="bi bi-cloud-upload"></i> Upload Advertisement
</h6>

<form 
  action="ad-upload.php" 
  class="dropzone" 
  id="adDropzone">
</form>


</div>
</div>
</div>

<!-- Advertisement List -->
<div class="col-lg-8">
<div class="card shadow-sm border-0">
<div class="card-body">

<h6 class="fw-semibold mb-3">
<i class="bi bi-images"></i> Advertisement List
</h6>

<div class="table-responsive">
<table class="table align-middle">

<thead>
<tr>
<th>Preview</th>
<th>Status</th>
<th class="text-end">Actions</th>
</tr>
</thead>

<tbody>

<?php while($row = $ads->fetch_assoc()): ?>
<tr>

<td width="180">
  <a href="../uploads/ads/<?= $row['image'] ?>" class="glightbox">
    <img src="../uploads/ads/<?= $row['image'] ?>" class="img-fluid ad-preview">
  </a>
</td>
<td>
  <span class="badge status-badge bg-<?= $row['status']=='active'?'success':'secondary' ?>">
    <?= ucfirst($row['status']) ?>
  </span>
</td>

<td class="text-end">

<button 
  class="btn btn-sm toggle-ad 
         <?= $row['status'] === 'active' ? 'btn-success' : 'btn-secondary' ?>"
  data-id="<?= $row['id'] ?>"
  data-status="<?= $row['status'] ?>">
  
  <i class="bi <?= $row['status'] === 'active' ? 'bi-toggle-on' : 'bi-toggle-off' ?>"></i>
</button>


<button style="background: var(--primary); padding: .9rem .4rem; border-radius: 10px; cursor: pointer; font-size: .20rem; border: none;">
<a href="ad-delete.php?id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this advertisement?')">
<i class="bi bi-trash"></i>
</a>
</button>

</td>

</tr>
<?php endwhile; ?>

</tbody>
</table>
</div>

</div>
</div>
</div>

</div>
</div>
<script>
Dropzone.autoDiscover = false;

new Dropzone("#adDropzone", {
    paramName: "file",
    maxFilesize: 5,
    acceptedFiles: "image/*",
    success: function () {
        location.reload();
    }
});
</script>

<script>
GLightbox({ selector: '.glightbox' });
</script>

<script>
document.querySelectorAll('.toggle-ad').forEach(btn => {

  btn.addEventListener('click', () => {

    const id = btn.dataset.id;
    const row = btn.closest('tr');
    const badge = row.querySelector('.status-badge');

    btn.disabled = true;

    fetch('ad-toggle.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {

      if (!data.success) return;

      btn.dataset.status = data.status;

      if (data.status === 'active') {
        btn.classList.remove('btn-secondary');
        btn.classList.add('btn-success');
        btn.innerHTML = '<i class="bi bi-toggle-on"></i>';

        badge.classList.remove('bg-secondary');
        badge.classList.add('bg-success');
        badge.textContent = 'Active';

      } else {
        btn.classList.remove('btn-success');
        btn.classList.add('btn-secondary');
        btn.innerHTML = '<i class="bi bi-toggle-off"></i>';

        badge.classList.remove('bg-success');
        badge.classList.add('bg-secondary');
        badge.textContent = 'Inactive';
      }

    })
    .finally(() => btn.disabled = false);

  });

});

</script>


</body>
</html>