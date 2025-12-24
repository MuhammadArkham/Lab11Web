<?php
$db = new Database();
$id = $_GET['id'];
$delete = $db->delete("artikel", "WHERE id='$id'");

if ($delete) {
    echo "<script>alert('Data dihapus'); window.location.href='/lab11_php_oop/index.php/artikel/index';</script>";
} else {
    echo "<script>alert('Gagal hapus'); window.location.href='/lab11_php_oop/index.php/artikel/index';</script>";
}
?>