<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
$pageTitle = "Manage Branches";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}


if (isset($_POST['add_branch'])) {

    $stmt = $conn->prepare("
        INSERT INTO branches 
        (name, type, location, hours, overview, 
         manager_name, manager_email, manager_phone,
         hero_image, manager_photo, manager_bio, manager_experience)
        VALUES (?, ?, ?, ?, ?, '', '', '', '', '', '', '')
    ");

    $stmt->bind_param(
        "sssss",
        $_POST['new_name'],
        $_POST['new_type'],
        $_POST['new_location'],
        $_POST['new_hours'],
        $_POST['new_overview']
    );

    $stmt->execute();
    $newID = $stmt->insert_id;

    header("Location: branches-details.php?branch_id=" . $newID);
    exit;
}

$branchList = $conn->query("SELECT id,name FROM branches ORDER BY name ASC");

/* ==========================
   DETERMINE SELECTED BRANCH
========================== */
if (isset($_GET['branch_id'])) {
    $branch_id = intval($_GET['branch_id']);
} elseif (isset($_POST['branch_id'])) {
    $branch_id = intval($_POST['branch_id']);
} else {
    // DEFAULT: first branch in the database
    $firstBranch = $branchList->fetch_assoc();
    if ($firstBranch) {
        $branch_id = $firstBranch['id'];
    } else {
        die("No branches available.");
    }
}

// Reload branch list to use in dropdown
$branchList = $conn->query("SELECT id,name FROM branches ORDER BY name ASC");

/* ==========================
   FETCH SELECTED BRANCH DATA
========================== */
$stmt = $conn->prepare("SELECT * FROM branches WHERE id=?");
$stmt->bind_param("i", $branch_id);
$stmt->execute();
$branch = $stmt->get_result()->fetch_assoc();

if (!$branch) {
    die("Invalid branch selected.");
}

/* ==========================
   DELETE SERVICE
========================== */
if (isset($_GET['delete_service'])) {
    $sid = intval($_GET['delete_service']);
    $stmt = $conn->prepare("DELETE FROM branch_services WHERE id=? AND branch_id=?");
    $stmt->bind_param("ii", $sid, $branch_id);
    $stmt->execute();
    header("Location: branches-details.php?branch_id=$branch_id");
    exit;
}

/* ==========================
   UPDATE BRANCH
========================== */
if (isset($_POST['update_branch'])) {

    $hero_image = $branch['hero_image'];
    if (!empty($_FILES['hero_image']['name'])) {
        $dir = "../uploads/branches/";
        if (!file_exists($dir)) mkdir($dir, 0755, true);
        $file = time() . '_' . basename($_FILES['hero_image']['name']);
        move_uploaded_file($_FILES['hero_image']['tmp_name'], $dir . $file);
        $hero_image = $file;
    }

    $manager_photo = $branch['manager_photo'];
    if (!empty($_FILES['manager_photo']['name'])) {
        $dir = "../uploads/managers/";
        if (!file_exists($dir)) mkdir($dir, 0755, true);
        $file = time() . '_' . basename($_FILES['manager_photo']['name']);
        move_uploaded_file($_FILES['manager_photo']['tmp_name'], $dir . $file);
        $manager_photo = $file;
    }

    $stmt = $conn->prepare("
        UPDATE branches SET
            name=?,
            type=?,
            location=?,
            hours=?,
            overview=?,
            manager_name=?,
            manager_email=?,
            manager_phone=?,
            hero_image=?,
            manager_photo=?,
            manager_bio=?,
            manager_experience=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "ssssssssssssi",
        $_POST['name'],
        $_POST['type'],
        $_POST['location'],
        $_POST['hours'],
        $_POST['overview'],
        $_POST['manager_name'],
        $_POST['manager_email'],
        $_POST['manager_phone'],
        $hero_image,
        $manager_photo,
        $_POST['manager_bio'],
        $_POST['manager_experience'],
        $branch_id
    );

    $stmt->execute();
    header("Location: branches-details.php?branch_id=$branch_id");
    exit;
}

/* ==========================
   GALLERY
========================== */
if (isset($_GET['delete_gallery'])) {
    $gid = intval($_GET['delete_gallery']);

    $stmt = $conn->prepare("SELECT image_url FROM branch_gallery WHERE id=? AND branch_id=?");
    $stmt->bind_param("ii", $gid, $branch_id);
    $stmt->execute();
    $img = $stmt->get_result()->fetch_assoc();

    if ($img) {
        @unlink("../uploads/branches/" . $img['image_url']);
        $stmt = $conn->prepare("DELETE FROM branch_gallery WHERE id=?");
        $stmt->bind_param("i", $gid);
        $stmt->execute();
    }

    header("Location: branches-details.php?branch_id=$branch_id");
    exit;
}

if (isset($_POST['add_gallery']) && !empty($_FILES['image_file']['name'])) {
    $dir = "../uploads/branches/";
    if (!file_exists($dir)) mkdir($dir, 0755, true);

    $file = time() . '_' . basename($_FILES['image_file']['name']);
    move_uploaded_file($_FILES['image_file']['tmp_name'], $dir . $file);

    $stmt = $conn->prepare("INSERT INTO branch_gallery (branch_id, image_url, title) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $branch_id, $file, $_POST['title']);
    $stmt->execute();
}
$gallery = $conn->prepare("SELECT * FROM branch_gallery WHERE branch_id=?");
$gallery->bind_param("i", $branch_id);
$gallery->execute();
$gallery = $gallery->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Branch Editor</title>
 <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  .topbar {
    background: var(--surface);
    padding: 0.5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 6px 20px var(--shadow);
    z-index: 10;
  }

  .topbar h2 {
    margin: 0;
    font-size: 1.4rem;
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

/* ===== MAIN ===== */
.main{
flex:1;
display:flex;
flex-direction:column;
}

  .content {
    padding: 2rem;
    overflow-y: auto;
    flex: 1;
  }

/* ===== GRID ===== */
.grid{
display:grid;
grid-template-columns: 2fr 1fr;
gap:20px;
}

/* ===== CARD ===== */
.card{
background:#fff;
padding:25px;
border-radius:var(--radius);
box-shadow:0 10px 25px rgba(0,0,0,.05);
margin-bottom:20px;
}

/* ===== TABS ===== */
.tabs{
display:flex;
gap:19px;
margin-bottom:20px;
}

.tab{
padding:10px 28px;
border-radius:20px;
cursor:pointer;
background:#eee;
}

.tab.active{
background:var(--primary);
color:#fff;
}

/* ===== FORM ===== */
input,textarea,select{
width:100%;
padding:10px;
border-radius:8px;
border:1px solid #ddd;
margin-top:5px;
margin-bottom:15px;
}

button{
background:var(--primary);
border:none;
border-radius:10px;
cursor:pointer;
padding:12px;
}

/* ===== IMAGE PREVIEW ===== */
.preview{
width:100%;
max-width:200px;
height:130px;
object-fit:cover;
border-radius:12px;
margin-top:8px;
}

.gallery-img{
width:70px;
height:60px;
object-fit:cover;
border-radius:8px;
}

</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<main class="main">
<?php include 'header.php'; ?>

<div class="content">

<?php
$branchList = $conn->query("SELECT id,name FROM branches ORDER BY name ASC");
?>

<form method="GET" style="margin-bottom:20px;">

<label>Select Office / Branch</label>

<select name="branch_id" onchange="this.form.submit()">

<?php while($b=$branchList->fetch_assoc()): ?>
<option value="<?= $b['id'] ?>" <?= $b['id']==$branch_id ? 'selected':'' ?>>
<?= $b['name'] ?>
</option>
<?php endwhile; ?>

</select>

</form>


<h2>Branch Editor</h2>

<div class="tabs">
<div class="tab active" onclick="showTab('branch', this)">Branch</div>
<div class="tab" onclick="showTab('manager', this)">Manager</div>
<div class="tab" onclick="showTab('gallery', this)">Gallery</div>
<div class="tab" onclick="showTab('addBranch', this)">+ Add Branch</div>
</div>


<form method="POST" enctype="multipart/form-data">
<!-- ================= ADD NEW BRANCH ================= -->
<div id="addBranch" class="tabContent" style="display:none;">

<div class="card">
<h3>Create New Branch</h3>

<label>Branch Name</label>
<input name="new_name">

<label>Type</label>
<input name="new_type">

<label>Location</label>
<input name="new_location">

<label>Office Hours</label>
<input name="new_hours">

<label>Overview</label>
<textarea name="new_overview"></textarea>

<button name="add_branch">Create Branch</button>

</div>
</div>


<div id="branch" class="tabContent">

<div class="card">
<h3>Branch Info</h3>

<label>Name</label>
<input name="name" value="<?= $branch['name'] ?>">

<label>Type</label>
<input name="type" value="<?= $branch['type'] ?>">

<label>Location</label>
<input name="location" value="<?= $branch['location'] ?>">

<label>Office Hours</label>
<input name="hours" value="<?= $branch['hours'] ?>">

<label>Overview</label>
<textarea name="overview"><?= $branch['overview'] ?></textarea>

<label>Hero Image</label>
<input type="file" name="hero_image" onchange="previewImg(this,'heroPrev')">
<?php if($branch['hero_image']): ?>
<img src="../uploads/branches/<?= $branch['hero_image'] ?>" class="preview" id="heroPrev">
<?php else: ?>
<img class="preview" id="heroPrev" style="display:none;">
<?php endif; ?>

</div>
</div>

<!-- ================= TAB 2 ================= -->
<div id="manager" class="tabContent" style="display:none;">

<div class="card">
<h3>Manager Profile</h3>

<label>Name</label>
<input name="manager_name" value="<?= $branch['manager_name'] ?>">

<label>Email</label>
<input name="manager_email" value="<?= $branch['manager_email'] ?>">

<label>Phone</label>
<input name="manager_phone" value="<?= $branch['manager_phone'] ?>">

<label>Photo</label>
<input type="file" name="manager_photo" onchange="previewImg(this,'mgrPrev')">

<?php if($branch['manager_photo']): ?>
<img src="../uploads/managers/<?= $branch['manager_photo'] ?>" class="preview" id="mgrPrev">
<?php else: ?>
<img class="preview" id="mgrPrev" style="display:none;">
<?php endif; ?>

<br><label>Bio</label>
<textarea name="manager_bio"><?= $branch['manager_bio'] ?></textarea>

<label>Experience</label>
<textarea name="manager_experience"><?= $branch['manager_experience'] ?></textarea>

</div>
</div>



<!-- ================= TAB 4 ================= -->
<div id="gallery" class="tabContent" style="display:none;">

<div class="card">
<h3>Gallery</h3>

<input name="title" placeholder="Image Title">
<input type="file" name="image_file">

<button name="add_gallery">Upload</button>

<hr>

<?php while($g=$gallery->fetch_assoc()): ?>
<div style="display:flex;align-items:center;gap:15px;margin-bottom:10px;">
<img src="../uploads/branches/<?= $g['image_url'] ?>" class="gallery-img">
<?= $g['title'] ?>
<a href="?delete_gallery=<?= $g['id'] ?>&branch_id=<?= $branch_id ?>">Delete</a>
</div>
<?php endwhile; ?>

</div>
</div>

<button name="update_branch">Save Branch</button>

</form>

</div>
</main>

<script>
function showTab(id, el){
    document.querySelectorAll('.tabContent').forEach(t=>t.style.display='none');
    document.getElementById(id).style.display='block';

    document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
    el.classList.add('active');
}


function previewImg(input,target){
let file=input.files[0];
if(file){
let reader=new FileReader();
reader.onload=e=>{
let img=document.getElementById(target);
img.src=e.target.result;
img.style.display='block';
}
reader.readAsDataURL(file);
}
}
</script>

</body>
</html>
