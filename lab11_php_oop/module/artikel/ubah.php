<?php
$db = new Database();
$id = $_GET['id'];
$data_awal = $db->get("artikel", "id='$id'");

if ($_POST) {
    $data = [
        'judul' => $_POST['judul'],
        'isi' => $_POST['isi']
    ];
    $update = $db->update('artikel', $data, "id='$id'");
    if ($update) {
        header("Location: /lab11_php_oop/index.php/artikel/index");
    } else {
        echo "Gagal mengubah data";
    }
}
?>
<h3>Ubah Artikel</h3>
<form action="" method="post">
    <table>
        <tr>
            <td>Judul</td>
            <td><input type="text" name="judul" value="<?= $data_awal['judul']; ?>"></td>
        </tr>
        <tr>
            <td>Isi</td>
            <td><textarea name="isi" cols="30" rows="4"><?= $data_awal['isi']; ?></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Simpan Perubahan"></td>
        </tr>
    </table>
</form>