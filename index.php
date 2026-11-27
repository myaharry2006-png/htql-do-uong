<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: auth/login.php');
    exit;
}
require_once __DIR__ . '/config/database.php';

$user = $_SESSION['user'];
$role = $user['VaiTro'];

$totalDrinks = (int)$pdo->query("SELECT COUNT(*) FROM DODUONG")->fetchColumn();
$totalOrders = (int)$pdo->query("SELECT COUNT(*) FROM DONHANG")->fetchColumn();
$totalCategories = (int)$pdo->query("SELECT COUNT(*) FROM DANHMUC")->fetchColumn();

$allowed = [
    'Admin' => ['Trang chủ', 'Quản lý đồ uống', 'Danh mục & kho', 'Đơn hàng', 'Thống kê', 'Quản lý tài khoản'],
    'Manager' => ['Trang chủ', 'Quản lý đồ uống', 'Danh mục & kho', 'Đơn hàng', 'Thống kê'],
    'Staff' => ['Trang chủ', 'Đơn hàng'],
    'Warehouse Staff' => ['Trang chủ', 'Danh mục & kho']
];
$menus = $allowed[$role] ?? ['Trang chủ'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trang chủ - QLCuaHang</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="topbar">
    <strong>QLCuaHang</strong>
    <div>Xin chào, <?= htmlspecialchars($user['HoTen']) ?> · <?= htmlspecialchars($role) ?>
      <a class="logout" href="auth/logout.php">Đăng xuất</a>
    </div>
  </header>

  <div class="layout">
    <aside class="sidebar">
      <h3>MENU</h3>
      <?php foreach ($menus as $menu): ?>
        <div class="menu-item"><?= htmlspecialchars($menu) ?></div>
      <?php endforeach; ?>
    </aside>

    <main class="content">
      <h1>Trang chủ hệ thống</h1>
      <p class="muted">Tổng quan hoạt động cửa hàng đồ uống</p>

      <section class="stats">
        <article class="stat-card"><span>Tổng số đồ uống</span><strong><?= $totalDrinks ?></strong></article>
        <article class="stat-card"><span>Tổng số đơn hàng</span><strong><?= $totalOrders ?></strong></article>
        <article class="stat-card"><span>Danh mục đồ uống</span><strong><?= $totalCategories ?></strong></article>
      </section>

      <section class="panel">
        <h2>Thông tin tài khoản</h2>
        <p><b>Họ tên:</b> <?= htmlspecialchars($user['HoTen']) ?></p>
        <p><b>Tên đăng nhập:</b> <?= htmlspecialchars($user['TenDangNhap']) ?></p>
        <p><b>Vai trò:</b> <?= htmlspecialchars($role) ?></p>
      
      </section>
    </main>
  </div>
</body>
</html>
