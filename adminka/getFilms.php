<?php
$host = 'localhost';
$db   = 'pblvxsxx_films_db';
$user = 'pblvxsxx_films_db';
$pass = 'films_db';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$films = $pdo->query("SELECT * FROM films ORDER BY id DESC")->fetchAll();

foreach ($films as $film) {
    echo '<div class="film">';
    echo '<img src="data:image/jpeg;base64,' . $film['poster'] . '" alt="' . htmlspecialchars($film['title']) . '">';
    echo '<div class="film-info">';
    echo '<h2>' . htmlspecialchars($film['title']) . '</h2>';
    echo '<p>Год выпуска: ' . htmlspecialchars($film['release_year']) . '</p>';
    echo '<p>Ссылка на Youtube: <a href="' . htmlspecialchars($film['youtube_link']) . '">' . htmlspecialchars($film['youtube_link']) . '</a></p>';
    echo '<p>' . htmlspecialchars($film['description']) . '</p>';
    echo '<button class="edit-button" data-id="' . $film['id'] . '">Редактировать</button>';
    echo '<button class="delete-button" data-id="' . $film['id'] . '">Удалить</button>';
    echo '</div>';
    echo '</div>';
}
?>