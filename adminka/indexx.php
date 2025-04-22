<?php
session_start();

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['username'])) {
    // Если пользователь авторизован, перенаправляем его на страницу Adminka.php
    header('Location: Adminka.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            width: 300px;
            box-sizing: border-box;
        }
        form h2 {
            text-align: center;
        }
        form label {
            display: block;
            margin-bottom: 5px;
        }
        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            width: 100%;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        button, input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        /* Анимация при наведении */
        button:hover, input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Анимация при нажатии */
        button:active, input[type="submit"]:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <div style="text-align:center;">
            <img src="icon.png" alt="Иконка" style="width:50px;height:50px;">
        </div>
        <h2>Авторизуйся!</h2>
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username"><br>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Войти">
    </form>
</body>
</html>
