<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <p>
        <label>Judul Artikel</label>
        <input type="text" name="judul" value="<?= old('judul'); ?>" class="form-control" required>
    </p>
    <p>
        <label>Kategori</label>
        <select name="id_kategori" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>"
                    <?= (old('id_kategori') == $k['id_kategori']) ? 'selected' : ''; ?>>
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label>Isi Artikel</label>
        <textarea name="isi" class="form-control" cols="50" rows="10"><?= old('isi'); ?></textarea>
    </p>
    <p>
        <label>Gambar</label>
        <input type="file" name="gambar" class="form-control">
    </p>
    <p>
        <input type="submit" value="Simpan" class="btn btn-primary">
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Batal</a>
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>
