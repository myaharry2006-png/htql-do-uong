<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenDangNhap = trim($_POST['TenDangNhap'] ?? '');
    $matKhau = $_POST['MatKhau'] ?? '';

    if ($tenDangNhap === '' || $matKhau === '') {
        $error = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT MaNV, HoTen, TenDangNhap, MatKhau, VaiTro
             FROM NHANVIEN WHERE TenDangNhap = ? LIMIT 1'
        );
        $stmt->execute([$tenDangNhap]);
        $user = $stmt->fetch();

        if ($user && password_verify($matKhau, $user['MatKhau'])) {
            session_regenerate_id(true);
            unset($user['MatKhau']);
            $_SESSION['user'] = $user;
            header('Location: ../index.php');
            exit;
        } else {
            $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập - QLCuaHang</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="login-page">
  <main class="login-card">
    <h1>QUẢN LÝ CỬA HÀNG ĐỒ UỐNG</h1>
    <p class="muted">Đăng nhập vào hệ thống</p>

    <?php if ($error): ?>
      <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <label>Tên đăng nhập</label>
      <input name="TenDangNhap" type="text" required autocomplete="username"
             value="<?= htmlspecialchars($_POST['TenDangNhap'] ?? '') ?>">
      <label>Mật khẩu</label>
      <input name="MatKhau" type="password" required autocomplete="current-password">
      <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>
