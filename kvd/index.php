<?php
// 1. skats: Sākumlapa — meklēšana, filtri un filmu plakātu režģis.
require __DIR__ . '/includes/functions.php';

$pageTitle = 'Sākumlapa';
$activePage = 'movies';
$searchText = '';
$selectedGenre = '';
$selectedYear = '';
$movies = getAllMovies();

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/search_form.php';
?>
<section>
    <h1 class="page-title">Visas filmas</h1>
    <p class="page-intro">Pārlūkojiet katalogu, izmantojiet meklēšanu vai filtrus un atveriet filmu, lai uzzinātu vairāk.
        Katrai filmai ir pieejams sižeta apraksts, aktieru saraksts un treileris.</p>
    <div class="movie-grid">
        <?php foreach ($movies as $movie): ?>
            <?php require __DIR__ . '/includes/movie_card.php'; ?>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
