<?php
// Filmas plakāta kartīte režģim (sākumlapa, rezultāti).
// Nepieciešams mainīgais $movie.
?>
<a class="movie-card" href="movie.php?id=<?= (int) $movie['id'] ?>">
    <div class="poster" role="img" aria-label="Filmas plakāts: <?= e($movie['title']) ?>"></div>
    <h3 class="movie-card-title"><?= e($movie['title']) ?></h3>
    <p class="movie-card-year"><?= (int) $movie['year'] ?></p>
</a>
