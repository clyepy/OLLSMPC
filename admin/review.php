<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}
include "../connection.php";
$pageTitle = "Manage Reviews";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id=?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: review.php");
    exit;
}

// Handle like action via AJAX
if (isset($_POST['like_id'])) {
    $like_id = intval($_POST['like_id']);
    $stmt = $conn->prepare("UPDATE reviews SET likes = likes + 1 WHERE id=?");
    $stmt->bind_param("i", $like_id);
    $stmt->execute();
    
    // Get the updated like count
    $result = $conn->query("SELECT likes FROM reviews WHERE id=$like_id");
    $row = $result->fetch_assoc();
    
    echo $row['likes'];
    exit; // stop further rendering
}

// Fetch all reviews
$reviews = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - <?= $pageTitle ?></title>
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

.container { max-width: 900px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
h1 { text-align: center; margin-bottom: 30px; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
th { background: #f1f3f6; font-weight: bold; }
tr:hover { background: #fafafa; }
.btn { border-radius: 6px; font-size: 14px; padding: 6px 12px; }
.delete-btn { background: #dc3545; color: #fff; }
.delete-btn:hover { background: #b52a37; }
</style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<main class="main">
    <?php include 'header.php'; ?>

    <section class="content">
        <div class="container">
            <h1><?= $pageTitle ?></h1>

            <?php if ($reviews->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Date</th>
                        <th>Likes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $reviews->fetch_assoc()): ?>
                    <tr id="review-<?= $row['id'] ?>">
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?= $i <= $row['rating'] ? '★' : '☆' ?>
                            <?php endfor; ?>
                        </td>
                        <td><?= nl2br(htmlspecialchars($row['review'])) ?></td>
                        <td><?= date("F d, Y", strtotime($row['created_at'])) ?></td>
                        <td class="like-count"><?= $row['likes'] ?></td>
                        <td>
                            <button class="btn like-btn" data-id="<?= $row['id'] ?>">Like</button>
                            <a href="review.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Delete this review?')" class="btn delete-btn">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No reviews found.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
// Handle Like button clicks with AJAX
document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', () => {
        const reviewId = button.getAttribute('data-id');
        fetch('review.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'like_id=' + reviewId
        })
        .then(response => response.text())
        .then(newCount => {
            const row = document.getElementById('review-' + reviewId);
            row.querySelector('.like-count').textContent = newCount;
        })
        .catch(err => console.error(err));
    });
});
</script>

</body>
</html>
