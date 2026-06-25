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


### Hasil Uji Coba REST API

Berikut hasil pengujian setiap endpoint REST API menggunakan curl (Command Line):

| No | Method | Endpoint | Token | Status Code | Hasil |
|----|--------|----------|-------|-------------|-------|
| 1 | GET | `/post` | Tidak | 200 | JSON array berisi semua artikel dari database (id, judul, isi, slug, gambar, status, id_kategori, created_at, updated_at) |
| 2 | GET | `/post/{id}` | Tidak | 200 | JSON object detail artikel berdasarkan ID (contoh: `/post/5` menampilkan artikel "Jaringan Komputer") |
| 3 | POST | `/post` | Wajib | 201 | Artikel baru berhasil dibuat, response `{"status":201,"messages":{"success":"Data artikel berhasil ditambahkan."}}` |
| 4 | PUT | `/post/{id}` | Wajib | 200 | Data artikel berhasil diubah, response `{"status":200,"messages":{"success":"Data artikel berhasil diubah."}}` |
| 5 | DELETE | `/post/{id}` | Wajib | 200 | Data artikel berhasil dihapus, response `{"status":200,"messages":{"success":"Data artikel berhasil dihapus."}}` |

### Screenshot Hasil Uji Coba API (Postman)

Ikuti langkah-langkah berikut untuk mengambil screenshot setiap endpoint menggunakan Postman:

---

#### Screenshot 1: GET /post (Menampilkan Semua Data)

**Langkah-langkah:**

1. Buka **Postman**
2. Klik **Create New** → **HTTP Request**
3. Pilih method **GET**
4. Masukkan URL: `http://localhost:8081/post`
5. Klik tombol **Send**
6. **Ambil screenshot** yang menampilkan:
   - Method GET pada dropdown
   - URL `http://localhost:8081/post`
   - Bagian Body response berisi JSON array semua artikel
   - Status code 200 OK

---

#### Screenshot 2: GET /post/{id} (Menampilkan Data Spesifik)

**Langkah-langkah:**

1. Buka tab baru di Postman
2. Pilih method **GET**
3. Masukkan URL: `http://localhost:8081/post/5`
4. Klik tombol **Send**
5. **Ambil screenshot** yang menampilkan:
   - Method GET pada dropdown
   - URL `http://localhost:8081/post/5`
   - Bagian Body response berisi JSON object detail artikel dengan ID 5
   - Status code 200 OK

---

#### Screenshot 3: POST /post (Menambahkan Data Baru)

**Langkah-langkah:**

1. Buka tab baru di Postman
2. Pilih method **POST**
3. Masukkan URL: `http://localhost:8081/post`
4. Pilih tab **Headers**
5. Tambahkan header: `Authorization: Bearer VE9LRU...Wlu`
6. Pilih tab **Body**
7. Pilih **x-www-form-urlencoded**
8. Isi kolom KEY dan VALUE berikut:
   - `judul` → `Artikel Baru dari Postman`
   - `isi` → `Ini adalah artikel yang dibuat menggunakan method POST melalui Postman`
9. Klik tombol **Send**
10. **Ambil screenshot** yang menampilkan:
    - Method POST pada dropdown
    - URL `http://localhost:8081/post`
    - Tab Body dengan key-value judul dan isi
    - Response JSON berisi status 201
    - Status code 201 Created

---

#### Screenshot 4: PUT /post/{id} (Mengubah Data)

**Langkah-langkah:**

1. Buka tab baru di Postman
2. Pilih method **PUT**
3. Masukkan URL: `http://localhost:8081/post/8` (gunakan ID artikel yang sudah ada)
4. Pilih tab **Headers**
5. Tambahkan header: `Authorization: Bearer VE9LRU...Wlu`
6. Pilih tab **Body**
7. Pilih **x-www-form-urlencoded**
8. Isi kolom KEY dan VALUE:
   - `judul` → `Judul Artikel yang Diupdate`
   - `isi` → `Konten artikel setelah diubah menggunakan method PUT`
9. Klik tombol **Send**
10. **Ambil screenshot** yang menampilkan:
    - Method PUT pada dropdown
    - URL `http://localhost:8081/post/8`
    - Tab Body dengan data yang diubah
    - Response JSON berisi status 200
    - Status code 200 OK

---

#### Screenshot 5: DELETE /post/{id} (Menghapus Data)

**Langkah-langkah:**

1. Buka tab baru di Postman
2. Pilih method **DELETE**
3. Masukkan URL: `http://localhost:8081/post/9` (atau ID artikel yang ingin dihapus)
4. Pilih tab **Headers**
5. Tambahkan header: `Authorization: Bearer VE9LRU...Wlu`
6. Klik tombol **Send**
7. **Ambil screenshot** yang menampilkan:
    - Method DELETE pada dropdown
    - URL `http://localhost:8081/post/9`
    - Response JSON berisi status 200
    - Status code 200 OK

---

#### Screenshot 6: Login via API (Mendapatkan Token)

**Langkah-langkah:**

1. Buka tab baru di Postman
2. Pilih method **POST**
3. Masukkan URL: `http://localhost:8081/api/login`
4. Pilih tab **Body**
5. Pilih **raw** dan pilih format **JSON**
6. Isi body:
   ```json
   {
       "username": "admin@email.com",
       "password": "admin123"
   }
   ```
7. Klik tombol **Send**
8. **Ambil screenshot** yang menampilkan:
    - Method POST pada dropdown
    - URL `http://localhost:8081/api/login`
    - Tab Body dengan JSON berisi username dan password
    - Response JSON berisi token
    - Status code 200 OK

---

### Hasil Uji Coba (Via Command Line)

<details>
<summary>Klik untuk melihat output real dari setiap endpoint</summary>

**GET /post**
```json
{
    "artikel": [
        {"id":"8","judul":"Test Upload Gambar Via Admin","slug":"test-upload-gambar-via-admin","status":"0"},
        {"id":"7","judul":"Peran Artificial Intelligence dalam Kehidupan Modern","status":"0"},
        {"id":"6","judul":"Pemanfaatan Artificial Intelligence dalam Dunia Pendidikan","status":"0"},
        {"id":"5","judul":"Jaringan Komputer, Pengertian, Jenis, Transmisi, dan Topologi","status":"0"},
        {"id":"4","judul":"Mengenal Kecerdasan Buatan (AI) di Era Modern","status":"1"}
    ]
}
```

**GET /post/5**
```json
{
    "id":"5",
    "judul":"Jaringan Komputer, Pengertian, Jenis, Transmisi, dan Topologi",
    "slug":"jaringan-komputer-pengertian-jenis-transmisi-dan-topologi",
    "status":"0",
    "id_kategori":"3"
}
```

**POST /post** (dengan token)
```json
{"status":201,"messages":{"success":"Data artikel berhasil ditambahkan."}}
```

**PUT /post/8** (dengan token)
```json
{"status":200,"messages":{"success":"Data artikel berhasil diubah."}}
```

**DELETE /post/9** (dengan token)
```json
{"status":200,"messages":{"success":"Data artikel berhasil dihapus."}}
```
</details>

---
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
| 6 | **Relasi Database (phpMyAdmin)** | Struktur tabel dan relasi foreign key | - Tabel `artikel` dengan kolom `id_kategori` sebagai foreign key<br>- Tabel `kategori` dengan kolom `id` sebagai primary key<br>- Relasi terlihat di tab Relation View |
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
