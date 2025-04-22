<?php
session_start();

// Жестко заданные логины и пароли (замените их на свои)
$credentials = [
    'admin' => 'password123',
    'user' => 'qwerty',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверяем введенные учетные данные
    if (isset($credentials[$username]) && $credentials[$username] === $password) {
        // Учетные данные верны, создаем сессию и перенаправляем на защищенную страницу
        $_SESSION['username'] = $username;
        header('Location: Adminka.php'); // Перенаправляем на страницу Adminka.html при успешной аутентификации
        exit;
    } else {
        // Учетные данные неверны, перенаправляем обратно на главную страницу
        header('Location: index.html'); // Перенаправляем на главную страницу при неудачной аутентификации
        exit;
    }
}
?>
