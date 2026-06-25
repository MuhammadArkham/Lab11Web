# Laporan Praktikum Pemrograman Web - Lab11Web

![PHP](https://img.shields.io/badge/PHP-8.1-%23777BB4?style=flat&logo=php)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-%23EF4223?style=flat&logo=codeigniter)
![MySQL](https://img.shields.io/badge/MySQL-8.0-%234479A1?style=flat&logo=mysql)
![jQuery](https://img.shields.io/badge/jQuery-AJAX-%230769AD?style=flat&logo=jquery)
![License](https://img.shields.io/badge/License-MIT-%23-yellow?style=flat)
![Repo Size](https://img.shields.io/github/repo-size/MuhammadArkham/Lab11Web?style=flat)
![Last Commit](https://img.shields.io/github/last-commit/MuhammadArkham/Lab11Web?style=flat)

---

**Mata Kuliah:** Pemrograman Web 2
**Nama:** Muhammad Arkhamullah R.A
**NIM:** 312410545
**Kelas:** I241E

---

Repositori ini memuat kelanjutan pengerjaan praktikum pada **Modul 7, 8, dan 10** dengan Framework **CodeIgniter 4**. Fokus pada pengelolaan Media (Upload), modifikasi data asinkron (AJAX), dan pembentukan **REST API Backend**.

---

## Daftar Perbaikan Bug

Sejumlah perbaikan bug telah dilakukan untuk memastikan aplikasi berjalan dengan benar:

| No | Bug | Deskripsi | Perbaikan |
|----|-----|-----------|-----------|
| 1 | Nama file upload tidak unik | File gambar yang diupload dengan nama sama akan saling menimpa karena menggunakan `getName()` | Diganti dengan `getRandomName()` agar setiap file mendapat nama unik hasil generate otomatis |
| 2 | Artikel draft tampil di halaman publik | Query pada controller publik tidak memfilter status artikel, sehingga artikel dengan status draft (0) tetap muncul | Ditambahkan klausa `WHERE status = 1` pada query artikel publik |
| 3 | Namespace salah pada ApiAuthFilter | File `app/Filters/ApiAuthFilter.php` menggunakan namespace `CodeIgniter\Http` yang salah untuk `RequestInterface` dan `ResponseInterface` | Diperbaiki menjadi `CodeIgniter\HTTP` (sesuai vendor CI4) |
| 4 | Timezone tidak sesuai wilayah | Aplikasi menggunakan timezone UTC (`appTimezone = 'UTC'`) sehingga timestamp artikel berbeda dengan waktu lokal | Diubah menjadi `'Asia/Jakarta'` agar timestamp sesuai WIB |
| 5 | Timestamp otomatis tidak aktif | Model `ArtikelModel`, `KategoriModel`, dan `UserModel` tidak mengaktifkan fitur `useTimestamps` sehingga kolom `created_at` / `updated_at` tidak terisi otomatis | Ditambahkan properti `protected $useTimestamps = true;` pada ketiga model |
| 6 | Route OPTIONS tidak terdaftar | Request HTTP method OPTIONS (preflight CORS) tidak memiliki handler sehingga request dari domain lain gagal | Telah ditambahkan route khusus untuk method OPTIONS dan konfigurasi `router.php` sudah ada |

---

## Daftar Isi

1. [Praktikum 7: Relasi Tabel & Upload File Gambar](#praktikum-7-relasi-tabel--upload-file-gambar)
2. [Praktikum 8: Modifikasi Data via AJAX](#praktikum-8-modifikasi-data-via-ajax)
3. [Praktikum 10: Pembuatan REST API Backend](#praktikum-10-pembuatan-rest-api-backend)

---

## Praktikum 7: Relasi Tabel & Upload File Gambar

### Tujuan Praktikum

Memahami cara mengolah form input bertipe `file` serta memindahkan objek media (File) pada server menggunakan PHP.

### Langkah-langkah Praktikum

Memperbaiki sistem Form Tambah dan Form Edit artikel dengan kemampuan menerima file foto.

1. **Menambahkan Multi-part**: Menambahkan atribut `enctype="multipart/form-data"` pada form HTML agar peramban merestui pengiriman Binary File.
2. **Injeksi Model**: Modifikasi Model `ArtikelModel` agar dapat membaca lokasi penyisipan data.
3. **Proses Upload (Backend)**: Menginstruksikan CI4 untuk memeriksa file yang di-post. File divalidasi dan diunggah secara aman, kemudian ditransfer menuju direktori public `/public/gambar/`. Nama file unik kemudian disimpan ke database.

### Pertanyaan dan Tugas

> **Pertanyaan:** Selesaikan programnya (Upload Gambar) sesuai Langkah-langkah yang ada. Anda boleh melakukan improvisasi.
>
> **Jawaban:** Integrasi Modul Tambah dan Modul Ubah artikel kini berhasil memproses unggahan file gambar dari pengguna lokal. Gambar juga langsung dirender saat tabel ditampilkan.

### Screenshot Hasil Kerja

| No | Tampilan | Deskripsi | Screenshot |
|----|----------|-----------|------------|
| 1 | Halaman Artikel Publik | Tampilan daftar artikel dengan kategori filter dan gambar terupload yang sudah difilter hanya status=1 | ![Artikel Publik](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080151.png?raw=true) |
| 2 | Halaman Admin Artikel | Tampilan CRUD artikel admin dengan pagination, search, dan kategori filter | ![Admin Artikel](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080219.png?raw=true) |
| 3 | Form Tambah Artikel | Form tambah artikel dengan dropdown kategori dan input upload gambar | ![Form Tambah](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080151.png?raw=true) |
| 4 | Form Edit Artikel | Form edit artikel dengan dropdown kategori yang sudah terseleksi dan gambar yang sudah ada | ![Form Edit](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080219.png?raw=true) |
| 5 | Relasi Database | Struktur tabel artikel dengan foreign key id_kategori yang terhubung ke tabel kategori | ![Relasi DB](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/relasi_db.png?raw=true) |

---

## Praktikum 8: Modifikasi Data via AJAX

### Tujuan Praktikum

Mempelajari interaksi lanjutan dari Form Create dan Update menggunakan mekanisme asinkron (jQuery AJAX).

### Langkah-langkah Praktikum

Memindahkan logika penambahan dan pengubahan artikel tanpa proses refresh layar.

1. **Pencegatan Submit Data**: Menggunakan Javascript `event.preventDefault()` untuk memblokir aksi Form Submit dasar.
2. **Pembungkusan FormData**: Menggunakan fungsi serialize dan membungkusnya sebagai Payload JSON.
3. **Pengiriman ke Backend**: Membuka koneksi `$.ajax` dengan tipe POST/PUT menuju rute `Artikel.php`, menanti pesan keberhasilan, dan jika sukses, maka tabel segera di-render ulang (fetchData) tanpa pergerakan halaman sama sekali.

### Pertanyaan dan Tugas

> **Pertanyaan:** Selesaikan programnya sesuai Langkah-langkah yang ada. Tambahkan fungsi untuk tambah dan ubah data. Anda boleh melakukan improvisasi.
>
> **Jawaban:** Aksi Tambah dan Ubah data berhasil diintegrasikan melalui permintaan POST menggunakan teknik Asynchronous JavaScript and XML secara bersih, meningkatkan interaksi layaknya antarmuka aplikasi modern.

### Screenshot Hasil Kerja

| No | Tampilan | Deskripsi | Screenshot |
|----|----------|-----------|------------|
| 1 | Halaman AJAX | Tampilan tabel artikel AJAX dengan data yang dimuat secara asinkron dan form CRUD tanpa reload halaman | ![AJAX Table](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-09%20104557.png?raw=true) |

---

## Praktikum 10: Pembuatan REST API Backend

### Tujuan Praktikum

Membangun web server spesialis penyedia Data (API), memahami konsep standar RESTful, dan menangani kebijakan CORS untuk diakses dari platform eksternal.

### Langkah-langkah Praktikum

1. **Resource Controller**: Membangun Controller baru (`Post.php`) yang diturunkan bukan dari `BaseController`, melainkan dari bawaan `ResourceController` milik CI4.
2. **Definisi Endpoint**: Mengubah `Routes.php` menggunakan `$routes->resource('post');` yang otomatis membuka pintu REST untuk GET, POST, PUT, dan DELETE.
3. **Penerapan Format JSON**: Menggunakan trait `ResponseTrait` di dalam Controller agar setiap nilai balikan (return) yang diberikan selalu bertipe `application/json`.
4. **Pencegahan Error CORS**: Menginjeksi filter Cross-Origin Resource Sharing di dalam konfigurasi `app/Config/Filters.php` agar Domain Frontend di masa mendatang (seperti `localhost:8080` dari VueJS) dapat leluasa menarik resource dari `localhost:80` (XAMPP).

### Pertanyaan dan Tugas

> **Pertanyaan:** Selesaikan programnya sesuai Langkah-langkah yang ada. Anda boleh melakukan improvisasi.
>
> **Jawaban:** Endpoint API berhasil berjalan sempurna. Konfigurasi perizinan `Access-Control-Allow-Origin: *` pada Filters juga dihidupkan untuk membuka akses dari Client/Axios.

### Screenshot Hasil Kerja

| No | Tampilan | Deskripsi | Screenshot |
|----|----------|-----------|------------|
| 1 | API GET /post | Response JSON daftar semua artikel dari endpoint REST API | ![API GET All](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080019.png?raw=true) |
| 2 | API GET /post/{id} | Response JSON detail satu artikel berdasarkan ID | ![API GET Single](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/api_get_single.png?raw=true) |
| 3 | API POST /post | Membuat artikel baru melalui REST API (test via Postman/browser) | ![API POST](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/api_post.png?raw=true) |

---

## Template Screenshot

Berikut adalah daftar lengkap screenshot yang harus diambil sebagai dokumentasi aplikasi:

| No | Halaman / Endpoint | Deskripsi | Komponen yang Harus Terlihat |
|----|---------------------|-----------|------------------------------|
| 1 | **Halaman Artikel Publik** (`/artikel`) | Tampilan daftar artikel yang dapat diakses pengunjung | - Daftar artikel dengan judul, gambar, dan deskripsi<br>- Dropdown filter kategori<br>- Hanya menampilkan artikel dengan status=1 (published)<br>- Gambar artikel tampil dengan benar |
| 2 | **Halaman Admin Artikel** (`/admin/artikel`) | Tampilan manajemen artikel dari sisi admin | - Tabel artikel dengan kolom ID, Judul, Kategori, Status, Aksi<br>- Fitur pagination<br>- Search box pencarian artikel<br>- Filter kategori |
| 3 | **Form Tambah Artikel** (`/admin/artikel/create`) | Form untuk menambahkan artikel baru | - Input judul, isi artikel<br>- Dropdown kategori yang terisi data dari database<br>- Upload file gambar dengan tombol Browse<br- - Tombol Submit |
| 4 | **Form Edit Artikel** (`/admin/artikel/edit/{id}`) | Form untuk mengubah artikel yang sudah ada | - Data artikel sebelumnya terisi di form<br>- Dropdown kategori menampilkan kategori yang terseleksi<br>- Gambar yang sudah ada ditampilkan (preview)<br>- Tombol Update |
| 5 | **Halaman AJAX** (`/ajax`) | Tabel artikel yang dimuat secara asinkron | - Tabel artikel tanpa reload halaman<br>- Form tambah/ubah yang muncul di modal atau inline<br>- Notifikasi sukses/gagal (flash message atau alert)<br>- Data berubah tanpa refresh browser |
| 6 | **API GET /post** | Response JSON daftar semua artikel | - Tampilan JSON di browser atau Postman<br>- Array of objects dengan field: id, judul, isi, kategori, gambar, created_at, updated_at<br>- Status code 200 |
| 7 | **API GET /post/{id}** | Response JSON detail satu artikel | - Object JSON tunggal dengan field lengkap<br>- Status code 200 |
| 8 | **API POST /post** | Membuat artikel baru via REST | - Request body JSON (judul, isi, id_kategori)<br>- Response JSON berisi data yang baru dibuat<br>- Status code 201 |
| 9 | **Relasi Database (phpMyAdmin)** | Struktur tabel dan relasi foreign key | - Tabel `artikel` dengan kolom `id_kategori` sebagai foreign key<br>- Tabel `kategori` dengan kolom `id` sebagai primary key<br>- Relasi terlihat di tab Relation View |

### Panduan Pengambilan Screenshot

1. Gunakan resolusi layar minimal **1366x768** untuk konsistensi
2. Simpan file screenshot di folder `Secrenshoot/`
3. Format penamaan: `SS_<modul>_<deskripsi>.png` (contoh: `SS_7_artikel_publik.png`)
4. Untuk API, gunakan **Postman** atau browser dengan JSON formatter extension
5. Untuk relasi database, gunakan tab **Relation View** phpMyAdmin

---

## Struktur Folder

```
Lab11Web/
├── ci4/                                # CodeIgniter 4 Framework
│   ├── app/
│   │   ├── Config/                     # Routes, Filters (CORS), Database
│   │   ├── Controllers/                # Artikel, Post (ResourceController)
│   │   ├── Models/                     # ArtikelModel
│   │   ├── Views/                      # Template, komponen AJAX
│   │   └── Filters/                    # ApiAuthFilter, CorsFilter
│   ├── public/                         # Entry point, uploads/gambar/
│   └── ...
├── Secrenshoot/                        # Dokumentasi screenshot praktikum
└── README.md
```

---

(c) 2026 Muhammad Arkhamullah R.A - Laporan Praktikum Pemrograman Web
