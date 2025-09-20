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
      background: #ffe6f0; /* pink background */
      color: #4d004d;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 500px;
      background: #ffb3d9; /* pink container */
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    h1 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 2rem;
      color: #800040;
    }

    p {
      text-align: center;
      margin-bottom: 20px;
      color: #660033;
    }

    .flash {
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .success { background: #ccffcc; color: #004d00; }
    .error { background: #ffcccc; color: #990000; }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
      border: 3px solid #ff66b3;
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
      background: #ff99cc;
      color: #4d004d;
      outline: none;
      transition: 0.3s;
    }

    input:focus {
      box-shadow: 0 0 0 2px #ff66b3;
    }

    button {
      background: #ff66b3;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #ff3399;
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
      background: #ff66b3;
      padding: 10px;
      border-radius: 8px;
      text-decoration: none;
      color: #fff;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn:hover { background: #ff3399; }
    .logout {
      background: #cc6699;
    }
    .logout:hover { background: #ff3385; }

    @media (max-width: 480px) {
      .container { padding: 20px; }
      h1 { font-size: 1.6rem; }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>My Profile</h1>
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

      <button type="submit">Update Profile</button>
    </form>

    <div class="actions">
      <a class="btn" href="/user/dashboard">Dashboard</a>
      <a class="btn logout" href="/auth/logout">Logout</a>
    </div>
  </div>

</body>
</html>
