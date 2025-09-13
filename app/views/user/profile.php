<?php $session = load_class('Session', 'libraries'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    * { box-sizing: border-box; }

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
      max-width: 500px;
      background: #1e1e2f;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }

    .container h1 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 2rem;
    }

    .container p {
      text-align: center;
      margin-bottom: 20px;
      color: #bbb;
    }

    .flash {
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .success { background: #2e7d32; color: #fff; }
    .error { background: #c62828; color: #fff; }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
      border: 3px solid #6c63ff;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-weight: 600;
      margin-bottom: 5px;
      display: block;
    }

    input, button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
    }

    input {
      background: #2a2a40;
      color: #fff;
      outline: none;
      transition: 0.3s;
    }

    input:focus {
      box-shadow: 0 0 0 2px #6c63ff;
    }

    button {
      background: #6c63ff;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #5750d3;
    }

    .actions {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      gap: 10px;
    }

    .btn {
      flex: 1;
      text-align: center;
      background: #6c63ff;
      padding: 10px;
      border-radius: 8px;
      text-decoration: none;
      color: #fff;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn:hover {
      background: #5750d3;
    }

    .logout {
      background: #c62828;
    }

    .logout:hover {
      background: #a12020;
    }

    footer {
      margin-top: 15px;
      text-align: center;
      font-size: 0.8rem;
      color: #777;
    }

    @media (max-width: 480px) {
      .container { padding: 20px; }
      .container h1 { font-size: 1.6rem; }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>👤 My Profile</h1>
    <p>Manage and update your account details</p>

    <?php if ($session->flashdata('success')): ?>
      <div class="flash success"><?= htmlspecialchars($session->flashdata('success')) ?></div>
    <?php endif; ?>
    <?php if ($session->flashdata('error')): ?>
      <div class="flash error"><?= htmlspecialchars($session->flashdata('error')) ?></div>
    <?php endif; ?>

    <div style="text-align:center;">
      <?php if (!empty($user['photo'])): ?>
        <img src="<?= BASE_URL.'public/uploads/'.htmlspecialchars($user['photo']) ?>" alt="Profile Photo" class="profile-img">
      <?php else: ?>
        <img src="https://via.placeholder.com/120" alt="Default Avatar" class="profile-img">
      <?php endif; ?>
    </div>

    <form method="post" action="/user/update_profile" enctype="multipart/form-data">
      <label>First Name</label>
      <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>

      <label>Last Name</label>
      <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>

      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

      <label>New Password (leave blank to keep current)</label>
      <input type="password" name="password">

      <label>Update Photo</label>
      <input type="file" name="photo" accept="image/*">

      <button type="submit">💾 Update Profile</button>
    </form>

    <div class="actions">
      <a class="btn" href="/user/dashboard">🏠 Dashboard</a>
      <a class="btn logout" href="/auth/logout">🚪 Logout</a>
    </div>

    <footer>
      © <?= date("Y") ?> Student List System
    </footer>
  </div>

</body>
</html>
