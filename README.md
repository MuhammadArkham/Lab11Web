
# Praktikum 11

**Nama:** Muhammad Arkhamullah Rifai Asshidiq

**NIM:** 312410545

**Kelas:** TI 24 A5

## Tujuan Praktikum
1. Memahami konsep dasar Framework Modular
2. Memahami konsep dasar routing
3. Membuat Framework sederhana menggunakan PHP OOP



Repository ini dibuat untuk memenuhi tugas **Praktikum 11: Pemrograman Web 2** (PHP OOP Lanjutan).
Proyek ini mengimplementasikan konsep **Modularisasi**, **Routing sederhana**, dan **MVC (Model-View-Controller)** menggunakan PHP Native tanpa framework eksternal.

## 📋 Deskripsi Proyek
Aplikasi ini adalah sebuah portal berita/artikel sederhana yang dibangun dengan struktur modular. Setiap fitur dibagi menjadi modul-modul terpisah (seperti `home`, `artikel`) untuk memudahkan pengembangan dan maintenance. Tampilan antarmuka didesain modern menggunakan CSS custom.

### Fitur Utama:
* **Routing System:** Menggunakan `.htaccess` untuk URL yang bersih (*Pretty URL*).
* **Modular Structure:** Pemisahan logic antara modul, library, dan template.
* **Database Wrapper:** Class `Database.php` untuk mempermudah koneksi dan query MySQL.
* **Form Builder:** Class `Form.php` untuk membuat elemen form HTML secara dinamis.
* **CRUD Artikel:** Fitur lengkap Tambah, Baca, Ubah, dan Hapus data artikel.
* **Modern UI:** Desain antarmuka responsif dan bersih.

## 📂 Struktur Folder
Berikut adalah struktur direktori dari proyek ini:

```text
lab11_php_oop/
├── .htaccess           # Konfigurasi Rewrite URL (Routing)
├── config.php          # Konfigurasi Database
├── index.php           # Gerbang Utama (Router)
├── style.css           # Styling CSS Modern
├── README.md           # Dokumentasi Proyek
├── class/              # Library Class
│   ├── Database.php
│   └── Form.php
├── module/             # Modul Fitur
│   └── artikel/
│       ├── index.php   # Menampilkan daftar artikel
│       ├── tambah.php  # Form tambah artikel
│       ├── ubah.php    # Form ubah artikel
│       └── hapus.php   # Logic hapus artikel
└── template/           # Layout Website
    ├── header.php
    ├── footer.php
    └── sidebar.php

```

## 🚀 Cara Instalasi & Menjalankan



1. **Persiapan Database**
Buat database baru di phpMyAdmin ( `latihan1`) dan jalankan query berikut:
```sql
CREATE TABLE artikel (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    isi TEXT,
    tanggal DATE DEFAULT CURRENT_TIMESTAMP
);

```


2. **Konfigurasi Project**
Buka file `config.php` dan sesuaikan dengan setting database lokal kamu:
```php
$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',      // Kosongkan jika default XAMPP
    'db_name' => 'latihan1'
];

```


3. **Penempatan Folder**
Pastikan folder project bernama `lab11_php_oop` dan simpan di dalam direktori `htdocs` (jika menggunakan XAMPP).
5. **Akses Website**
Buka browser dan akses:
`http://localhost/lab11_php_oop/index.php`

## 📸 Screenshots

Berikut adalah tampilan hasil implementasi proyek:

