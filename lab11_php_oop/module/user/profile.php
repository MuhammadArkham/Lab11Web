<?php
// Cek harus login
if (!isset($_SESSION['is_login'])) {
    header('Location: /lab11_php_oop/index.php/user/login');
    exit;
}

$db = new Database();
$message = "";
$username = $_SESSION['username'];

// Ambil data user terbaru dari database
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $db->query($sql);
$data_user = $result->fetch_assoc();

// LOGIKA GANTI PASSWORD
if ($_POST) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];

    // 1. Cek Password Lama benar atau tidak
    if (password_verify($password_lama, $data_user['password'])) {
        
        // 2. Enkripsi Password Baru
        $hash_baru = password_hash($password_baru, PASSWORD_DEFAULT);
        
        // 3. Update ke Database
        $sql_update = "UPDATE users SET password = '$hash_baru' WHERE username = '$username'";
        $update = $db->query($sql_update);
        
        if ($update) {
            $message = "<div class='alert alert-success'>Password berhasil diubah!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Gagal mengubah password.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Password lama salah!</div>";
    }
}
?>

<div class="content-header">
    <h3 style="margin-bottom: 15px; color: #2c3e50;">Profil Pengguna</h3>
</div>

<?php if ($message) echo $message; ?>

<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); max-width: 600px;">
    <form action="" method="post">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Username</label>
            <input type="text" value="<?= $data_user['username']; ?>" readonly 
                   style="width: 100%; padding: 10px; background: #eee; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Lengkap</label>
            <input type="text" value="<?= $data_user['nama']; ?>" readonly 
                   style="width: 100%; padding: 10px; background: #eee; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
        
        <h4 style="margin-bottom: 15px; color: #4a90e2;">Ganti Password</h4>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Password Lama</label>
            <input type="password" name="password_lama" required placeholder="Masukkan password saat ini"
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Password Baru</label>
            <input type="password" name="password_baru" required placeholder="Masukkan password baru"
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <div style="margin-top: 20px;">
            <input type="submit" value="Simpan Perubahan" class="btn">
        </div>
    </form>
</div>