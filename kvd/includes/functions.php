<?php
// Palīgfunkcijas, ko izmanto visas lapas.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Droši izvada tekstu HTML (aizsardzība pret XSS). */
function e($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

/** Atgriež visas filmas: paraugdatus + administratora pievienotās (sesijā). */
function getAllMovies()
{
    $movies = require __DIR__ . '/../data/movies.php';
    if (!empty($_SESSION['added_movies'])) {
        $movies = array_merge($movies, $_SESSION['added_movies']);
    }
    return $movies;
}

/** Atrod filmu pēc ID vai atgriež null. */
function findMovieById($movieId)
{
    foreach (getAllMovies() as $movie) {
        if ($movie['id'] === (int) $movieId) {
            return $movie;
        }
    }
    return null;
}

/** Atgriež visus žanrus alfabētiskā secībā. */
function getAllGenres()
{
    $genres = [];
    foreach (getAllMovies() as $movie) {
        $genres = array_merge($genres, $movie['genres']);
    }
    $genres = array_unique($genres);
    sort($genres);
    return $genres;
}

/** Atgriež visus iznākšanas gadus no jaunākā uz vecāko. */
function getAllYears()
{
    $years = array_unique(array_column(getAllMovies(), 'year'));
    rsort($years);
    return $years;
}

/** Filtrē filmas pēc nosaukuma teksta, žanra un gada. Tukša vērtība = bez ierobežojuma. */
function filterMovies($searchText, $genre, $year)
{
    $searchText = mb_strtolower(trim($searchText));
    $result = [];
    foreach (getAllMovies() as $movie) {
        if ($searchText !== '' && mb_strpos(mb_strtolower($movie['title']), $searchText) === false) {
            continue;
        }
        if ($genre !== '' && !in_array($genre, $movie['genres'], true)) {
            continue;
        }
        if ($year !== '' && $movie['year'] !== (int) $year) {
            continue;
        }
        $result[] = $movie;
    }
    return $result;
}

/** Nolasa GET parametru kā tīru tekstu. */
function getQueryParam($name)
{
    return isset($_GET[$name]) ? trim((string) $_GET[$name]) : '';
}

/** Pareizā locījuma vārds "filma/filmas/filmu" skaitam. */
function filmCountText($count)
{
    if ($count % 10 === 1 && $count % 100 !== 11) {
        return $count . ' filma';
    }
    if ($count === 0 || ($count % 10 === 0) || ($count % 100 >= 11 && $count % 100 <= 19)) {
        return $count . ' filmu';
    }
    return $count . ' filmas';
}
