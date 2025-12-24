<?php
// BAGIAN 1: LOGIKA PHP (PENTING! Jangan dihapus)
// Ini berfungsi untuk mengambil data dari database
$db = new Database();
$sql = "SELECT * FROM artikel ORDER BY id DESC";
$result = $db->query($sql);
?>

<div class="content-header">
    <h3 style="margin-bottom: 15px; color: #2c3e50;">Daftar Artikel</h3>
    <a href="/lab11_php_oop/index.php/artikel/tambah" class="btn">Tambah Artikel Baru</a>
</div>

<br>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #4a90e2; color: white;">
            <th style="padding: 12px; text-align: left; width: 50px;">ID</th>
            <th style="padding: 12px; text-align: left;">Judul Artikel</th>
            <th style="padding: 12px; text-align: left; width: 200px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 12px;"><?= $row['id']; ?></td>
                <td style="padding: 12px;"><?= $row['judul']; ?></td>
                <td style="padding: 12px;">
                    <a href="/lab11_php_oop/index.php/artikel/ubah?id=<?= $row['id']; ?>" 
                       style="text-decoration:none; color:#2980b9; font-weight:bold; margin-right: 10px;">
                        ✏️ Ubah
                    </a>
                    
                    <a href="/lab11_php_oop/index.php/artikel/hapus?id=<?= $row['id']; ?>" 
                       onclick="return confirm('Yakin hapus?')" 
                       style="text-decoration:none; color:#c0392b; font-weight:bold;">
                        🗑️ Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" style="text-align:center; padding: 20px; color: #777;">
                    Belum ada data artikel. Silakan tambah data baru.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>