<?php
// 5. skats: Meklēšanas rezultātu papildu skats — režģis vai paziņojums "Filmas nav atrastas".
require __DIR__ . '/includes/functions.php';

$searchText = getQueryParam('q');
$selectedGenre = getQueryParam('genre');
$selectedYear = getQueryParam('year');
$foundMovies = filterMovies($searchText, $selectedGenre, $selectedYear);

$pageTitle = 'Meklēšanas rezultāti';
$activePage = $searchText === '' && $selectedGenre === '' && $selectedYear === '2024' ? 'news' : 'movies';

require __DIR__ . '/includes/header.php';
?>
<section>
    <div class="results-header">
        <h1 class="page-title">Meklēšanas rezultāti</h1>
        <span class="pill">Atrastas <?= e(filmCountText(count($foundMovies))) ?></span>
    </div>

    <?php if ($searchText !== '' || $selectedGenre !== '' || $selectedYear !== ''): ?>
        <p class="page-intro">Meklēts:
            <?= $searchText !== '' ? '„' . e($searchText) . '”' : 'visas filmas' ?>
            <?= $selectedGenre !== '' ? ' &middot; žanrs: ' . e($selectedGenre) : '' ?>
            <?= $selectedYear !== '' ? ' &middot; gads: ' . e($selectedYear) : '' ?>
        </p>
    <?php else: ?>
        <p class="page-intro">Nav norādīts neviens meklēšanas nosacījums, tāpēc tiek rādītas visas filmas.</p>
    <?php endif; ?>

    <?php if (count($foundMovies) > 0): ?>
        <div class="movie-grid">
            <?php foreach ($foundMovies as $movie): ?>
                <?php require __DIR__ . '/includes/movie_card.php'; ?>
            <?php endforeach; ?>
        </div>
        <p class="again-row"><a class="btn btn-secondary" href="index.php#meklesana">Meklēt vēlreiz</a></p>
    <?php else: ?>
        <div class="empty-state">
            <h2>Filmas nav atrastas</h2>
            <p>Mēģini mainīt nosaukumu vai filtrus</p>
            <a class="btn btn-primary" href="index.php#meklesana">Meklēt vēlreiz</a>
        </div>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
