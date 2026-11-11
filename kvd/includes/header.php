<?php
// Kopīgā lapas galvene: <head>, logotips un navigācijas izvēlne.
// Pirms iekļaušanas lapā jānosaka $pageTitle un $activePage.
$navigationItems = [
    'movies'  => ['title' => 'Filmas',      'url' => 'index.php'],
    'genres'  => ['title' => 'Žanri',       'url' => 'search.php'],
    'news'    => ['title' => 'Jaunumi',     'url' => 'results.php?year=2024'],
    'login'   => ['title' => 'Pieslēgties', 'url' => 'admin.php'],
];
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | Kinokatalogs</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="page">
    <header class="site-header">
        <a class="logo" href="index.php">
            <span class="logo-icon">&#9654;</span>
            <span class="logo-text">KINOKATALOGS</span>
        </a>
        <nav class="main-nav" aria-label="Galvenā izvēlne">
            <?php foreach ($navigationItems as $key => $item): ?>
                <a href="<?= e($item['url']) ?>"<?= $key === $activePage ? ' class="active"' : '' ?>><?= e($item['title']) ?></a>
            <?php endforeach; ?>
        </nav>
    </header>
    <main class="content">
