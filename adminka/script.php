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

$stmt = $pdo->query('SELECT * FROM films');
$films = [];
while ($row = $stmt->fetch())
{
    $films[] = $row;
}

header('Content-Type: text/xml');
echo '<films>';
foreach ($films as $film) {
    echo '<film>';
    echo '<id>' . $film['id'] . '</id>';
    echo '<title>' . htmlspecialchars($film['title']) . '</title>';
    echo '<poster>' . $film['poster'] . '</poster>';
    echo '<description>' . htmlspecialchars($film['description']) . '</description>';
    echo '<youtube_link>' . htmlspecialchars($film['youtube_link']) . '</youtube_link>';
    echo '<release_year>' . $film['release_year'] . '</release_year>';
    echo '</film>';
}
echo '</films>';
?>