**1. Halaman Daftar Artikel (Tampilan Modern)**
![foto](https://github.com/MuhammadArkham/Lab11Web/blob/main/FOTO%20PROJECT/Screenshot%202025-12-23%20091427.png?raw=true)

**2. Halaman Tambah Artikel**
![foto](https://github.com/MuhammadArkham/Lab11Web/blob/main/FOTO%20PROJECT/Screenshot%202025-12-23%20091319.png?raw=true)

**3. Halaman Ubah Artikel**
![foto](https://github.com/MuhammadArkham/Lab11Web/blob/main/FOTO%20PROJECT/Screenshot%202025-12-23%20091451.png?raw=true)

**4. Hapus Artikel**
![foto](https://github.com/MuhammadArkham/Lab11Web/blob/main/FOTO%20PROJECT/Screenshot%202025-12-23%20091511.png?raw=true
)


```



```
# Laporan Praktikum 12: Autentikasi dan Session



##  Tujuan Praktikum
1.  Memahami konsep dasar **Autentikasi** dan **Session** pada aplikasi web.
2.  Mengimplementasikan fitur **Login** dan **Logout** untuk membatasi hak akses.
3.  Melindungi password pengguna menggunakan enkripsi (*password hashing*).

---

##  Langkah-Langkah Pengerjaan

### 1. Persiapan Database
Langkah pertama adalah membuat tabel `users` untuk menyimpan data administrator. Password disimpan dalam format *hash* (bukan teks biasa) demi keamanan.

**Query Pembuatan Tabel:**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100)
);

```

**Insert Data Admin:**
Password "admin123" dienkripsi menjadi hash:

```sql
INSERT INTO users (username, password, nama)
VALUES ('admin', '$2y$10$uWdZ2x.hQfGqGz/..q7wue.3/a/e/e/e/e/e/e/e/e/e/e', 'Administrator');

```

---

### 2. Konfigurasi Routing & Session (`index.php`)

Memodifikasi file `index.php` agar sistem mengecek status login pengguna sebelum memberikan akses ke halaman modul (seperti artikel).

**Perubahan Logika:**

1. Menambahkan `session_start()` di baris paling atas.
2. Mengecek apakah modul yang diakses termasuk halaman publik (`home` atau `login`).
3. Jika bukan halaman publik dan user belum login, sistem akan me-*redirect* ke halaman login.

**Screenshot Kode Routing:**
![foto](https://github.com/MuhammadArkham/Lab11Web/blob/main/FOTO%20PROJECT/Screenshot%202025-12-24%20114055.png?raw=true)

---

### 3. Membuat Modul User (Login & Logout)

#### A. Halaman Login (`module/user/login.php`)

Membuat form login HTML dan script PHP untuk memverifikasi username dan password.

* Jika login berhasil: Session `is_login`, `username`, dan `nama` dibuat.
* Jika gagal: Muncul pesan error "Username atau password salah".

**Tampilan Halaman Login:**
![foto](https://github.com/MuhammadArkham/Lab11Web/blob/main/FOTO%20PROJECT/Screenshot%202025-12-24%20111436.png?raw=true)

#### B. Logout (`module/user/logout.php`)

Script sederhana untuk menghapus semua session (`session_destroy`) dan mengarahkan pengguna kembali ke halaman login.

---

### 4. Penyesuaian Navigasi (`sidebar.php`)

Menu navigasi dibuat dinamis berdasarkan status login user.

* **Belum Login:** Hanya menampilkan menu *Home* dan *Login*.
* **Sudah Login:** Menampilkan menu *Home*, *Artikel*, *Tambah Artikel*, *Profil*, dan *Logout*.

**Screenshot Tampilan Dashboard (Sudah Login):**
![foto](https://github.com/MuhammadArkham/Lab11Web/blob/main/FOTO%20PROJECT/Screenshot%202025-12-24%20113258.png?raw=true)

---

### 5. Tugas Praktikum: Fitur Profil User

Sesuai instruksi tugas, ditambahkan halaman **Profil** (`module/user/profile.php`) yang memiliki fitur:

1. Menampilkan data diri user yang sedang login (Username & Nama).
2. Form untuk mengubah password.
3. Validasi password lama sebelum mengubah ke password baru.
4. Enkripsi password baru menggunakan `password_hash()`.

**Tampilan Halaman Profil:**
![foto](https://github.com/MuhammadArkham/Lab11Web/blob/main/FOTO%20PROJECT/Screenshot%202025-12-24%20113759.png?raw=true)

**Hasil Uji Coba Ganti Password:**

1. Input password lama yang salah -> Muncul pesan error.
2. Input password lama benar -> Password berhasil diubah di database.

---

