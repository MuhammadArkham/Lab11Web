# 📖 Praktikum 7, 8, dan 10: Pembuatan REST API Dasar & CORS

### 🎯 Penjelasan Praktikum
Repository ini fokus pada implementasi dan eksposur layanan Data (Web Service) menggunakan arsitektur RESTful API melalui fitur `ResourceController` bawaan CodeIgniter 4. Kita juga mengkonfigurasi `CORS` (Cross-Origin Resource Sharing) agar API ini dapat diakses oleh _Frontend_ (seperti VueJS) yang berjalan di server atau port berbeda.

### 🛠️ Langkah-langkah Utama
- Pembuatan `Post` controller yang mewarisi `ResourceController`.
- Menambahkan rute API di `Routes.php` menggunakan `$routes->resource('post');`.
- Menyiapkan metode bawaan (GET, POST, PUT, DELETE) mengembalikan format `JSON`.
- Memodifikasi `app/Config/Filters.php` untuk merespons format OPTIONS dari Preflight Request CORS.



### 💡 Pertanyaan dan Tugas
> **Pertanyaan:**  
> Selesaikan programnya sesuai Langkah-langkah yang ada (REST API Dasar Modul 7).
> 
> **Jawaban & Implementasi:**  
> Endpoint API `GET /post` telah aktif dan berhasil menyajikan seluruh artikel dalam _array_ berformat JSON.


### 💡 Pertanyaan dan Tugas
> **Pertanyaan:**  
> Selesaikan programnya sesuai Langkah-langkah yang ada. Tambahkan fungsi untuk tambah dan ubah data. Anda boleh melakukan improvisasi (Modul 8).
> 
> **Jawaban & Implementasi:**  
> Fungsi `create()` (POST), `update()` (PUT), dan `delete()` (DELETE) telah lengkap ditambahkan pada API controller. Tes telah dilakukan menggunakan _Postman_, dan rekaman tersimpan sempurna di _database_.


### 💡 Pertanyaan dan Tugas
> **Pertanyaan:**  
> Selesaikan programnya sesuai Langkah-langkah yang ada (API Pagination, Filter, CORS - Modul 10). Anda boleh melakukan improvisasi.
> 
> **Jawaban & Implementasi:**  
> API telah diperbarui agar mendukung _query parameters_ limitasi halaman. _Headers_ `Access-Control-Allow-Origin` berhasil dimasukkan secara global pada _Filters_ sehingga Axios dari repositori VueJS tidak di-_block_ oleh browser.

### 📸 Screenshot Hasil Kerja
> **Silakan ganti tag `#` di bawah ini dengan URL gambar Anda**
> ![Hasil Praktikum](#)

---
