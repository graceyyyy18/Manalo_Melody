<?php 
$session = load_class('Session', 'libraries'); 
$old = $session->flashdata('old') ?? []; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
    }

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
      max-width: 420px;
      background: #1e1e2f;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 1.8rem;
    }

    .flash {
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
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
    }

    input, select, button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
    }

    input, select {
      background: #2a2a40;
      color: #fff;
      outline: none;
      transition: 0.3s;
    }

    input:focus, select:focus {
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

    button:focus {
      box-shadow: 0 0 0 2px #6c63ff;
      outline: none;
    }

    p.footer {
      margin-top: 20px;
      font-size: 0.9rem;
      color: #aaa;
      text-align: center;
    }

    p.footer a {
      color: #6c63ff;
      text-decoration: none;
    }

    footer {
      position: fixed;
      bottom: 10px;
      width: 100%;
      text-align: center;
      font-size: 0.8rem;
      color: #777;
    }

    /* Responsive tweaks */
    @media (max-width: 480px) {
      .container {
        padding: 20px;
      }
      .container h2 {
        font-size: 1.6rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>📝 Register</h2>

    <?php if ($session->flashdata('success')): ?>
      <div class="flash success"><?= htmlspecialchars($session->flashdata('success')) ?></div>
    <?php endif; ?>
    <?php if ($session->flashdata('error')): ?>
      <div class="flash error"><?= htmlspecialchars($session->flashdata('error')) ?></div>
    <?php endif; ?>

    <form method="post" action="/auth/register" enctype="multipart/form-data">
      <div>
        <label>First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($old['first_name'] ?? '') ?>" required>
      </div>

      <div>
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($old['last_name'] ?? '') ?>" required>
      </div>

      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
      </div>

      <div>
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <div>
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
      </div>

      <div>
        <label>Photo</label>
        <input type="file" name="photo" accept="image/*">
      </div>

      <div>
        <label>Role</label>
        <select name="role" required>
          <option value="user" <?= (isset($old['role']) && $old['role'] === 'user') ? 'selected' : '' ?>>User</option>
        </select>
      </div>

      <button type="submit">Register</button>
    </form>

    <p class="footer">Already have an account? <a href="/auth/login">Login</a></p>
  </div>

  <footer>
    © <?= date("Y") ?> Student List System
  </footer>

</body>
</html>
