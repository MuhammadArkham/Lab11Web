<?php
$db = new Database();
$form = new Form("", "Simpan Artikel");

if ($_POST) {
    $data = [
        'judul' => $_POST['judul'],
        'isi' => $_POST['isi']
    ];
    $simpan = $db->insert('artikel', $data);
    if ($simpan) {
        // Redirect absolut
        header("Location: /lab11_php_oop/index.php/artikel/index");
    } else {
        echo "Gagal menyimpan data";
    }
}

echo "<h3>Tambah Artikel</h3>";
$form->addField("judul", "Judul Artikel");
$form->addField("isi", "Isi Artikel", "textarea");
$form->displayForm();
?>