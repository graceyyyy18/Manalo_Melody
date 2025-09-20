<?php $session = load_class('Session', 'libraries'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students List</title>
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
      max-width: 1100px;
      background: #ffb3d9; /* pink container */
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .container h2 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 2rem;
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

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 20px;
      gap: 15px;
    }

    .btn {
      background: #ff66b3;
      color: #fff;
      padding: 8px 14px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 600;
      display: inline-block;
      transition: 0.3s;
    }
    .btn:hover { background: #ff3399; }
    .btn.logout { background: #d32f2f; }
    .btn.logout:hover { background: #b22222; }
    .btn.secondary { background: #cc6699; }
    .btn.danger { background: #e60073; }
    .btn.restore { background: #ff3385; }

    .search-bar input {
      padding: 10px 12px;
      border: none;
      border-radius: 8px;
      background: #ffd6eb;
      color: #4d004d;
      outline: none;
      width: 220px;
      font-size: 0.95rem;
      transition: 0.3s;
    }
    .search-bar input:focus {
      box-shadow: 0 0 0 2px #ff66b3;
    }

    .list {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .list thead {
      background: #ff99cc;
    }
    .list th, .list td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ff80bf;
    }
    .list th {
      font-weight: 700;
      color: #fff;
      text-transform: uppercase;
      font-size: 0.85rem;
    }
    .list td {
      font-size: 0.95rem;
      color: #4d004d;
    }

    .list img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
      vertical-align: middle;
    }

    .actions-col {
      white-space: nowrap;
    }

    .pagination {
      margin-top: 25px;
      text-align: center;
    }
    .pagination ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: inline-flex;
      gap: 8px;
    }
    .pagination a {
      display: inline-block;
      padding: 8px 14px;
      border-radius: 8px;
      background: #ffd6eb;
      color: #4d004d;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }
    .pagination a:hover { background: #ff66b3; }

    @media (max-width: 768px) {
      .top-bar { flex-direction: column; align-items: flex-start; gap: 10px; }
      .search-bar input { width: 100%; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Students List</h2>
    <p class="sub">Manage and view all registered students</p>

    <!-- FLASH -->
    <?php if ($session->flashdata('success')): ?>
      <div class="flash success"><?= htmlspecialchars($session->flashdata('success')) ?></div>
    <?php endif; ?>
    <?php if ($session->flashdata('error')): ?>
      <div class="flash error"><?= htmlspecialchars($session->flashdata('error')) ?></div>
    <?php endif; ?>

    <!-- TOP BAR -->
    <div class="top-bar">
      <div class="actions">
        <a class="btn" href="/students/create">Add New</a>
        <a class="btn logout" href="/auth/logout">Logout</a>
        <?php if (!empty($show_deleted)): ?>
          <a class="btn secondary" href="/students/get-all">Show Active</a>
        <?php else: ?>
          <a class="btn secondary" href="/students/get-all?show=deleted">Show Deleted</a>
        <?php endif; ?>
      </div>

      <div class="search-bar">
        <form method="get" action="/students/get-all">
          <?php if (!empty($show_deleted)): ?>
            <input type="hidden" name="show" value="deleted">
          <?php endif; ?>
          <input type="text" name="search" placeholder="Search students..." value="<?= htmlspecialchars($search ?? '') ?>">
          <button type="submit" class="btn">Search</button>
        </form>
      </div>
    </div>

    <!-- STUDENTS TABLE -->
    <?php if (!empty($records)): ?>
      <table class="list">
        <thead>
          <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($records as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['id']) ?></td>
              <td>
                <img src="<?= !empty($r['photo']) ? BASE_URL.'public/uploads/'.htmlspecialchars($r['photo']) : 'https://via.placeholder.com/40' ?>" 
                     alt="Photo of <?= htmlspecialchars($r['first_name']) ?>">
              </td>
              <td><?= htmlspecialchars($r['first_name']) ?></td>
              <td><?= htmlspecialchars($r['last_name']) ?></td>
              <td><?= htmlspecialchars($r['email']) ?></td>
              <td class="actions-col">
                <?php if (empty($show_deleted)): ?>
                  <a class="btn" href="/students/update/<?= $r['id'] ?>">Edit</a>
                  <a class="btn danger" href="/students/delete/<?= $r['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
                <?php else: ?>
                  <a class="btn restore" href="/students/restore/<?= $r['id'] ?>">Restore</a>
                  <a class="btn danger" href="/students/hard_delete/<?= $r['id'] ?>" onclick="return confirm('Permanently delete?')">Hard Delete</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p style="text-align:center; margin-top:20px;">No students found.</p>
    <?php endif; ?>

    <!-- PAGINATION -->
    <div class="pagination">
      <?php
        if (!empty($pagination_links)) {
          echo "<ul>" . str_replace(
              ['<ul>', '</ul>', '<li>', '</li>'],
              ['', '', '<li>', '</li>'], 
              $pagination_links
          ) . "</ul>";
        }
      ?>
    </div>
  </div>
</body>
</html>
