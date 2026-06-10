# Praktikum 1: PHP Framework (CodeIgniter)

## Tujuan
1. Memahami konsep dasar Framework.
2. Memahami konsep dasar MVC.
3. Membuat program sederhana menggunakan Framework CodeIgniter 4.

---

## Langkah-langkah Praktikum

### 1. Persiapan - Mengaktifkan Ekstensi PHP
Sebelum menggunakan CodeIgniter, aktifkan ekstensi PHP berikut di `php.ini`:
- `extension=intl`
- `extension=mbstring`
- `extension=mysqli`

### 2. Instalasi CodeIgniter 4
- Download CodeIgniter dari https://codeigniter.com/download
- Ekstrak ke `htdocs/lab11_php_ci/`
- Rename folder menjadi `ci4`
- Jalankan dengan perintah:
```
cd C:\xampp\htdocs\lab11_php_ci\ci4
php spark serve
```
- Buka browser: http://localhost:8080

### 3. Mengaktifkan Mode Debugging
- Rename file `env` menjadi `.env`
- Ubah nilai `CI_ENVIRONMENT` menjadi `development`

### 4. Membuat Route Baru
Tambahkan route di `app/Config/Routes.php`:
```php
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
```

### 5. Membuat Controller Page
Buat file `app/Controllers/Page.php`:
```php
<?php
namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman about.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Halaman Kontak',
            'content' => 'Ini adalah halaman kontak.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title' => 'Halaman FAQ',
            'content' => 'Ini adalah halaman FAQ.'
        ]);
    }
}
```

### 6. Membuat Layout dengan CSS
- Buat file `public/style.css`
- Buat folder `app/Views/template/`
- Buat `header.php` dan `footer.php` sebagai template layout

### 7. Membuat View About
Buat file `app/Views/about.php`:
```php
<?= $this->include('template/header'); ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->include('template/footer'); ?>
```

---

## Hasil Praktikum

### Tampilan Halaman About
![Halaman About](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20074752.png?raw=true)

### Tampilan Halaman Kontak
![Halaman Kontak](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20074838.png?raw=true)

---

## Kesimpulan
CodeIgniter 4 menggunakan konsep MVC yang memisahkan:
- **Model** ΓÇö pengelolaan data
- **View** ΓÇö tampilan halaman
- **Controller** ΓÇö lBerikut README untuk **Praktikum 2**:

```
```
# Praktikum 2: Framework Lanjutan (CRUD)

## Tujuan
1. Memahami konsep dasar Model.
2. Memahami konsep dasar CRUD.
3. Membuat program sederhana menggunakan Framework CodeIgniter 4.

---

## Langkah-langkah Praktikum

### 1. Membuat Database
Buka MySQL CLI dan jalankan perintah berikut:
```sql
CREATE DATABASE lab_ci4;
USE lab_ci4;
CREATE TABLE artikel (
    id INT(11) auto_increment,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    PRIMARY KEY(id)
);
```

### 2. Konfigurasi Database di .env
```
database.default.hostname = localhost
database.default.database = lab_ci4
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### 3. Membuat Model
Buat file `app/Models/ArtikelModel.php`:
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar'];
}
```

### 4. Membuat Controller Artikel
Buat file `app/Controllers/Artikel.php` berisi method:
- `index()` ΓÇö menampilkan daftar artikel
- `view($slug)` ΓÇö menampilkan detail artikel
- `admin_index()` ΓÇö halaman admin
- `add()` ΓÇö tambah artikel
- `edit($id)` ΓÇö ubah artikel
- `delete($id)` ΓÇö hapus artikel

### 5. Membuat View Artikel
Buat folder `app/Views/artikel/` berisi:
- `index.php` ΓÇö daftar artikel
- `detail.php` ΓÇö detail artikel
- `admin_index.php` ΓÇö tabel admin
- `form_add.php` ΓÇö form tambah
- `form_edit.php` ΓÇö form edit

### 6. Menambah Data Awal
```sql
INSERT INTO artikel (judul, isi, slug) VALUES
('Artikel pertama', 'Lorem Ipsum adalah contoh teks...', 'artikel-pertama'),
('Artikel kedua', 'Tidak seperti anggapan banyak orang...', 'artikel-kedua');
```

---

## Hasil Praktikum

