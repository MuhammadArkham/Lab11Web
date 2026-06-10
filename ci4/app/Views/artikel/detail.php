<?= $this->include('template/header'); ?>

<article class="entry">
    <h2><?= $artikel['judul']; ?></h2>
    <p><strong>Kategori:</strong> <?= $artikel['nama_kategori'] ?? '-'; ?></p>
    <?php if ($artikel['gambar']): ?>
        <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>"
             alt="<?= $artikel['judul']; ?>" style="max-width:100%;margin-bottom:15px;">
    <?php endif; ?>
    <div class="artikel-content">
        <?= $artikel['isi']; ?>
    </div>
</article>
<br>
<a href="<?= base_url('/artikel'); ?>">&larr; Kembali ke Daftar Artikel</a>

<?= $this->include('template/footer'); ?>
