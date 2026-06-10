<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin Panel'; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
<div id="container">
<header>
    <h1>Admin Portal Berita</h1>
</header>
<nav>
    <a href="<?= base_url('/admin/artikel');?>">Artikel</a>
    <a href="<?= base_url('/admin/artikel/add');?>">Tambah Artikel</a>
</nav>
<section id="wrapper">
<section id="main">