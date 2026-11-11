<?php
// 4. skats: Treilera skats. Video vietā tiek rādīts attēlojuma makets ar atskaņošanas simbolu.
require __DIR__ . '/includes/functions.php';

$movie = findMovieById(getQueryParam('id'));
$isPlaying = getQueryParam('play') === '1';

$pageTitle = $movie ? $movie['title'] . ' — treileris' : 'Treileris nav atrasts';
$activePage = 'movies';

require __DIR__ . '/includes/header.php';

if ($movie === null): ?>
    <div class="empty-state">
        <h1>Treileris nav atrasts</h1>
        <p>Filma, kurai meklēts treileris, katalogā neeksistē.</p>
        <a class="btn btn-primary" href="index.php">Atpakaļ uz katalogu</a>
    </div>
<?php
    require __DIR__ . '/includes/footer.php';
    exit;
endif;
?>
<section class="trailer-section">
    <h1 class="trailer-title"><?= e($movie['title']) ?> — treileris</h1>

    <div class="video-placeholder" role="img" aria-label="Treilera video vieta">
        <span class="play-symbol"><?= $isPlaying ? '&#10074;&#10074;' : '&#9654;' ?></span>
        <div class="progress-bar"><div class="progress-fill<?= $isPlaying ? ' progress-fill-playing' : '' ?>"></div></div>
    </div>
    <p class="trailer-status"><?= $isPlaying ? 'Treileris tiek atskaņots (demonstrācija).' : 'Nospiediet „Atskaņot”, lai sāktu skatīties treileri.' ?></p>

    <div class="button-row button-row-center">
        <?php if ($isPlaying): ?>
            <a class="btn btn-primary" href="trailer.php?id=<?= (int) $movie['id'] ?>">&#10074;&#10074; Pauze</a>
        <?php else: ?>
            <a class="btn btn-primary" href="trailer.php?id=<?= (int) $movie['id'] ?>&amp;play=1">&#9654; Atskaņot</a>
        <?php endif; ?>
        <a class="btn btn-secondary" href="movie.php?id=<?= (int) $movie['id'] ?>">&larr; Atgriezties pie filmas</a>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
