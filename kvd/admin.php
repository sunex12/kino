<?php
// 6. skats (papildu): Filmu pārvaldība — jaunas filmas pievienošana un pievienoto filmu dzēšana.
// Dati tiek glabāti sesijā (bez datubāzes), tāpēc pēc pārlūkprogrammas aizvēršanas tie pazūd.
require __DIR__ . '/includes/functions.php';

$errors = [];
$formValues = ['title' => '', 'year' => '', 'rating' => '', 'description' => '', 'actors' => '', 'genres' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $formValues['title'] = trim($_POST['title'] ?? '');
        $formValues['year'] = trim($_POST['year'] ?? '');
        $formValues['rating'] = trim($_POST['rating'] ?? '');
        $formValues['description'] = trim($_POST['description'] ?? '');
        $formValues['actors'] = trim($_POST['actors'] ?? '');
        $formValues['genres'] = isset($_POST['genres']) && is_array($_POST['genres'])
            ? array_values(array_filter($_POST['genres'], 'is_string'))
            : [];

        // Datu validācija
        if ($formValues['title'] === '') {
            $errors[] = 'Filmas nosaukums nedrīkst būt tukšs.';
        }
        if (!ctype_digit($formValues['year']) || (int) $formValues['year'] < 1900 || (int) $formValues['year'] > (int) date('Y') + 1) {
            $errors[] = 'Iznākšanas gadam jābūt derīgam skaitlim no 1900 līdz nākamajam gadam.';
        }
        if (!is_numeric($formValues['rating']) || (float) $formValues['rating'] < 0 || (float) $formValues['rating'] > 10) {
            $errors[] = 'Vērtējumam jābūt skaitlim no 0 līdz 10.';
        }
        if (count($formValues['genres']) === 0) {
            $errors[] = 'Jāizvēlas vismaz viens žanrs.';
        }
        if ($formValues['description'] === '') {
            $errors[] = 'Sižeta apraksts nedrīkst būt tukšs.';
        }

        if (count($errors) === 0) {
            $actorList = array_values(array_filter(array_map('trim', explode(',', $formValues['actors']))));
            $newMovieId = max(array_column(getAllMovies(), 'id')) + 1;
            $_SESSION['added_movies'][] = [
                'id' => $newMovieId,
                'title' => $formValues['title'],
                'year' => (int) $formValues['year'],
                'genres' => array_values(array_intersect($formValues['genres'], getAllGenres())),
                'rating' => (float) $formValues['rating'],
                'short' => mb_substr($formValues['description'], 0, 80),
                'description' => $formValues['description'],
                'actors' => $actorList,
            ];
            $_SESSION['flash_message'] = 'Filma „' . $formValues['title'] . '” veiksmīgi pievienota.';
            header('Location: admin.php');
            exit;
        }
    }

    if ($action === 'delete') {
        $deleteId = (int) ($_POST['movie_id'] ?? 0);
        if (!empty($_SESSION['added_movies'])) {
            $_SESSION['added_movies'] = array_values(array_filter(
                $_SESSION['added_movies'],
                function ($addedMovie) use ($deleteId) {
                    return $addedMovie['id'] !== $deleteId;
                }
            ));
            $_SESSION['flash_message'] = 'Filma izdzēsta.';
        }
        header('Location: admin.php');
        exit;
    }
}

// Vienreizējs paziņojums pēc pievienošanas vai dzēšanas
$flashMessage = $_SESSION['flash_message'] ?? '';
unset($_SESSION['flash_message']);

$baseMovieCount = count(require __DIR__ . '/data/movies.php');
$addedMovies = $_SESSION['added_movies'] ?? [];

$pageTitle = 'Filmu pārvaldība';
$activePage = 'login';
require __DIR__ . '/includes/header.php';
?>
<section>
    <h1 class="page-title">Filmu pārvaldība</h1>
    <p class="page-intro">Šajā demonstrācijas sadaļā administrators var pievienot jaunu filmu katalogam.
        Pievienotās filmas uzreiz parādās sākumlapā un meklēšanā. Datu glabāšana ar datubāzi un pieteikšanās
        pārbaude tiks pievienota nākamajos izstrādes posmos.</p>

    <?php if ($flashMessage !== ''): ?>
        <div class="notice notice-success" role="status"><?= e($flashMessage) ?></div>
    <?php endif; ?>

    <?php if (count($errors) > 0): ?>
        <div class="notice notice-error" role="alert">
            <strong>Formu neizdevās saglabāt:</strong>
            <ul>
                <?php foreach ($errors as $errorText): ?>
                    <li><?= e($errorText) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="layout-sidebar">
        <form class="admin-form" action="admin.php" method="post">
            <h2 class="panel-title">Pievienot jaunu filmu</h2>
            <input type="hidden" name="action" value="add">

            <label class="field-label" for="movie-title">Nosaukums</label>
            <input class="field" id="movie-title" type="text" name="title" value="<?= e($formValues['title']) ?>">

            <label class="field-label" for="movie-year">Iznākšanas gads</label>
            <input class="field" id="movie-year" type="text" name="year" inputmode="numeric" value="<?= e($formValues['year']) ?>">

            <label class="field-label" for="movie-rating">Vērtējums (0–10)</label>
            <input class="field" id="movie-rating" type="text" name="rating" inputmode="decimal" value="<?= e($formValues['rating']) ?>">

            <fieldset class="genre-fieldset">
                <legend class="field-label">Žanri</legend>
                <?php foreach (getAllGenres() as $genreName): ?>
                    <label class="checkbox">
                        <input type="checkbox" name="genres[]" value="<?= e($genreName) ?>"<?= in_array($genreName, $formValues['genres'], true) ? ' checked' : '' ?>>
                        <?= e($genreName) ?>
                    </label>
                <?php endforeach; ?>
            </fieldset>

            <label class="field-label" for="movie-description">Sižeta apraksts</label>
            <textarea class="field" id="movie-description" name="description" rows="5"><?= e($formValues['description']) ?></textarea>

            <label class="field-label" for="movie-actors">Aktieri (atdalīti ar komatu)</label>
            <input class="field" id="movie-actors" type="text" name="actors" value="<?= e($formValues['actors']) ?>">

            <button class="btn btn-primary btn-block" type="submit">Saglabāt filmu</button>
            <a class="btn btn-secondary btn-block" href="index.php">Atpakaļ uz katalogu</a>
        </form>

        <section class="results-panel">
            <div class="results-header">
                <h2 class="section-title">Katalogā esošās filmas</h2>
                <span class="results-count">Kopā: <?= $baseMovieCount + count($addedMovies) ?></span>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr><th>Nosaukums</th><th>Gads</th><th>Žanri</th><th>Darbība</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach (getAllMovies() as $movie): ?>
                            <?php $isAdded = $movie['id'] > $baseMovieCount; ?>
                            <tr>
                                <td><a href="movie.php?id=<?= (int) $movie['id'] ?>"><?= e($movie['title']) ?></a></td>
                                <td><?= (int) $movie['year'] ?></td>
                                <td><?= e(implode(', ', $movie['genres'])) ?></td>
                                <td>
                                    <?php if ($isAdded): ?>
                                        <form action="admin.php" method="post">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="movie_id" value="<?= (int) $movie['id'] ?>">
                                            <button class="btn btn-small btn-secondary" type="submit">Dzēst</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="muted">paraugdati</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
