<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
$pageTitle = "View Message";

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$conn->query("UPDATE contact_messages SET is_read=1 WHERE id=$id");

$msg = $conn->query("
  SELECT * FROM contact_messages WHERE id=$id
")->fetch_assoc();

if (!$msg) die("Message not found");

if (isset($_POST['send_reply'])) {

    $reply = '';

    $userMessage = trim($_POST['reply_message']);
    $template = $_POST['message_template'] ?? '';

    if ($userMessage !== '' && $template !== '') {
        $reply = str_replace(
            '{{CUSTOM_MESSAGE}}',
            $userMessage,
            $template
        );
    }

    if ($reply !== '') {
        $mail = new PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ollsmpc.helpdesk@gmail.com'; 
            $mail->Password   = 'cghc ubma mjgt rrom'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Email details
            $mail->setFrom('ollsmpc.helpdesk@gmail.com', 'OLLSMPC Admin');
            $mail->addAddress($msg['email'], $msg['name']);
            $mail->addReplyTo('ollsmpc.helpdesk@gmail.com', 'OLLSMPC Help Desk');

            $mail->Subject = 'Re: ' . $msg['subject'];
            $mail->Body    = $reply;
            $mail->isHTML(false);

            $mail->send();

            $stmt = $conn->prepare("
  INSERT INTO contact_replies (message_id, sender, body)
  VALUES (?, 'admin', ?)
");
$stmt->bind_param("is", $id, $reply);
$stmt->execute();


            echo "<script>alert('Reply sent successfully');</script>";

        } catch (Exception $e) {
            echo "<script>alert('Email failed: {$mail->ErrorInfo}');</script>";
        }
    }
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

<div class="card shadow-sm rounded p-4">
  <div class="d-flex justify-content-between align-items-start mb-3">
    <h4 class="mb-0"><?= htmlspecialchars($msg['subject']) ?></h4>
    <span class="badge <?= $msg['is_read'] ? 'bg-secondary' : 'bg-success' ?>">
      <?= $msg['is_read'] ? 'Read' : 'New' ?>
    </span>
  </div>

<p class="text-muted mb-3">
  <strong>From:</strong> <?= htmlspecialchars($msg['name']) ?><br>
  <strong>Email:</strong> <?= htmlspecialchars($msg['email']) ?><br>
  <strong>Phone:</strong> <?= htmlspecialchars($msg['phone']) ?><br>
  <strong>Date:</strong> <?= date("M d, Y h:i A", strtotime($msg['created_at'])) ?>
</p>


  <hr>

  <p style="white-space: pre-line;"><?= htmlspecialchars($msg['message']) ?></p>

  <hr>

<h5 class="mt-4">Reply</h5>

<form method="post">
  <div class="event-form">
    <div class="form-group">
      <label>To</label>
      <input type="text" value="<?= htmlspecialchars($msg['email']) ?>" disabled>
    </div>

    <div class="form-group">
      <label>Message</label>
<?php
$template = "Good day {$msg['name']},\n\n" .
"Thank you for reaching out to the OLLSMPC Help Desk. We sincerely appreciate you taking the time to contact us and for bringing your concern to our attention.\n\n" .
"We have carefully reviewed your inquiry regarding \"{$msg['subject']}\", and we are pleased to assist you\n\n".
"After evaluation, we would like to provide the following response:\n\n" .
"{{CUSTOM_MESSAGE}}\n\n" .
"Should you require further clarification or have additional questions related to this matter, please do not hesitate to contact us. Our team is always ready to assist and ensure that your concerns are addressed promptly and efficiently.\n\n" .
"Thank you for your patience, understanding, and continued support. We value your trust in OLLSMPC and look forward to serving you.\n\n\n\n" .
"Kind regards,\nOLLSMPC Help Desk Team";
?>

<input type="hidden" name="message_template" 
value="<?= htmlspecialchars($template, ENT_QUOTES, 'UTF-8') ?>">


<textarea name="reply_message" rows="6" required placeholder="Type your custom response here..."></textarea>

    </div>

    <button type="submit" name="send_reply" class="btn">
      <i class="bi bi-reply-fill"></i> Send Reply
    </button>
  </div>
</form>
</div>

</section>
</main>
</body>
</html>
