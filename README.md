# 📚 Laporan Praktikum Pemrograman Web (Lab11Web)

Repositori ini memuat kelanjutan pengerjaan praktikum pada **Modul 7, 8, dan 10** dengan Framework CodeIgniter 4. Fokus pada pengelolaan Media *(Upload)* dan pembentukan REST API Backend.

---

# 📖 Praktikum 7: Relasi Tabel & Upload File Gambar

### 🎯 Tujuan Praktikum
Memahami cara mengolah form input bertipe `file` serta memindahkan objek media (_File_) pada server menggunakan PHP.

### 🛠️ Penjelasan dan Langkah-langkah Praktikum
Memperbaiki sistem Form Tambah dan Form Edit artikel dengan kemampuan menerima file foto.
1. **Menambahkan Multi-part**: Menambahkan atribut `enctype="multipart/form-data"` pada form HTML agar peramban merestui pengiriman *Binary File*.
2. **Injeksi Model**: Modifikasi model `ArtikelModel` agar dapat membaca lokasi penyisipan data.
3. **Proses Upload (Backend)**: Menginstruksikan CI4 untuk memeriksa file yang di-_post_. File divalidasi dan diunggah secara aman, kemudian ditransfer menuju direktori _public_ `/public/gambar/`. Nama file unik kemudian disimpan ke database.


### 💡 Pertanyaan dan Tugas
> **Pertanyaan:**  
> Selesaikan programnya (Upload Gambar) sesuai Langkah-langkah yang ada. Anda boleh melakukan improvisasi.
> 
> **Jawaban & Implementasi:**  
> Integrasi Modul Tambah dan Modul Ubah artikel kini sangat sukses memproses unggahan file gambar dari pengguna lokal. Gambar juga langsung dirender saat tabel ditampilkan.

### 📸 Screenshot Hasil Kerja
> **Silakan ganti tag `#` di bawah ini dengan URL gambar Anda**
> ![Hasil Praktikum](#)

---

# 📖 Praktikum 8: Modifikasi Data via AJAX

### 🎯 Tujuan Praktikum
Mempelajari interaksi lanjutan dari Form *Create* dan *Update* menggunakan mekanisme asinkron (_jQuery AJAX_).

### 🛠️ Penjelasan dan Langkah-langkah Praktikum
Memindahkan logika penambahan dan pengubahan artikel tanpa proses *refresh* layar.
1. **Pencegatan Submit Data**: Menggunakan Javascript `event.preventDefault()` untuk memblokir aksi Form Submit dasar.
2. **Pembungkusan FormData**: Menggunakan fungsi _serialize_ dan membungkusnya sebagai _Payload_ JSON.
3. **Pengiriman ke Backend**: Membuka koneksi `$.ajax` dengan tipe POST/PUT menuju rute `Artikel.php`, menanti pesan keberhasilan, dan jika sukses, maka tabel segera di-*render* ulang (fetchData) tanpa pergerakan halaman sama sekali.


### 💡 Pertanyaan dan Tugas
> **Pertanyaan:**  
> Selesaikan programnya sesuai Langkah-langkah yang ada. Tambahkan fungsi untuk tambah dan ubah data. Anda boleh melakukan improvisasi.
> 
> **Jawaban & Implementasi:**  
> Aksi *Tambah* dan *Ubah* data berhasil diintegrasikan melalui permintaan POST menggunakan teknik _Asynchronous JavaScript and XML_ secara bersih, meningkatkan interaksi layaknya antarmuka aplikasi modern.

### 📸 Screenshot Hasil Kerja
> **Silakan ganti tag `#` di bawah ini dengan URL gambar Anda**
> ![Hasil Praktikum](#)

---

# 📖 Praktikum 10: Pembuatan REST API Backend

### 🎯 Tujuan Praktikum
Membangun web server spesialis penyedia Data (`API`), memahami konsep standar RESTful, dan menangani kebijakan CORS untuk diakses dari platform eksternal.

### 🛠️ Penjelasan dan Langkah-langkah Praktikum
1. **Resource Controller**: Membangun Controller baru (`Post.php`) yang diturunkan bukan dari `BaseController`, melainkan dari bawaan `ResourceController` milik CI4.
2. **Definisi Endpoint**: Mengubah `Routes.php` menggunakan `$routes->resource('post');` yang otomatis membuka pintu REST untuk GET, POST, PUT, dan DELETE.
3. **Penerapan Format JSON**: Menggunakan trait `ResponseTrait` di dalam Controller agar setiap nilai balikan (_return_) yang diberikan selalu bertipe `application/json`.
4. **Pencegahan Error CORS**: Menginjeksi filter _Cross-Origin Resource Sharing_ di dalam konfigurasi `app/Config/Filters.php` agar Domain Frontend di masa mendatang (seperti `localhost:8080` dari VueJS) dapat leluasa menarik _resource_ dari `localhost:80` (XAMPP).


### 💡 Pertanyaan dan Tugas
> **Pertanyaan:**  
> Selesaikan programnya sesuai Langkah-langkah yang ada. Anda boleh melakukan improvisasi.
> 
> **Jawaban & Implementasi:**  
> Endpoint API berhasil berjalan sempurna. Konfigurasi perizinan `Access-Control-Allow-Origin: *` pada _Filters_ juga dihidupkan untuk membuka akses dari *Client/Axios*.

### 📸 Screenshot Hasil Kerja
> **Silakan ganti tag `#` di bawah ini dengan URL gambar Anda**
> ![Hasil Praktikum](#)

---

