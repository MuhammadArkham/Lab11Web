<aside class="sidebar">
    <h3>Navigasi Utama</h3>
    <ul>
        <li><a href="/lab11_php_oop/index.php/home/index">🏠 Beranda</a></li>
        
        <?php if (isset($_SESSION['is_login'])): ?>
            <li><a href="/lab11_php_oop/index.php/artikel/index">📄 Data Artikel</a></li>
            <li><a href="/lab11_php_oop/index.php/artikel/tambah">➕ Tambah Artikel</a></li>
            
            <li><a href="/lab11_php_oop/index.php/user/profile">👤 Profil Saya</a></li>
            
            <li><a href="/lab11_php_oop/index.php/user/logout" style="color:red;">🚪 Logout</a></li>
        <?php else: ?>
            <li><a href="/lab11_php_oop/index.php/user/login" style="color:green;">🔐 Login</a></li>
        <?php endif; ?>
    </ul>
</aside>