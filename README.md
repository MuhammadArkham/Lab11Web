
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

1. **Clone Repository**
```bash
git clone [https://github.com/username-kamu/Lab11Web.git](https://github.com/username-kamu/Lab11Web.git)

```


2. **Persiapan Database**
Buat database baru di phpMyAdmin (misal: `latihan1`) dan jalankan query berikut:
```sql
CREATE TABLE artikel (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    isi TEXT,
    tanggal DATE DEFAULT CURRENT_TIMESTAMP
);

```


3. **Konfigurasi Project**
Buka file `config.php` dan sesuaikan dengan setting database lokal kamu:
```php
$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',      // Kosongkan jika default XAMPP
    'db_name' => 'latihan1'
];

```


4. **Penempatan Folder**
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
