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

| Tampilan | Screenshot |
|----------|------------|
| Form Tambah dengan Upload | ![Form Tambah](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080151.png?raw=true) |
| Form Edit dengan Upload | ![Form Edit](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080219.png?raw=true) |

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

| Tampilan | Screenshot |
|----------|------------|
| AJAX Table Management | ![AJAX](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-09%20104557.png?raw=true) |

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

| Tampilan | Screenshot |
|----------|------------|
| REST API Response (JSON) | ![API Response](https://github.com/MuhammadArkham/Lab11Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080019.png?raw=true) |

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
│   │   └── Filters/                    # CorsFilter
│   ├── public/                         # Entry point, uploads/gambar/
│   └── ...
├── Secrenshoot/                        # Dokumentasi screenshot praktikum
└── README.md
```

---

(c) 2026 Muhammad Arkhamullah R.A - Laporan Praktikum Pemrograman Web
