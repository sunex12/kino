<?php
// Horizontālā meklēšanas un filtru forma (sākumlapa).
// Nepieciešami mainīgie: $searchText, $selectedGenre, $selectedYear.
?>
<form class="search-bar" id="meklesana" action="results.php" method="get">
    <input class="field field-grow" type="text" name="q" placeholder="Meklēt filmu pēc nosaukuma..."
           value="<?= e($searchText) ?>" aria-label="Filmas nosaukums">
    <button class="btn btn-primary" type="submit">Meklēt</button>
    <select class="field" name="genre" aria-label="Žanrs">
        <option value="">Žanrs</option>
        <?php foreach (getAllGenres() as $genreName): ?>
            <option value="<?= e($genreName) ?>"<?= $genreName === $selectedGenre ? ' selected' : '' ?>><?= e($genreName) ?></option>
        <?php endforeach; ?>
    </select>
    <select class="field" name="year" aria-label="Iznākšanas gads">
        <option value="">Izdošanas gads</option>
        <?php foreach (getAllYears() as $yearValue): ?>
            <option value="<?= (int) $yearValue ?>"<?= (string) $yearValue === $selectedYear ? ' selected' : '' ?>><?= (int) $yearValue ?></option>
        <?php endforeach; ?>
    </select>
</form>
