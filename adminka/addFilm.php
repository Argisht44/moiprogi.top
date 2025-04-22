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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $poster = base64_encode(file_get_contents($_FILES['poster']['tmp_name']));
    $description = $_POST['description'];
    $youtube_link = $_POST['youtube_link'];
    $release_year = $_POST['release_year'];

    $sql = "INSERT INTO films (title, poster, description, youtube_link, release_year) VALUES (?, ?, ?, ?, ?)";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$title, $poster, $description, $youtube_link, $release_year]);
}
?>
