<?php
require_once '../includes/session.php';
require_once '../config/db.php';
require_once '../includes/functions.php';
set_base_depth(1);
require_role(['admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid    = (int)($_POST['user_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $meId   = current_user()['id'];

    if ($uid && $uid !== $meId) {
        if ($action === 'suspend') {
            $pdo->prepare("UPDATE users SET status='suspended' WHERE id=?")->execute([$uid]);
            set_flash('success', 'User suspended.');
        } elseif ($action === 'activate') {
            $pdo->prepare("UPDATE users SET status='active' WHERE id=?")->execute([$uid]);
            set_flash('success', 'User activated.');
        } elseif ($action === 'delete') {
            $pdo->prepare("DELETE FROM users WHERE id=? AND role != 'admin'")->execute([$uid]);
            set_flash('success', 'User deleted.');
        }
    }
    redirect('manage-users.php');
}

$users = $pdo->query("SELECT * FROM users WHERE role != 'admin' ORDER BY created_at DESC")->fetchAll();
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Users – AccessTech Admin</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require '../includes/navbar.php'; ?>

<section class="section">
  <div class="section-header">
    <h2>Manage Users</h2>
    <p>View, suspend, activate or delete sellers and customers.</p>
  </div>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:1180px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <div class="table-wrap" style="max-width:1180px; margin:0 auto;">
    <table class="data-table">
      <thead>
        <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Phone</th><th>Status</th><th>Joined</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if (empty($users)): ?>
          <tr><td colspan="8" style="text-align:center;color:#9db4d4;padding:40px;">No users found.</td></tr>
        <?php else: ?>
        <?php foreach ($users as $u): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= e($u['full_name']) ?></td>
          <td><?= e($u['email']) ?></td>
          <td><span class="status-badge <?= $u['role']==='seller'?'status-pending':'status-approved' ?>"><?= ucfirst($u['role']) ?></span></td>
          <td><?= e($u['phone'] ?? '—') ?></td>
          <td><span class="status-badge <?= $u['status']==='active'?'status-approved':'status-rejected' ?>"><?= ucfirst($u['status']) ?></span></td>
          <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
          <td style="display:flex;gap:5px;flex-wrap:wrap;">
            <?php if ($u['status']==='active'): ?>
              <form method="POST"><input type="hidden" name="user_id" value="<?= $u['id'] ?>"><button name="action" value="suspend" class="btn-tiny reject">Suspend</button></form>
            <?php else: ?>
              <form method="POST"><input type="hidden" name="user_id" value="<?= $u['id'] ?>"><button name="action" value="activate" class="btn-tiny approve">Activate</button></form>
            <?php endif; ?>
            <form method="POST" onsubmit="return confirm('Delete this user? This cannot be undone.')">
              <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
              <button name="action" value="delete" class="btn-tiny delete">🗑 Delete</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>