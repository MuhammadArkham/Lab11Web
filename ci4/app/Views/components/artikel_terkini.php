<div class="widget-box">
    <h3 class="title">Artikel Terkini: <?= esc($kategori) ?></h3>
    <ul>
        <?php if ($artikel): foreach ($artikel as $row): ?>
            <li>
                <a href="<?= base_url('/artikel/' . $row['slug']) ?>">
                    <?= esc($row['judul']) ?>
                </a>
            </li>
        <?php endforeach; else: ?>
            <li>Tidak ada artikel.</li>
        <?php endif; ?>
    </ul>
</div>