<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
$pageTitle = "Messages";


session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
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
    padding: .4rem 1.0rem;
    border-radius: 10px;
    cursor: pointer;
    font-size: .6rem;
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
        width: 102%;
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

<h2 class="mb-4">Inbox</h2>

<div class="table-responsive shadow-sm rounded">
<table class="table table-hover align-middle mb-0">
<thead class="table-dark">
<tr>
  <th>Status</th>
  <th>Name</th>
  <th>Email</th>
  <th>Phone</th>
  <th>Subject</th>
  <th>Date</th>
  <th>Action</th>
</tr>
</thead>
<tbody>

<?php while($m = $messages->fetch_assoc()): ?>
<tr class="<?= $m['is_read'] ? '' : 'fw-bold'; ?>">
  <td>
    <span class="badge <?= $m['is_read'] ? 'bg-secondary' : 'bg-success' ?>">
      <?= $m['is_read'] ? 'Read' : 'New'; ?>
    </span>
  </td>
  <td><?= htmlspecialchars($m['name']) ?></td>
  <td><?= htmlspecialchars($m['email']) ?></td>
  <td><?= htmlspecialchars($m['phone']) ?></td>
  <td><?= htmlspecialchars($m['subject']) ?></td>
  <td><?= date("M d, Y h:i A", strtotime($m['created_at'])) ?></td>
  <td>
    <a href="messages-view.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-primary">
      View <i class="bi bi-eye"></i>
    </a>
  </td>
</tr>
<?php endwhile; ?>

<?php if($messages->num_rows == 0): ?>
<tr>
  <td colspan="7" class="text-center text-muted py-4">No messages yet</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

</section>
</main>
</body>
</html>
