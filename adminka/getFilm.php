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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    $sql = "SELECT * FROM films WHERE id = ?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$id]);

    $film = $stmt->fetch();

    echo json_encode($film);
}
?>
