<?php
// Начинаем сессию
session_start();

// Удаляем все данные сессии
session_unset();

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на страницу входа
header('Location: index.html');
exit();
?>