### Tampilan Daftar Artikel
![Daftar Artikel](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20075543.png?raw=true)

### Tampilan Detail Artikel
![Detail Artikel](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20075543.png?raw=true)

### Tampilan Admin
![Admin](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080019.png?raw=true)

### Tampilan Form Tambah Artikel
![Form Tambah](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080151.png?raw=true)

### Tampilan Form Edit Artikel
![Form Edit](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080219.png?raw=true)

---

## Kesimpulan
Pada praktikum ini telah berhasil membuat aplikasi CRUD sederhana menggunakan CodeIgniter 4 dengan fitur:
- Menampilkan daftar artikel
- Menampilkan detail artikel
- Menambah artikel baru
- Mengubah artikel
- Menghapus artikel
```
---


```

# Praktikum 3: View Layout dan View Cell

## Tujuan
1. Memahami konsep View Layout di CodeIgniter 4.
2. Menggunakan View Layout untuk membuat template tampilan.
3. Memahami dan mengimplementasikan View Cell dalam CodeIgniter 4.
4. Menggunakan View Cell untuk memanggil komponen UI secara modular.

---

## Langkah-langkah Praktikum

### 1. Membuat Layout Utama
Buat folder `layout` di dalam `app/Views/`, kemudian buat file `main.php`:
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'My Website' ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
...
<?= $this->renderSection('content') ?>
...
</body>
</html>
```

### 2. Membuat Class View Cell
Buat folder `Cells` di dalam `app/`, kemudian buat file `ArtikelTerkini.php`:
```php
<?php
namespace App\Cells;

use App\Models\ArtikelModel;

