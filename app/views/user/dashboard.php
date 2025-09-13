<?php $session = load_class('Session', 'libraries'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: #0d0d2b;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 450px;
      background: #1e1e2f;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.6);
      text-align: center;
    }

    h2 {
      margin-bottom: 10px;
      font-size: 1.8rem;
    }

    .welcome {
      font-size: 1.2rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: 20px;
    }

    .flash {
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    .success { background: #2e7d32; color: #fff; }
    .error { background: #c62828; color: #fff; }

    .actions {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 10px;
    }

    .btn {
      display: block;
      padding: 12px;
      border-radius: 8px;
      background: #6c63ff;
      color: #fff;
      font-weight: 600;
      text-decoration: none;
      transition: 0.3s;
    }

    .btn:hover {
      background: #5750d3;
    }

    .logout {
      background: #c62828;
    }

    .logout:hover {
      background: #a61d1d;
    }

    footer {
      position: fixed;
      bottom: 10px;
      width: 100%;
      text-align: center;
      font-size: 0.8rem;
      color: #777;
    }

    @media (max-width: 480px) {
      .container {
        padding: 20px;
      }
      h2 {
        font-size: 1.6rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>🏠 Dashboard</h2>
    <p class="welcome">
      Welcome 👋
    </p>

    <?php if ($session->flashdata('success')): ?>
      <div class="flash success"><?= htmlspecialchars($session->flashdata('success')) ?></div>
    <?php endif; ?>

    <div class="actions">
      <a class="btn" href="/user/profile">👤 Profile</a>
      <a class="btn logout" href="/auth/logout">🚪 Logout</a>
    </div>
  </div>

  <footer>
    © <?= date("Y") ?> Student List System
  </footer>

</body>
</html>
