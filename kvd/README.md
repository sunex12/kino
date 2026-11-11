# Kinokatalogs

Kvalifikācijas darba "Kinokataloga programmatūras izstrāde" lietotāja saskarnes prototips.
Autors: Andris Potapenko, Jelgavas tehnikums, 2026.

Prototips veidots pēc wireframe prezentācijas (`kinokatalogs_bw.pptx`) un darba dokumentācijas.
Izmantots tikai **PHP, HTML un CSS** (bez JavaScript, ietvara un datubāzes).

## Palaišana

Nepieciešams PHP 7.4 vai jaunāks.

```
cd kvd
php -S localhost:8000
```

Pēc tam pārlūkprogrammā jāatver http://localhost:8000

## Lapas (logi) un to saistība ar wireframe

| Fails          | Skats                                   | Wireframe |
|----------------|-----------------------------------------|-----------|
| `index.php`    | Sākumlapa: meklēšana, filtri, plakātu režģis | 1. skats |
| `search.php`   | Meklēšana un rezultāti (filtru panelis + saraksts) | 2. skats |
| `movie.php`    | Filmas detalizētais skats               | 3. skats |
| `trailer.php`  | Treilera skats                          | 4. skats |
| `results.php`  | Meklēšanas rezultāti / "Filmas nav atrastas" | 5. skats |
| `admin.php`    | Filmu pievienošana un dzēšana (papildu) | nav wireframe; atbilst dokumentācijas administratora funkcijām |

Navigācija: Filmas → `index.php`, Žanri → `search.php`, Jaunumi → `results.php?year=2024`, Pieslēgties → `admin.php`.
Katrā lapā ir atgriešanās poga vai navigācija, tāpēc nav strupceļu.

## Mapju struktūra

```
kvd/
├── index.php, search.php, results.php, movie.php, trailer.php, admin.php
├── css/style.css          stili (melnbalts wireframe izskats, responsīvs)
├── data/movies.php        paraugdati: 12 filmas
└── includes/
    ├── header.php         galvene un navigācija
    ├── footer.php         kājene
    ├── functions.php      palīgfunkcijas (filtrēšana, drošs izvads)
    ├── movie_card.php     filmas kartīte
    └── search_form.php    meklēšanas josla
```

## Plāns nākotnei

- **Datu glabāšana:** paraugdatus no `data/movies.php` aizstāt ar MySQL datubāzi.
- **Datu struktūra:** tabulas `movies` (id, title, year, rating, description, poster_url, trailer_url),
  `genres`, `movie_genre` (saite daudzi pret daudziem), `actors`, `movie_actor`, `admins`.
- **Nākamie soļi:** 1) datubāzes savienojums (PDO ar parametrizētiem vaicājumiem); 2) administratora
  pieteikšanās ar paroles jaukšanu (`password_hash`); 3) reāli plakāti un treilera video (iegultā saite);
  4) filmu pievienošana izlasei (F5); 5) testēšana dažādos pārlūkos.
- **Riski:** SQL injekcijas un nepareiza ievade (risina validācija un parametrizēti vaicājumi);
  administratora piekļuves kontrole; autortiesības plakātiem un treileriem; laika trūkums.

## Piezīmes

- Pašlaik `admin.php` dati glabājas sesijā un pazūd, aizverot pārlūku; pieteikšanās vēl nav realizēta.
- Treilera lapā video vietā ir makets, kā wireframe zīmējumā.
