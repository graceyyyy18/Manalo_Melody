<?php 
$session = load_class('Session', 'libraries'); 
$old = $session->flashdata('old') ?? []; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student List Login</title>
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
      max-width: 400px;
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
      margin-bottom: 25px;
      color: #bbb;
      font-size: 0.95rem;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
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

    button:focus {
      box-shadow: 0 0 0 2px #6c63ff;
      outline: none;
    }

    .container p.footer {
      margin-top: 20px;
      font-size: 0.9rem;
      color: #aaa;
      text-align: center;
    }

    .container a {
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

    @media (max-width: 480px) {
      .container {
        padding: 20px;
      }
      .container h1 {
        font-size: 1.6rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>STUDENT LIST</h1>
    <p>Manage and view all registered students</p>

    <h2>🔐 Login</h2>

    <?php if ($session->flashdata('success')): ?>
      <div class="flash success">
        <?= htmlspecialchars($session->flashdata('success')) ?>
      </div>
    <?php endif; ?>
    <?php if ($session->flashdata('error')): ?>
      <div class="flash error">
        <?= htmlspecialchars($session->flashdata('error')) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="/auth/login">
      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
      </div>

      <div>
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <button type="submit">Login</button>
    </form>

    <p class="footer">No account? <a href="/auth/register">Register here</a></p>
  </div>

  <footer>
    © <?= date("Y") ?> Student List System
  </footer>

</body>
</html>
