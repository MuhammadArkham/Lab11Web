<?php
// Load konfigurasi database
include "config.php";
include "class/Database.php";

$db = new Database();

// 1. Password yang diinginkan
$password_baru = "admin123";

// 2. Generate Hash baru yang valid
$hash_baru = password_hash($password_baru, PASSWORD_DEFAULT);

// 3. Update database
// Kita gunakan query manual agar lebih yakin
$username = "admin";
$sql = "UPDATE users SET password = '$hash_baru' WHERE username = '$username'";

// Eksekusi
$result = $db->query($sql);

if ($result) {
    echo "<h1>Berhasil!</h1>";
    echo "<p>Password untuk user <b>admin</b> sudah di-reset.</p>";
    echo "<p>Password baru: <b>admin123</b></p>";
    echo "<p>Hash baru: $hash_baru</p>";
    echo "<br><a href='index.php/user/login'>Klik di sini untuk Login</a>";
} else {
    echo "<h1>Gagal!</h1>";
    echo "<p>Terjadi kesalahan saat update database.</p>";
}
?>