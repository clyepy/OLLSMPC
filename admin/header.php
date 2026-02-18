<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../connection.php";

$adminData = [
    'display_name' => 'Administrator',
    'avatar' => null
];

if (!empty($_SESSION['admin_id'])) {

    $stmt = $conn->prepare("
        SELECT display_name, avatar
        FROM admins
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $_SESSION['admin_id']);
    $stmt->execute();
   $adminResult = $stmt->get_result();


    if ($row = $adminResult->fetch_assoc()) {
        $adminData = $row;
    }
}

$name   = $adminData['display_name'];
$avatar = $adminData['avatar'];
?>


  <style>
    .fancy-topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

/* LEFT */
.topbar-left {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.back-btn {
  background: var(--secondary);
  border: none;
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: grid;
  place-items: center;
  cursor: pointer;
  transition: background .2s, transform .2s;
}

.back-btn:hover {
  background: #e5e7eb;
  transform: translateX(-2px);
}

.page-title {
  margin: 0;
  font-size: 1.4rem;
}

/* SEARCH */
.topbar-search {
  flex: 1;
  max-width: 360px;
  position: relative;
}

.topbar-search i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--muted);
}

.topbar-search input {
  width: 100%;
  padding: .55rem .75rem .55rem 2.2rem;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  font-size: .9rem;
}

.topbar-search input:focus {
  outline: none;
  border-color: var(--primary);
}

/* RIGHT */
.topbar-right {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.datetime {
  text-align: right;
  font-size: .75rem;
  color: var(--muted);
  line-height: 1.2;
}

.datetime span {
  display: block;
}

  </style>
<header class="topbar fancy-topbar">

  <!-- LEFT -->
  <div class="topbar-left">
    <button class="back-btn" onclick="history.back()">
      <i class="bi bi-arrow-left"></i>
    </button>

    <h2 class="page-title">
      <?= $pageTitle ?? 'Dashboard'; ?>
    </h2>
  </div>

  <!-- CENTER -->
  <div class="topbar-search">
    <i class="bi bi-search"></i>
    <input type="text" id="adminSearch" placeholder="Search..." />
  </div>

  <!-- RIGHT -->
  <div class="topbar-right">
    <div class="datetime">
      <span id="date"></span>
      <span id="time"></span>
    </div>

<div class="user">
  <?php if (!empty($avatar)): ?>
    <img src="../<?= htmlspecialchars($avatar) ?>"
         class="avatar"
         style="object-fit:cover;">
  <?php else: ?>
    <div class="avatar">
      <?= strtoupper(substr($name, 0, 1)) ?>
    </div>
  <?php endif; ?>

  <span><?= htmlspecialchars($name) ?></span>
</div>


  </div>

</header>
<script>
document.addEventListener('DOMContentLoaded', () => {

  function updateDateTime() {
    const now = new Date();

    document.getElementById('date').textContent =
      now.toLocaleDateString(undefined, {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });

    document.getElementById('time').textContent =
      now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);

  const searchInput = document.getElementById('adminSearch');

  if (searchInput) {
    searchInput.addEventListener('keyup', function () {
      const value = this.value.toLowerCase();

      document.querySelectorAll('.content table tbody tr').forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
      });

      document.querySelectorAll('.card, .list-item').forEach(item => {
        const text = item.innerText.toLowerCase();
        item.style.display = text.includes(value) ? '' : 'none';
      });
    });
  }

});
</script>
