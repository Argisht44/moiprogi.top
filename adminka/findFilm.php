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

// Получаем название фильма из запроса
$title = isset($_POST['title']) ? $_POST['title'] : '';

// Подготавливаем запрос для поиска фильма по названию
$stmt = $pdo->prepare('SELECT * FROM films WHERE title LIKE :title');
$stmt->execute(['title' => '%' . $title . '%']);
$films = $stmt->fetchAll();

// Возвращаем результат в формате JSON
header('Content-Type: application/json');
echo json_encode($films);
?>
