<?php
// 3. skats: Filmas detalizētais skats.
require __DIR__ . '/includes/functions.php';

$movie = findMovieById(getQueryParam('id'));

$pageTitle = $movie ? $movie['title'] : 'Filma nav atrasta';
$activePage = 'movies';

require __DIR__ . '/includes/header.php';

// Ja filma neeksistē, parādām saprotamu paziņojumu ar iespēju atgriezties.
if ($movie === null): ?>
    <div class="empty-state">
        <h1>Filma nav atrasta</h1>
        <p>Šāda filma katalogā neeksistē vai ir izdzēsta.</p>
        <a class="btn btn-primary" href="index.php">Atpakaļ uz katalogu</a>
    </div>
<?php
    require __DIR__ . '/includes/footer.php';
    exit;
endif;
?>
<article class="movie-details">
    <div class="poster poster-large" role="img" aria-label="Filmas plakāts: <?= e($movie['title']) ?>"></div>

    <div class="movie-info">
        <div class="movie-heading">
            <h1 class="movie-title"><?= e($movie['title']) ?></h1>
            <p class="movie-rating">&#9733; <?= number_format($movie['rating'], 1) ?></p>
        </div>

        <ul class="tag-list">
            <li class="pill"><?= (int) $movie['year'] ?></li>
            <?php foreach ($movie['genres'] as $genreName): ?>
                <li class="pill"><?= e($genreName) ?></li>
            <?php endforeach; ?>
        </ul>

        <h2 class="section-label">Sižeta apraksts</h2>
        <p class="movie-description"><?= e($movie['description']) ?></p>

        <h2 class="section-label">Aktieri</h2>
        <ul class="actor-list">
            <?php foreach ($movie['actors'] as $actorName): ?>
                <li class="actor">
                    <span class="actor-photo" aria-hidden="true"></span>
                    <span class="actor-name"><?= e($actorName) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="button-row">
            <a class="btn btn-primary" href="trailer.php?id=<?= (int) $movie['id'] ?>">&#9654; Skatīties treileri</a>
            <a class="btn btn-secondary" href="index.php">&larr; Atpakaļ uz katalogu</a>
        </div>
    </div>
</article>
<?php require __DIR__ . '/includes/footer.php'; ?>
