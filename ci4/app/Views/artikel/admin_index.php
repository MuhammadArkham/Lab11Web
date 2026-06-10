<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<div class="row mb-3">
    <div class="col-md-8">
        <form id="search-form" class="form-inline" method="get">
            <input type="text" name="q" id="search-box" value="<?= $q; ?>" placeholder="Cari judul artikel..." class="form-control mr-2">
            <select name="kategori_id" id="category-filter" class="form-control mr-2">
                <option value="">-- Semua Kategori --</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>"
                        <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                        <?= $k['nama_kategori']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Cari" class="btn btn-primary mr-2">
            <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Reset</a>
        </form>
    </div>
    <div class="col-md-4 text-right">
        <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-success">+ Tambah Artikel</a>
    </div>
</div>

<!-- Loading indicator -->
<div id="loading-indicator" style="display:none; text-align:center; padding:20px;">
    <p>⏳ Memuat data...</p>
</div>

<div id="article-container">
    <table class="table">
        <thead>
            <tr>
                <th><a href="#" class="sort-link" data-sort="id">ID</a></th>
                <th><a href="#" class="sort-link" data-sort="judul">Judul</a></th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($artikel) > 0): foreach ($artikel as $row): ?>
            <tr>
                <td><?= $row->id; ?></td>
                <td>
                    <b><?= $row->judul; ?></b><br>
                    <small><?= substr($row->isi, 0, 50); ?>...</small>
                </td>
                <td><?= $row->nama_kategori ?? '-'; ?></td>
                <td><?= $row->status ? 'Aktif' : 'Draft'; ?></td>
                <td>
                    <a class="btn btn-sm btn-info"
                       href="<?= base_url('/admin/artikel/edit/' . $row->id); ?>">Ubah</a>
                    <a class="btn btn-sm btn-danger"
                       onclick="return confirm('Yakin hapus?');"
                       href="<?= base_url('/admin/artikel/delete/' . $row->id); ?>">Hapus</a>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="5" style="text-align:center">Tidak ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="pagination-container">
    <?= $pager; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const articleContainer = $('#article-container');
        const paginationContainer = $('#pagination-container');
        const searchForm = $('#search-form');
        const searchBox = $('#search-box');
        const categoryFilter = $('#category-filter');
        const loadingIndicator = $('#loading-indicator');

        let currentSort = '<?= $sort ?? 'id'; ?>';
        let currentOrder = '<?= $order ?? 'DESC'; ?>';

        const fetchData = (url) => {
            loadingIndicator.show();
            articleContainer.css('opacity', '0.5');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (data) {
                    loadingIndicator.hide();
                    articleContainer.css('opacity', '1');
                    renderArticles(data.artikel);
                    renderPagination(data.total, data.currentPage, data.perPage, data.q, data.kategori_id);
                },
                error: function () {
                    loadingIndicator.hide();
                    articleContainer.css('opacity', '1');
                    articleContainer.html('<p style="text-align:center; color:red;">Gagal memuat data.</p>');
                }
            });
        };

        const baseUrl = '<?= base_url(); ?>';

        const renderArticles = (articles) => {
            let html = '<table class="table">';
            html += '<thead><tr>';
            html += '<th><a href="#" class="sort-link" data-sort="id">ID ' + getSortIcon('id') + '</a></th>';
            html += '<th><a href="#" class="sort-link" data-sort="judul">Judul ' + getSortIcon('judul') + '</a></th>';
            html += '<th>Kategori</th>';
            html += '<th>Status</th>';
            html += '<th>Aksi</th>';
            html += '</tr></thead><tbody>';

            if (articles && articles.length > 0) {
                articles.forEach(article => {
                    html += `
                        <tr>
                            <td>${article.id}</td>
                            <td>
                                <b>${article.judul}</b>
                                <p><small>${article.isi ? article.isi.substring(0, 50) : ''}...</small></p>
                            </td>
                            <td>${article.nama_kategori || '-'}</td>
                            <td>${article.status == 1 ? 'Aktif' : 'Draft'}</td>
                            <td>
                                <a class="btn btn-sm btn-info" href="${baseUrl}/admin/artikel/edit/${article.id}">Ubah</a>
                                <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="${baseUrl}/admin/artikel/delete/${article.id}">Hapus</a>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html += '<tr><td colspan="5" style="text-align:center;">Tidak ada data.</td></tr>';
            }
            html += '</tbody></table>';
            articleContainer.html(html);

            // Re-bind sort links
            bindSortLinks();
        };

        const getSortIcon = (field) => {
            if (currentSort === field) {
                return currentOrder === 'ASC' ? '▲' : '▼';
            }
            return '';
        };

        const renderPagination = (total, currentPage, perPage, q, kategori_id) => {
            const totalPages = Math.ceil(total / perPage);
            if (totalPages <= 1) {
                paginationContainer.html('');
                return;
            }

            let html = '<nav><ul class="pagination">';
            for (let i = 1; i <= totalPages; i++) {
                let activeClass = (i === currentPage) ? 'active' : '';
                html += `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
            html += '</ul></nav>';
            paginationContainer.html(html);

            // Bind pagination click
            $('.page-link').click(function (e) {
                e.preventDefault();
                const page = $(this).data('page');
                const q = searchBox.val();
                const kategori_id = categoryFilter.val();
                fetchData(`${baseUrl}/admin/artikel?q=${q}&kategori_id=${kategori_id}&page=${page}&sort=${currentSort}&order=${currentOrder}`);
            });
        };

        const bindSortLinks = () => {
            $('.sort-link').click(function (e) {
                e.preventDefault();
                const sortField = $(this).data('sort');
                if (currentSort === sortField) {
                    currentOrder = currentOrder === 'ASC' ? 'DESC' : 'ASC';
                } else {
                    currentSort = sortField;
                    currentOrder = 'ASC';
                }
                const q = searchBox.val();
                const kategori_id = categoryFilter.val();
                fetchData(`${baseUrl}/admin/artikel?q=${q}&kategori_id=${kategori_id}&sort=${currentSort}&order=${currentOrder}`);
            });
        };

        // Bind sort links on initial page
        bindSortLinks();

        searchForm.on('submit', function (e) {
            e.preventDefault();
            const q = searchBox.val();
            const kategori_id = categoryFilter.val();
            fetchData(`${baseUrl}/admin/artikel?q=${q}&kategori_id=${kategori_id}&sort=${currentSort}&order=${currentOrder}`);
        });

        categoryFilter.on('change', function () {
            searchForm.trigger('submit');
        });

        // Initial Load
        fetchData(`${baseUrl}/admin/artikel`);
    });
</script>

<?= $this->include('template/admin_footer'); ?>
