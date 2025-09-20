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
      background: #ffe6f0; /* pink background */
      color: #4d004d;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 30px;
    }

    .container {
      width: 100%;
      max-width: 500px;
      background: #ffb3d9; /* pink container */
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .top-actions {
      display: flex;
      justify-content: flex-start;
      margin-bottom: 15px;
    }

    .back-btn {
      background: #cc6699;
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
      background: #ff66b3;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 1.8rem;
      color: #800040;
    }

    .container p.sub {
      text-align: center;
      margin-bottom: 25px;
      color: #660033;
      font-size: 0.95rem;
    }

    .flash {
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 0.95rem;
    }
    .success { background: #ccffcc; color: #004d00; }
    .error { background: #ffcccc; color: #990000; }

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
      background: #ffd6eb;
      color: #4d004d;
      font-size: 0.95rem;
      transition: 0.3s;
    }

    input:focus, select:focus {
      box-shadow: 0 0 0 2px #ff66b3;
    }

    input[type="file"] {
      padding: 8px;
      background: #ffd6eb;
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
      border: 3px solid #ff66b3;
    }

    button {
      background: #ff66b3;
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
      background: #ff3399;
    }
  </style>
</head>
<body>
  <div class="container">

    <!-- Back button -->
    <div class="top-actions">
      <a href="/students/get-all" class="back-btn">Back to List</a>
    </div>

    <h2>Edit Student</h2>
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

      <button type="submit">Update Student</button>
    </form>

  </div>
</body>
</html>
