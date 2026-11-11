<?php
// 2. skats: Filmu meklēšana un rezultāti — filtru panelis un rezultātu saraksts.
require __DIR__ . '/includes/functions.php';

$pageTitle = 'Filmu meklēšana';
$activePage = 'genres';
$searchText = getQueryParam('q');
$selectedGenre = getQueryParam('genre');
$selectedYear = getQueryParam('year');
$foundMovies = filterMovies($searchText, $selectedGenre, $selectedYear);

require __DIR__ . '/includes/header.php';
?>
<div class="layout-sidebar">
    <aside class="filter-panel">
        <h2 class="panel-title">Filtri</h2>
        <form action="search.php" method="get">
            <label class="field-label" for="filter-q">Nosaukums</label>
            <input class="field" id="filter-q" type="text" name="q" placeholder="Meklēt..." value="<?= e($searchText) ?>">

            <label class="field-label" for="filter-genre">Žanrs</label>
            <select class="field" id="filter-genre" name="genre">
                <option value="">Visi žanri</option>
                <?php foreach (getAllGenres() as $genreName): ?>
                    <option value="<?= e($genreName) ?>"<?= $genreName === $selectedGenre ? ' selected' : '' ?>><?= e($genreName) ?></option>
                <?php endforeach; ?>
            </select>

            <label class="field-label" for="filter-year">Iznākšanas gads</label>
            <select class="field" id="filter-year" name="year">
                <option value="">Visi gadi</option>
                <?php foreach (getAllYears() as $yearValue): ?>
                    <option value="<?= (int) $yearValue ?>"<?= (string) $yearValue === $selectedYear ? ' selected' : '' ?>><?= (int) $yearValue ?></option>
                <?php endforeach; ?>
            </select>

            <button class="btn btn-primary btn-block" type="submit">Pielietot filtrus</button>
            <a class="btn btn-secondary btn-block" href="search.php">Notīrīt filtrus</a>
        </form>
    </aside>

    <section class="results-panel">
        <div class="results-header">
            <h1 class="section-title">Atrastās filmas</h1>
            <span class="results-count">Rezultāti: <?= count($foundMovies) ?></span>
        </div>

        <?php if (count($foundMovies) === 0): ?>
            <div class="empty-state">
                <h2>Filmas nav atrastas</h2>
                <p>Mēģiniet mainīt nosaukumu vai filtrus.</p>
                <a class="btn btn-primary" href="search.php">Rādīt visas filmas</a>
            </div>
        <?php endif; ?>

        <?php foreach ($foundMovies as $movie): ?>
            <article class="result-row">
                <div class="poster poster-small" role="img" aria-label="Filmas plakāts"></div>
                <div class="result-info">
                    <h2 class="result-title"><?= e($movie['title']) ?></h2>
                    <p class="result-meta"><?= (int) $movie['year'] ?> &middot; <?= e(implode(', ', $movie['genres'])) ?></p>
                    <p class="result-text"><?= e($movie['short']) ?></p>
                </div>
                <a class="btn btn-secondary" href="movie.php?id=<?= (int) $movie['id'] ?>">Skatīt vairāk</a>
            </article>
        <?php endforeach; ?>
    </section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
