<?= $this->include('template/header'); ?>

<h1>Data Artikel (AJAX)</h1>

<button id="btn-tambah" class="btn btn-primary" style="margin-bottom: 15px;">+ Tambah Data</button>

<!-- Modal Form -->
<div id="modal-form" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:20px; border-radius:5px;">
        <h3 id="form-title">Tambah Data</h3>
        <form id="form-data">
            <input type="hidden" id="form-id" name="id">
            <p>
                <label>Judul</label>
                <input type="text" id="form-judul" name="judul" class="form-control" required style="width:100%; padding:5px;">
            </p>
            <p>
                <label>Isi</label>
                <textarea id="form-isi" name="isi" rows="5" style="width:100%; padding:5px;"></textarea>
            </p>
            <p>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" id="btn-batal" class="btn btn-secondary">Batal</button>
            </p>
        </form>
    </div>
</div>

<table class="table-data" id="artikelTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Function to display a loading message while data is fetched
        function showLoadingMessage() {
            $('#artikelTable tbody').html('<tr><td colspan="4">Loading data...</td></tr>');
        }

        // Buat fungsi load data
        function loadData() {
            showLoadingMessage();

            $.ajax({
                url: "<?= base_url('ajax/getData') ?>",
                method: "GET",
                dataType: "json",
                success: function (data) {
                    var tableBody = "";
                    if (data.length === 0) {
                        tableBody = '<tr><td colspan="4" style="text-align:center;">Tidak ada data.</td></tr>';
                    }
                    for (var i = 0; i < data.length; i++) {
                        var row = data[i];
                        tableBody += '<tr>';
                        tableBody += '<td>' + row.id + '</td>';
                        tableBody += '<td>' + row.judul + '</td>';
                        tableBody += '<td><span class="status">' + (row.status == 1 ? 'Publish' : 'Draft') + '</span></td>';
                        tableBody += '<td>';
                        tableBody += '<a href="#" class="btn btn-sm btn-info btn-edit" data-id="' + row.id + '" data-judul="' + row.judul + '" data-isi="' + (row.isi || '') + '">Edit</a> ';
                        tableBody += '<a href="#" class="btn btn-sm btn-danger btn-delete" data-id="' + row.id + '">Delete</a>';
                        tableBody += '</td>';
                        tableBody += '</tr>';
                    }
                    $('#artikelTable tbody').html(tableBody);
                }
            });
        }

        loadData();

        // Tambah data
        $('#btn-tambah').click(function () {
            $('#form-title').text('Tambah Data');
            $('#form-id').val('');
            $('#form-judul').val('');
            $('#form-isi').val('');
            $('#modal-form').show();
        });

        // Batal
        $('#btn-batal').click(function () {
            $('#modal-form').hide();
        });

        // Edit data
        $(document).on('click', '.btn-edit', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var judul = $(this).data('judul');
            var isi = $(this).data('isi');
            $('#form-title').text('Ubah Data');
            $('#form-id').val(id);
            $('#form-judul').val(judul);
            $('#form-isi').val(isi);
            $('#modal-form').show();
        });

        // Submit form (tambah / ubah)
        $('#form-data').submit(function (e) {
            e.preventDefault();
            var id = $('#form-id').val();
            var judul = $('#form-judul').val();
            var isi = $('#form-isi').val();

            if (id) {
                // Update
                $.ajax({
                    url: "<?= base_url('ajax/update/') ?>" + id,
                    method: "POST",
                    data: { judul: judul, isi: isi },
                    dataType: "json",
                    success: function (data) {
                        $('#modal-form').hide();
                        loadData();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error: ' + textStatus);
                    }
                });
            } else {
                // Tambah
                $.ajax({
                    url: "<?= base_url('ajax/add') ?>",
                    method: "POST",
                    data: { judul: judul, isi: isi },
                    dataType: "json",
                    success: function (data) {
                        $('#modal-form').hide();
                        loadData();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error: ' + textStatus);
                    }
                });
            }
        });

        // Delete data
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                $.ajax({
                    url: "<?= base_url('ajax/delete/') ?>" + id,
                    method: "POST",
                    dataType: "json",
                    success: function (data) {
                        loadData();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error deleting article: ' + textStatus);
                    }
                });
            }
        });
    });
</script>

<?= $this->include('template/footer'); ?>