class ArtikelTerkini
{
    public function index()
    {
        $model = new ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}
```

### 3. Membuat View Component
Buat folder `components` di dalam `app/Views/`, kemudian buat file `artikel_terkini.php`:
```php
<div class="widget-box">
<h3 class="title">Artikel Terkini</h3>
<ul>
<?php foreach ($artikel as $row): ?>
<li><a href="<?= base_url('/artikel/' . $row['slug']) ?>"><?= $row['judul'] ?></a></li>
<?php endforeach; ?>
</ul>
</div>
```

### 4. Modifikasi View
Ubah semua view agar menggunakan layout baru dengan cara:
```php
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

// konten halaman di sini

<?= $this->endSection() ?>
```

### 5. Menambah Field created_at
Tambahkan kolom `created_at` pada tabel artikel:
```sql
ALTER TABLE artikel ADD COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP;
```

---

## Hasil Praktikum

### Tampilan Halaman Artikel dengan Layout Baru
![Artikel](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20075543.png?raw=true)

### Tampilan Halaman About dengan Sidebar Artikel Terkini
![About](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080933.png?raw=true)

---

## Jawaban Pertanyaan

### 1. Apa manfaat utama dari penggunaan View Layout?
View Layout memudahkan pengelolaan tampilan secara terpusat. Dengan satu file layout utama, semua halaman dapat menggunakan struktur HTML yang sama tanpa perlu menulis ulang kode header, footer, dan sidebar di setiap halaman.

### 2. Jelaskan perbedaan antara View Cell dan View biasa!
| Fitur | View Cell | View Biasa |
|-------|-----------|------------|
| Punya class sendiri | Ya | Tidak |
| Bisa akses Model mandiri | Ya | Tidak (harus lewat Controller) |
| Bisa terima parameter | Ya | Terbatas |
| Cocok untuk | Widget dinamis | Halaman statis |

### 3. Ubah View Cell agar hanya menampilkan post dengan kategori tertentu
Tambahkan parameter kategori pada method `index()`:
```php
public function index($kategori = null)
{
    $model = new ArtikelModel();
    if ($kategori) {
        $artikel = $model->where('kategori', $kategori)
                        ->orderBy('created_at', 'DESC')
                        ->limit(5)->findAll();
    } else {
        $artikel = $model->orderBy('created_at', 'DESC')
                        ->limit(5)->findAll();
    }
    return view('components/artikel_terkini', ['artikel' => $artikel]);
}
```

---
## Praktikum 4: Framework Lanjutan (Modul Login)

### Tujuan
- Memahami konsep Auth dan Filter
- Memahami konsep dasar Login System
- Membuat modul login menggunakan Framework CodeIgniter 4

### Langkah-langkah

#### 1. Membuat Tabel User
```sql
CREATE TABLE user (
    id INT(11) auto_increment,
    username VARCHAR(200) NOT NULL,
    useremail VARCHAR(200),
    userpassword VARCHAR(200),
    PRIMARY KEY(id)
);
```

#### 2. Membuat Model User
Buat `app/Models/UserModel.php`:
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['username', 'useremail', 'userpassword'];
}
```

#### 3. Membuat Controller User
Buat `app/Controllers/User.php` dengan method `login()` dan `logout()`.

#### 4. Membuat View Login
Buat `app/Views/user/login.php` berisi form Sign In dengan field email dan password.

#### 5. Membuat Database Seeder
```
php spark make:seeder UserSeeder
php spark db:seed UserSeeder
```
Data login:
- Email: `admin@email.com`
- Password: `admin123`

#### 6. Membuat Auth Filter
Buat `app/Filters/Auth.php`:
```php
<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
```

#### 7. Konfigurasi Filters.php
Tambahkan alias `auth` pada `app/Config/Filters.php`:
```php
'auth' => Auth::class,
```

#### 8. Update Routes.php
```php
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
```

### Hasil
- Halaman admin hanya bisa diakses setelah login
- Jika belum login, otomatis redirect ke halaman login
- Logout menghapus session dan redirect ke halaman login

### Screenshot

#### Tampilan Form Login
![Login Form](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20091948.png?raw=true)

#### Tampilan Redirect ke Login (sebelum login)
![Redirect Login](img/redirect_login.png)

#### Tampilan Admin Artikel (setelah login)
![Admin Artikel](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20092322.png?raw=true)

#### Tampilan Tambah Artikel
![Tambah Artikel](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080151.png?raw=true)

#### Tampilan Edit Artikel
![Edit Artikel](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-02%20080219.png?raw=true)

```markdown
```
# Praktikum 5: Pagination dan Pencarian

## Tujuan
1. Memahami konsep dasar Pagination.
2. Memahami konsep dasar Pencarian.
3. Membuat Paging dan Pencarian menggunakan Framework CodeIgniter 4.
```

```
## Langkah-langkah Praktikum

### 1. Membuat Pagination

Modifikasi method `admin_index()` di `app/Controllers/Artikel.php`:
```php
public function admin_index() 
{
    $title = 'Daftar Artikel';
    $q = $this->request->getVar('q') ?? '';
    $model = new ArtikelModel();
    $data = [
        'title'   => $title,
        'q'       => $q,
        'artikel' => $model->like('judul', $q)->paginate(10),
        'pager'   => $model->pager,
    ];
    return view('artikel/admin_index', $data);
}
```

### 2. Menambahkan Link Pagination di View
Tambahkan kode berikut di `app/Views/artikel/admin_index.php` 
setelah tag `</table>`:
```php
<?= $pager->only(['q'])->links(); ?>
```

### 3. Membuat Form Pencarian
Tambahkan form pencarian di `app/Views/artikel/admin_index.php` 
sebelum tabel:
```php
<form method="get" class="form-search">
    <input type="text" name="q" value="<?= $q; ?>" 
        placeholder="Cari data">
    <input type="submit" value="Cari" class="btn btn-primary">
</form>
```

---

## Hasil Praktikum

### Tampilan Admin dengan Pagination dan Pencarian
![Admin Pagination](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-09%20104557.png?raw=true)

### Hasil Pencarian Data
![Hasil Pencarian](https://github.com/MuhammadArkham/Lab7Web/blob/main/Secrenshoot/Screenshot%202026-04-09%20104557.png?raw=true)

---

## Kesimpulan
Pagination berfungsi untuk membatasi tampilan data per halaman 
sehingga halaman tidak terlalu panjang. Fitur pencarian memungkinkan 
admin untuk memfilter data artikel berdasarkan kata kunci tertentu. 
Kedua fitur ini bekerja bersama sehingga hasil pencarian juga 
mendukung pagination.
```

---
View Layan View Cell adalah dua fitur CI4 yang bekerja beriringan untuk membuat UI yang modular dan efisien. View Layout mengatur kerangka besar halaman, sedangkan View Cell mengatur komponen kecil yang dinamis seperti sidebar artikel terkini.
