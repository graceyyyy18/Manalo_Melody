<?php $session = load_class('Session', 'libraries'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student</title>
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
      align-items: flex-start;
      min-height: 100vh;
      padding: 30px;
    }

    .container {
      width: 100%;
      max-width: 500px;
      background: #1e1e2f;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }

    .top-actions {
      display: flex;
      justify-content: flex-start;
      margin-bottom: 15px;
    }

    .back-btn {
      background: #444;
      color: #fff;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      font-size: 0.9rem;
      font-weight: 500;
      text-decoration: none;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: #666;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 1.8rem;
    }

    .container p.sub {
      text-align: center;
      margin-bottom: 25px;
      color: #bbb;
      font-size: 0.95rem;
    }

    .flash {
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 0.95rem;
    }
    .success { background: #2e7d32; color: #fff; }
    .error { background: #c62828; color: #fff; }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-weight: 600;
      margin-bottom: 5px;
      display: block;
      font-size: 0.95rem;
    }

    input, select {
      width: 100%;
      padding: 10px 12px;
      border-radius: 8px;
      border: none;
      outline: none;
      background: #2a2a40;
      color: #fff;
      font-size: 0.95rem;
      transition: 0.3s;
    }

    input:focus, select:focus {
      box-shadow: 0 0 0 2px #6c63ff;
    }

    input[type="file"] {
      padding: 8px;
      background: #2a2a40;
      cursor: pointer;
    }

    .photo-preview {
      margin-bottom: 10px;
      text-align: center;
    }

    .photo-preview img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #6c63ff;
    }

    button {
      background: #6c63ff;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #5750d3;
    }

    footer {
      margin-top: 20px;
      text-align: center;
      font-size: 0.85rem;
      color: #777;
    }
  </style>
</head>
<body>
  <div class="container">

    <!-- Back button -->
    <div class="top-actions">
      <a href="/students/get-all" class="back-btn">⬅ Back to List</a>
    </div>

    <h2>✏️ Edit Student</h2>
    <p class="sub">Update the student’s information below</p>

    <?php if ($session->flashdata('success')): ?>
      <div class="flash success"><?= htmlspecialchars($session->flashdata('success')) ?></div>
    <?php endif; ?>
    <?php if ($session->flashdata('error')): ?>
      <div class="flash error"><?= htmlspecialchars($session->flashdata('error')) ?></div>
    <?php endif; ?>

    <form method="post" action="/students/update/<?= (int) $user['id'] ?>" enctype="multipart/form-data">
      <div>
        <label>First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
      </div>

      <div>
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
      </div>

      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
      </div>

      <div>
        <label>Password (leave blank to keep current)</label>
        <input type="password" name="password">
      </div>

      <div>
        <label>Photo</label>
        <?php if (!empty($user['photo'])): ?>
          <div class="photo-preview">
            <img src="<?= $upload_url . htmlspecialchars($user['photo']) ?>" alt="Student Photo">
          </div>
        <?php endif; ?>
        <input type="file" name="photo" accept="image/*">
      </div>

      <button type="submit">💾 Update Student</button>
    </form>

    <footer>
      © <?= date("Y") ?> Student List System
    </footer>
  </div>
</body>
</html>
