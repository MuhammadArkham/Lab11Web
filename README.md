# Lab11Web - Pemrograman Web 2 (CI4 REST API)

Repository ini memuat hasil praktikum **Modul 7, 8, dan 10** mengenai implementasi REST API, Paging, Filtering, CORS, dan Endpoint Dasar menggunakan Framework CodeIgniter 4.

## Praktikum 7 & 8: Pembuatan REST API & Modifikasi CRUD
Pembuatan REST API menggunakan `ResourceController` untuk mengekspos data artikel. 

### Jawaban Pertanyaan dan Tugas (Modul 7 & 8)
**1. Selesaikan programnya sesuai Langkah-langkah yang ada (Modul 7).**
**Jawaban:** Program REST API dasar (GET artikel) telah berhasil diimplementasikan menggunakan `ResourceController` CodeIgniter 4. Data ditarik dari database MySQL dan disajikan dalam format JSON.

**2. Tambahkan fungsi untuk tambah dan ubah data (Modul 8).**
**Jawaban:** Fungsi `create()`, `update()`, dan `delete()` telah berhasil ditambahkan pada *Post Controller API*. Pengujian juga telah dilakukan via Postman untuk mengirim *raw JSON* untuk mengubah atau menambah data langsung ke database.


### Screenshot Hasil Kerja
> **Ambil gambar screenshot jalannya program di web browser dan taruh di sini**
> ![Screenshot](#)


---

## Praktikum 10: Paging, Filtering, CORS & Pemanfaatan REST API
Implementasi lanjutan dari REST API dengan penambahan filter pencarian, limitasi data (paging), dan dukungan *Cross-Origin Resource Sharing* (CORS) agar API bisa dikonsumsi oleh aplikasi _Frontend_ yang berbeda port/domain (seperti VueJS).

### Jawaban Pertanyaan dan Tugas (Modul 10)
**1. Selesaikan programnya sesuai Langkah-langkah yang ada. Anda boleh melakukan improvisasi.**
**Jawaban:** Langkah-langkah pembuatan API *Paging* dan *Filtering* sukses dikerjakan. Modifikasi `Filters.php` untuk merespons CORS Options juga telah dilakukan sehingga API bisa ditebas (*fetch*) dari VueJS tanpa *Blocked by CORS Policy*.


### Screenshot Hasil Kerja
> **Ambil gambar screenshot jalannya program di web browser dan taruh di sini**
> ![Screenshot](#)
