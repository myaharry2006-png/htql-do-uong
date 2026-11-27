<?php
$host = 'localhost';
$dbname = 'QLCuaHang';
$username = 'root';
$password = ''; // XAMPP mặc định thường để trống

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    exit('Không kết nối được cơ sở dữ liệu. Hãy kiểm tra MySQL và config/database.php.');
}
