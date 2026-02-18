<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require "../connection.php";

$pageTitle = "Settings";
session_start();

if (!isset($_SESSION['admin_id'])) {
header("Location: settings.php");
exit;

}

$admin_id = $_SESSION['admin_id'];

/* =======================
   Load system settings
======================= */
$settingsStmt = $conn->query("SELECT * FROM admin_settings LIMIT 1");
$settings = $settingsStmt->fetch_assoc();

/* =======================
   Load admin profile
======================= */
$adminStmt = $conn->prepare("SELECT username, display_name, avatar FROM admins WHERE id = ?");
$adminStmt->bind_param("i", $admin_id);
$adminStmt->execute();
$admin = $adminStmt->get_result()->fetch_assoc();

$message = null;

if (isset($_POST['save_system'])) {
    $site_name   = trim($_POST['site_name']);
    $admin_email = trim($_POST['admin_email']);

    $stmt = $conn->prepare("
        UPDATE admin_settings
        SET site_name = ?, admin_email = ?
        WHERE id = ?
    ");
    $stmt->bind_param("ssi", $site_name, $admin_email, $settings['id']);
    $stmt->execute();

    $message = "System settings saved successfully.";
    header("Location: settings.php?success=system");
    exit;
}


if (isset($_POST['update_account'])) {

    if (!empty($_POST['password'])) {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $message = "Passwords do not match.";
            goto end_update;
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $admin_id);
        $stmt->execute();
    }

    if (isset($_POST['display_name'])) {
        $display_name = trim($_POST['display_name']);
        $stmt = $conn->prepare("UPDATE admins SET display_name = ? WHERE id = ?");
        $stmt->bind_param("si", $display_name, $admin_id);
        $stmt->execute();
    }

if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === 0) {

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {

        $uploadDir = "../uploads/admin/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = "avatar_" . $admin_id . "_" . time() . "." . $ext;
        $target = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {

            $avatarPath = "uploads/admin/" . $fileName;
            $stmt = $conn->prepare("UPDATE admins SET avatar = ? WHERE id = ?");
            $stmt->bind_param("si", $avatarPath, $admin_id);
            $stmt->execute();
        }
    }
}
    header("Location: settings.php?success=account");
    exit;
}


end_update:


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $pageTitle ?></title>
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
    .settings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
    }

    .settings-card {
      background: var(--surface);
      border-radius: var(--radius);
      box-shadow: 0 8px 22px var(--shadow);
      padding: 2rem;
    }

    .settings-card h4 {
      margin: 0 0 1.5rem;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: .6rem;
      font-size: 1.2rem;
    }

    .form-group {
      margin-bottom: 1.2rem;
    }

    .form-group label {
      display: block;
      font-size: .85rem;
      color: var(--muted);
      margin-bottom: .4rem;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: .65rem .8rem;
      border-radius: 12px;
      border: 1px solid #d1d5db;
      font-size: .95rem;
      outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
      border-color: var(--primary);
    }

    .form-actions {
      margin-top: 1.5rem;
      text-align: right;
    }

    .toggle {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .toggle input {
      width: 42px;
      height: 22px;
      appearance: none;
      background: #d1d5db;
      border-radius: 30px;
      position: relative;
      cursor: pointer;
      transition: .25s;
    }

    .toggle input:checked {
      background: var(--primary);
    }

    .toggle input::before {
      content: "";
      position: absolute;
      width: 18px;
      height: 18px;
      background: #fff;
      border-radius: 50%;
      top: 2px;
      left: 2px;
      transition: .25s;
    }

    .toggle input:checked::before {
      transform: translateX(20px);
    }
  </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<main class="main">
<?php include 'header.php'; ?>

<section class="content">
<h3>Admin Settings</h3>
<p>Manage system preferences, admin account, and security options.</p>

<?php if ($message): ?>
  <div class="alert"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<!-- SYSTEM SETTINGS -->
<div class="settings-card">
<h4><i class="bi bi-gear"></i> System Settings</h4>
<form method="post" enctype="multipart/form-data">

    <div class="form-group">
    <label>Site Name</label>
    <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name']) ?>">
  </div>
  <div class="form-group">
    <label>Admin Email</label>
    <input type="email" name="admin_email" value="<?= htmlspecialchars($settings['admin_email']) ?>">
  </div>
  <div class="form-actions">
    <button class="btn" name="save_system">Save Changes</button>
  </div>

</form>

</div><br>

<!-- ACCOUNT SETTINGS -->
<div class="settings-card">
<h4><i class="bi bi-person-circle"></i> Account Settings</h4>
<form method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label>Display Name</label>
    <input type="text" name="display_name"
           value="<?= htmlspecialchars($admin['display_name']) ?>">
  </div>

  <div class="form-group">
    <label>Profile Picture</label>
    <input type="file" name="avatar" accept="image/*">
  </div>

  <div class="form-group">
    <label>Username</label>
    <input type="text" >
  </div>

  <div class="form-group">
    <label>New Password</label>
    <input type="password" name="password">
  </div>

  <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" name="confirm_password">
  </div>

  <div class="form-actions">
    <button class="btn" name="update_account">Update Account</button>
  </div>

</form>

</div><br>

</section>
</main>
</body>
</html>
