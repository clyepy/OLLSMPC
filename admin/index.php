<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OLLSMPC Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons (your allowed links) -->
    <link href="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEge0RJ6SJnCXtOfqBs_pC1iiGinjfmRIxeeg21XMn6zmaPJKDVUKaQMENOvVVRUqa3tSH9qgKHBlE6oG1xdO2R2BpoRGVH0bRpf_0JKCtwUfTh91A5egDDORHttS8nVEap65nq_rQhhH8R3_2f_HE8_gpG6zEgqhBH9DffWm-oMOLM4vw5Bv-YJDee-jvQ/s320/coop.png" rel="icon">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <link rel="stylesheet" href="admin-login.css">

  <style>* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Inter', sans-serif;
}

/* ===== VIDEO BACKGROUND ===== */
.video-bg {
  position: fixed;
  inset: 0;
  z-index: 1;
  overflow: hidden;
}

.video-bg video {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* ===== OVERLAY ===== */
.video-overlay {
  position: fixed;
  inset: 0;
  background: rgba(10, 20, 30, 0.65);
  z-index: 2;
}

/* ===== LOGIN WRAPPER ===== */
.login-wrapper {
  position: relative;
  z-index: 3;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.5rem;
}

/* ===== LOGIN CARD ===== */
.login-card {
  width: 100%;
  max-width: 420px;
  padding: 2.5rem;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.12);
  backdrop-filter: blur(14px);
  box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
  color: #fff;
}

/* ===== HEADER ===== */
.login-header {
  text-align: center;
  margin-bottom: 2rem;
}

.login-header i {
  font-size: 3rem;
  color: #00c6ff;
}

.login-header h2 {
  margin-top: 0.5rem;
  font-weight: 700;
}

.login-header p {
  font-size: 0.9rem;
  opacity: 0.85;
}

/* ===== FORM ===== */
.form-group {
  position: relative;
  margin-bottom: 1.2rem;
}

.form-group i {
  position: absolute;
  top: 50%;
  left: 14px;
  transform: translateY(-50%);
  color: #ccc;
}

.form-group input {
  width: 100%;
  padding: 14px 14px 14px 42px;
  border-radius: 12px;
  border: none;
  background: rgba(255, 255, 255, 0.18);
  color: #fff;
  font-size: 0.95rem;
  outline: none;
}

.form-group input::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

/* ===== BUTTON ===== */
.login-btn {
  width: 100%;
  margin-top: 1rem;
  padding: 14px;
  border-radius: 14px;
  border: none;
  background: linear-gradient(135deg, #00c6ff, #0072ff);
  color: #fff;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.login-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(0, 114, 255, 0.45);
}

/* ===== FOOTER ===== */
.login-footer {
  margin-top: 1.5rem;
  text-align: center;
  font-size: 0.8rem;
  opacity: 0.75;
}

/* ===== MOBILE FIX ===== */
@media (max-width: 480px) {
  .login-card {
    padding: 2rem;
  }
}
.form-options {
  text-align: right;
  margin-bottom: 1rem;
}

.form-options a {
  font-size: 0.85rem;
  color: #9fdcff;
  text-decoration: none;
  opacity: 0.85;
}

.form-options a:hover {
  text-decoration: underline;
  opacity: 1;
}
.login-error {
  background: rgba(255, 80, 80, 0.18);
  border: 1px solid rgba(255, 80, 80, 0.45);
  color: #ffb3b3;
  padding: 0.75rem 1rem;
  border-radius: 12px;
  font-size: 0.9rem;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 8px;
}


</style>
</head>
<body>

<!-- 🎥 VIDEO BACKGROUND -->
<div class="video-bg">
  <video autoplay muted loop playsinline>
    <source src="https://assets.mixkit.co/videos/229/229-720.mp4" type="video/mp4">
  </video>
</div>

<!-- 🌑 OVERLAY -->
<div class="video-overlay"></div>

<!-- 🔐 LOGIN CARD -->
<div class="login-wrapper">
  <div class="login-card">

<?php if ($error): ?>
  <div class="login-error">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

    <div class="login-header">
      <i class="bi bi-shield-lock-fill"></i>
      <h2>OLLSMPC Admin</h2>
      <p>Secure Administration Portal</p>
    </div>

    <form action="login-process.php" method="post">

      <div class="form-group">
        <i class="bi bi-person-fill"></i>
        <input type="text" name="username" placeholder="Username" required>
      </div>

      <div class="form-group">
        <i class="bi bi-lock-fill"></i>
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <div class="form-options">
  <a href="forgot-password.php">Forgot password?</a>
</div>

      <button type="submit" class="login-btn">
        Sign In
        <i class="bi bi-arrow-right-circle"></i>
      </button>

    </form>

    <div class="login-footer">
      © <?= date('Y'); ?> OLLSMPC
    </div>

  </div>
</div>

</body>
</html>
