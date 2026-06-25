# Laporan Praktikum Pemrograman Web 2 - Lab11Web

![PHP](https://img.shields.io/badge/PHP-8.1-%23777BB4?style=flat&logo=php)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-%23EF4223?style=flat&logo=codeigniter)
![MySQL](https://img.shields.io/badge/MySQL-8.0-%234479A1?style=flat&logo=mysql)
![jQuery](https://img.shields.io/badge/jQuery-AJAX-%230769AD?style=flat&logo=jquery)
![License](https://img.shields.io/badge/License-MIT-%23-yellow?style=flat)
![Repo Size](https://img.shields.io/github/repo-size/MuhammadArkham/Lab11Web?style=flat)
![Last Commit](https://img.shields.io/github/last-commit/MuhammadArkham/Lab11Web?style=flat)

---

**Mata Kuliah:** Pemrograman Web 2  
**Dosen Pengampu:** Agung Nugroho, S.Kom., M.Kom.  
**Nama:** Muhammad Arkhamullah R.A  
**NIM:** 312410545  
**Kelas:** I241E  
**Program Studi:** Teknik Informatika  
**Universitas Pelita Bangsa**

---

Repositori Backend (Server-side) berbasis **CodeIgniter 4** yang melingkupi **Modul 7, 8, dan 10** — Fokus pada Relasi Tabel, Upload File, AJAX, dan REST API.

---

## Daftar Isi

1. [Praktikum 7: Relasi Tabel & Upload File Gambar](#praktikum-7-relasi-tabel--upload-file-gambar)
2. [Praktikum 8: Modifikasi Data via AJAX](#praktikum-8-modifikasi-data-via-ajax)
3. [Praktikum 10: Pembuatan REST API Backend](#praktikum-10-pembuatan-rest-api-backend)
4. [Kode Program Lengkap](#kode-program-lengkap)
5. [Struktur Folder](#struktur-folder)

---

## Praktikum 7: Relasi Tabel & Upload File Gambar

### Tujuan Praktikum

Mahasiswa mampu memahami relasi antar tabel database dan mengolah form input bertipe `file` untuk upload gambar.

### Langkah-langkah Praktikum

1. **Struktur Tabel Database.** Tabel `artikel` memiliki foreign key `id_kategori` yang merujuk ke tabel `kategori`.

```sql
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    slug_kategori VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

ALTER TABLE artikel ADD COLUMN id_kategori INT;
ALTER TABLE artikel ADD FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori);
```

2. **Controller Artikel (Upload File + Relasi JOIN).**

```php
<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title   = 'Daftar Artikel';
        $model   = new ArtikelModel();
        $artikel = $model->db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
            ->where('artikel.status', 1)
            ->get()
            ->getResultArray();
        return view('artikel/index', compact('artikel', 'title'));
    }

    public function add()
    {
        $kategoriModel = new KategoriModel();
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            helper('url');
            $model = new ArtikelModel();
            $insertData = [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'slug'        => url_title($this->request->getPost('judul'), '-', true),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'status'      => 0,
            ];

            // Handle file upload
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/gambar', $newName);
                $insertData['gambar'] = $newName;
            }

            $model->insert($insertData);
            return redirect()->to('/admin/artikel');
        }

        return view('artikel/form_add', [
            'title'    => 'Tambah Artikel',
            'kategori' => $kategoriModel->findAll(),
        ]);
    }

    public function edit($id)
    {
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($this->request->getMethod() == 'post' && $isDataValid) {
            $updateData = [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
            ];

            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/gambar', $newName);
                $updateData['gambar'] = $newName;
            }

            $model->update($id, $updateData);
            return redirect()->to('/admin/artikel');
        }

        return view('artikel/form_edit', [
            'title'    => 'Edit Artikel',
            'artikel'  => $model->find($id),
            'kategori' => $kategoriModel->findAll(),
        ]);
    }

    public function delete($id)
    {
        (new ArtikelModel())->delete($id);
        return redirect()->to('/admin/artikel');
    }
}
```

3. **Admin Index dengan JOIN + Pagination + Search + Filter Kategori.**

```php
public function admin_index()
{
    $title       = 'Daftar Artikel (Admin)';
    $model       = new ArtikelModel();
    $q           = $this->request->getVar('q') ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';

    $builder = $model->db->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

    if ($q != '') {
        $builder->like('artikel.judul', $q);
    }
    if ($kategori_id != '') {
        $builder->where('artikel.id_kategori', $kategori_id);
    }

    $artikel = $builder->orderBy('id', 'DESC')->paginate(10);
    $pager   = $model->pager;

    return view('artikel/admin_index', [
        'title'       => $title,
        'q'           => $q,
        'kategori_id' => $kategori_id,
        'artikel'     => $artikel,
        'kategori'    => (new KategoriModel())->findAll(),
        'pager'       => $pager,
    ]);
}
```

### Pertanyaan dan Tugas

> **Pertanyaan:** Selesaikan programnya sesuai Langkah-langkah yang ada. Anda boleh melakukan improvisasi.
>
> **Jawaban:** Telah diselesaikan upload file gambar dengan validasi ekstensi (hanya gambar), rename otomatis menggunakan `getRandomName()`, dan penyimpanan ke folder `public/gambar`. Relasi JOIN dengan tabel kategori ditambahkan untuk menampilkan nama kategori di daftar artikel.

### Dokumentasi Screenshot

| Tampilan | Screenshot |
|----------|-----------|
| Halaman Login Admin | ![Login Admin](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/m7_user_login.png?raw=true) |
| Halaman Admin - Daftar Artikel | ![Admin Artikel](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/m7_admin_daftar_artikel.png?raw=true) |
| Form Tambah Artikel | ![Tambah Artikel](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/m7_admin_tambah_artikel.png?raw=true) |
| Form Edit Artikel | ![Edit Artikel](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/m7_admin_edit_artikel.png?raw=true) |

---

## Praktikum 8: Modifikasi Data via AJAX

### Tujuan Praktikum

Mahasiswa mampu memodifikasi data artikel (CRUD) menggunakan mekanisme asinkron jQuery AJAX tanpa reload halaman.

### Langkah-langkah Praktikum

1. **Controller Mendukung AJAX.** Controller `Artikel::admin_index` mendeteksi permintaan AJAX dan mereturn JSON.

```php
// app/Controllers/Artikel.php
$data = [
    'title'       => $title,
    'artikel'     => $artikel,
    'kategori'    => (new KategoriModel())->findAll(),
    'pager'       => $pager,
    'q'           => $q,
    'kategori_id' => $kategori_id,
];

if ($this->request->isAJAX()) {
    return $this->response->setJSON($data);
}

return view('artikel/admin_index', $data);
```

2. **jQuery AJAX untuk Load Data.**

```js
function fetchData(page, sort, order) {
    $.ajax({
        url: '/admin/artikel',
        type: 'GET',
        data: {
            page: page,
            sort: sort,
            order: order,
            q: $('#search-box').val(),
            kategori_id: $('#kategori-filter').val()
        },
        dataType: 'json',
        beforeSend: function() {
            $('#loading-indicator').show();
        },
        success: function(response) {
            var html = '';
            $.each(response.artikel, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.id + '</td>';
                html += '<td>' + item.judul + '</td>';
                html += '<td>' + item.nama_kategori + '</td>';
                html += '<td>' + (item.status == 1 ? 'Publik' : 'Draft') + '</td>';
                html += '<td><a href="/admin/artikel/edit/' + item.id + '">Edit</a> ';
                html += '<a href="/admin/artikel/delete/' + item.id + '" onclick="return confirm(\'Yakin?\')">Hapus</a></td>';
                html += '</tr>';
            });
            $('#artikel-table tbody').html(html);
            $('#pagination-links').html(response.pager);
        },
        complete: function() {
            $('#loading-indicator').hide();
        }
    });
}
```

3. **Route AJAX.**

```php
// app/Config/Routes.php
$routes->get('/admin/artikel', 'Artikel::admin_index');
$routes->post('/admin/artikel/add', 'Artikel::add_ajax');
$routes->post('/admin/artikel/edit/(:num)', 'Artikel::edit_ajax/$1');
$routes->delete('/admin/artikel/delete/(:num)', 'Artikel::delete_ajax/$1');
```

### Pertanyaan dan Tugas

> **Pertanyaan:** Selesaikan programnya sesuai Langkah-langkah yang ada. Tambahkan fungsi untuk tambah dan ubah data. Anda boleh melakukan improvisasi.
>
> **Jawaban:** Telah ditambahkan method `add_ajax()`, `edit_ajax()`, dan `delete_ajax()` pada controller Artikel. Route POST untuk tambah (`/admin/artikel/add`), POST untuk edit (`/admin/artikel/edit/(:num)`), dan DELETE untuk hapus (`/admin/artikel/delete/(:num)`). Data dikirim dan diterima secara asinkron tanpa reload halaman menggunakan jQuery AJAX.

### Dokumentasi Screenshot

| Tampilan | Screenshot |
|----------|-----------|
| Tabel Artikel dengan AJAX Async | ![AJAX Data](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/m8_ajax_data_artikel.png?raw=true) |

---

## Praktikum 10: Pembuatan REST API Backend

### Tujuan Praktikum

Mahasiswa mampu membangun REST API Backend menggunakan **ResourceController** CodeIgniter 4 dengan autentikasi token.

### Langkah-langkah Praktikum

1. **Controller REST API (Post.php).** Menggunakan `ResourceController` bawaan CI4.

```php
<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    // GET /post - Tampilkan semua artikel
    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    // GET /post/{id} - Tampilkan satu artikel
    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Data tidak ditemukan.');
    }

    // POST /post - Tambah artikel baru
    public function create()
    {
        helper('url');
        $model = new ArtikelModel();
        $data = [
            'judul'  => $this->request->getVar('judul'),
            'isi'    => $this->request->getVar('isi'),
            'slug'   => url_title($this->request->getVar('judul'), '-', true),
            'status' => $this->request->getVar('status') ?? 0,
        ];
        $model->insert($data);
        return $this->respondCreated([
            'status'   => 201,
            'messages' => ['success' => 'Data artikel berhasil ditambahkan.']
        ]);
    }

    // PUT /post/{id} - Update artikel
    public function update($id = null)
    {
        $model = new ArtikelModel();
        $rawData = $this->request->getRawInput();
        $id = $rawData['id'] ?? $id;
        $data = [
            'judul'  => $rawData['judul'] ?? $this->request->getVar('judul'),
            'isi'    => $rawData['isi'] ?? $this->request->getVar('isi'),
            'status' => $rawData['status'] ?? $this->request->getVar('status'),
        ];
        $data = array_filter($data, function($v) { return $v !== null; });
        $model->update($id, $data);
        return $this->respond([
            'status'   => 200,
            'messages' => ['success' => 'Data artikel berhasil diubah.']
        ]);
    }

    // DELETE /post/{id} - Hapus artikel
    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            $model->delete($id);
            return $this->respondDeleted([
                'status'   => 200,
                'messages' => ['success' => 'Data artikel berhasil dihapus.']
            ]);
        }
        return $this->failNotFound('Data tidak ditemukan.');
    }
}
```

2. **Route REST API + Login.**

```php
// app/Config/Routes.php
$routes->resource('post', ['filter' => 'apiauth']);
$routes->post('/api/login', 'Auth::login');
```

3. **ApiAuthFilter (Autentikasi Token).** Memvalidasi header `Authorization: Bearer` pada setiap request.

```php
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class ApiAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');

        if (!$authHeader) {
            $response = Services::response();
            $response->setStatusCode(401);
            return $response->setJSON([
                'status'   => 401,
                'error'    => 401,
                'messages' => 'Akses Ditolak. Token tidak ditemukan pada request!'
            ]);
        }

        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (!$token || empty($token)) {
            $response = Services::response();
            $response->setStatusCode(401);
            return $response->setJSON([
                'status'   => 401,
                'error'    => 401,
                'messages' => 'Sesi Token tidak valid atau kedaluwarsa!'
            ]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
```

4. **CORS Support** (untuk akses dari frontend Vue.js).

```php
// router.php - Fallback untuk php built-in server
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}
```

### Hasil Uji Coba REST API

| Method | Endpoint | Token | Status | Response |
|--------|----------|-------|--------|----------|
| GET | `/post` | Tidak | 200 | JSON array seluruh artikel |
| GET | `/post/{id}` | Tidak | 200 | JSON object detail artikel |
| POST | `/post` | Wajib | 201 | `{"status":201,"messages":{"success":"Data artikel berhasil ditambahkan."}}` |
| PUT | `/post/{id}` | Wajib | 200 | `{"status":200,"messages":{"success":"Data artikel berhasil diubah."}}` |
| DELETE | `/post/{id}` | Wajib | 200 | `{"status":200,"messages":{"success":"Data artikel berhasil dihapus."}}` |
| POST | `/api/login` | Tidak | 200 | JSON token autentikasi |

### Dokumentasi Screenshot

Screenshot hasil uji coba REST API menggunakan Postman:

| Endpoint | Screenshot |
|----------|-----------|
| GET /post (Menampilkan Semua Data) | ![GET Post](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-06-25%20211227.png?raw=true) |
| POST /post (Menambahkan Data Baru) | ![POST Post](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-06-25%20211257.png?raw=true) |
| PUT/DELETE /post (Update & Hapus Data) | ![PUT DELETE Post](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-06-25%20211337.png?raw=true) |
| API 404 Not Found | ![API 404](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/m10_api_404_not_found.png?raw=true) |

### Pertanyaan dan Tugas

> **Pertanyaan:** Selesaikan programnya sesuai Langkah-langkah yang ada. Anda boleh melakukan improvisasi.
>
> **Jawaban:** REST API telah dibangun menggunakan `ResourceController` CI4 dengan endpoint: GET `/post`, GET `/post/{id}`, POST `/post`, PUT `/post/{id}`, DELETE `/post/{id}`. ApiAuthFilter memvalidasi token Bearer pada setiap request. CORS diaktifkan via `router.php` untuk akses dari frontend Vue.js. Login API di `/api/login` mengembalikan token autentikasi.

---

## Kode Program Lengkap

| File | Path | Keterangan |
|------|------|-----------|
| Controller Artikel | `app/Controllers/Artikel.php` | CRUD artikel, upload gambar, JOIN kategori, AJAX |
| Controller Post | `app/Controllers/Post.php` | REST API ResourceController (GET, POST, PUT, DELETE) |
| Controller Auth | `app/Controllers/Auth.php` | Login API |
| Model Artikel | `app/Models/ArtikelModel.php` | Model tabel artikel |
| Model Kategori | `app/Models/KategoriModel.php` | Model tabel kategori |
| Filter ApiAuth | `app/Filters/ApiAuthFilter.php` | Validasi token Bearer REST API |
| Routes | `app/Config/Routes.php` | Definisi route web + API |
| router.php | `ci4/router.php` | CORS handler |
| View Admin | `app/Views/artikel/admin_index.php` | Tabel admin + pagination + search |

---

## Cara Menjalankan

```bash
# 1. Jalankan server CI4
cd ci4
php spark serve --port=8081

# 2. Atau menggunakan built-in PHP
php -S localhost:8081 router.php

# 3. Akses di browser
#    http://localhost:8081/          -> Halaman publik
#    http://localhost:8081/admin/artikel  -> Panel admin
#    http://localhost:8081/post       -> REST API
```

**Kredensial Admin:**
- Email: `admin@email.com`
- Password: `admin123`

---

## Struktur Folder

```
Lab11Web/
├── ci4/                                # CodeIgniter 4 Framework
│   ├── app/
│   │   ├── Config/                     # Routes, Filters, Database
│   │   ├── Controllers/                # Artikel, Post, Auth
│   │   ├── Models/                     # ArtikelModel, KategoriModel
│   │   ├── Views/                      # Template, artikel, AJAX
│   │   └── Filters/                    # ApiAuthFilter
│   ├── public/                         # Entry point
│   │   └── gambar/                     # Upload file gambar
│   ├── router.php                      # CORS handler
│   └── ...
├── Secrenshoot/                        # Dokumentasi screenshot praktikum
│   ├── m7_user_login.png               # Login admin
│   ├── m7_admin_daftar_artikel.png     # Daftar artikel admin
│   ├── m7_admin_tambah_artikel.png     # Form tambah artikel
│   ├── m7_admin_edit_artikel.png       # Form edit artikel
│   ├── m8_ajax_data_artikel.png        # AJAX data artikel
│   └── m10_api_404_not_found.png       # REST API error 404
└── README.md
```

---

**(c) 2026 Muhammad Arkhamullah R.A - Laporan Praktikum Pemrograman Web 2**  
**Program Studi Teknik Informatika - Universitas Pelita Bangsa**
