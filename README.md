# Praktikum 7, 8, dan 10: Pembuatan REST API Dasar & CORS

## Penjelasan Praktikum
Repository ini fokus pada implementasi dan eksposur layanan Data (Web Service) menggunakan arsitektur RESTful API melalui fitur `ResourceController` bawaan CodeIgniter 4. Kita juga mengkonfigurasi `CORS` (Cross-Origin Resource Sharing) agar API ini dapat diakses oleh _Frontend_ (seperti VueJS) yang berjalan di server atau port berbeda.

## Langkah-langkah Utama
- Pembuatan `Post` controller yang mewarisi `ResourceController`.
- Menambahkan rute API di `Routes.php` menggunakan `$routes->resource('post');`.
- Menyiapkan metode bawaan (GET, POST, PUT, DELETE) mengembalikan format `JSON`.
- Memodifikasi `app/Config/Filters.php` untuk merespons format OPTIONS dari Preflight Request CORS.

## Pertanyaan dan Tugas (Praktikum 7)
> **Pertanyaan:** Selesaikan programnya sesuai Langkah-langkah yang ada (REST API Dasar).
> **Jawaban:** Endpoint API `GET /post` telah aktif dan berhasil menyajikan seluruh artikel dalam _array_ berformat JSON.

## Pertanyaan dan Tugas (Praktikum 8)
> **Pertanyaan:** Selesaikan programnya sesuai Langkah-langkah yang ada. Tambahkan fungsi untuk tambah dan ubah data. Anda boleh melakukan improvisasi.
> **Jawaban:** Fungsi `create()` (POST), `update()` (PUT), dan `delete()` (DELETE) telah lengkap ditambahkan pada API controller. Tes telah dilakukan menggunakan perangkat pihak ketiga seperti _Postman_ dan _cURL_ dengan mengirimkan _body raw JSON_ ke API, dan rekaman tersimpan sempurna di _database_.

## Pertanyaan dan Tugas (Praktikum 10)
> **Pertanyaan:** Selesaikan programnya sesuai Langkah-langkah yang ada (API Pagination, Filter, CORS). Anda boleh melakukan improvisasi.
> **Jawaban:** API telah diperbarui agar mendukung _query parameters_ limitasi halaman. Selain itu, _Headers_ `Access-Control-Allow-Origin` berhasil dimasukkan secara global pada _Filters_ sehingga Axios dari repositori VueJS nantinya tidak di-_block_ oleh pelindung peramban web (*browser*).

### Screenshot Hasil Kerja
> **Ambil gambar screenshot jalannya program di web browser dan taruh di sini**
> ![Screenshot](#)

