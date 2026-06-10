<div class="widget-box">
<h3 class="title">Kategori Artikel</h3>
<ul>
<?php foreach ($kategori as $row): ?>
<li><a href="<?= base_url('/artikel?kategori=' . $row['id_kategori']) ?>"><?= $row['nama_kategori'] ?></a></li>
<?php endforeach; ?>
</ul>
</div>
