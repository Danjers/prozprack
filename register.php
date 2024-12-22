<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Авторизация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
        }

        input[type="text"],
        input[type="password"],
        input[name="login"] {
            width: 100%; /* Полная ширина контейнера */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px; /* Отступ снизу */
            box-sizing: border-box; /* Учитываем padding и border в ширине */
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .hidden {
            display: none; /* Скрываем элементы */
        }

        .success-message {
            color: green; /* Цвет сообщения об успехе */
            margin-top: 10px;
            text-align: center;
        }

        .error-message {
            color: red; /* Цвет сообщения об ошибке */
            margin-top: 10px;
            text-align: center;
        }
    </style>
    <script>
        function showPasswordForm() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('passwordForm').classList.remove('hidden');
        }
    </script>
</head>
<body>
<div class="container">
    <form id="loginForm" action="" method="POST">
        <input name="login" id="login" placeholder="Имя пользователя" required>
        <input type="button" class="btn" value="Далее" onclick="showPasswordForm()">
    </form>

    <form id="passwordForm" class="hidden" action="" method="POST">
        <input name="password" type="password" id="password" placeholder="Пароль" required>
        <input type="submit" class="btn" value="Зарегистрироваться">
        <input type="hidden" name="hiddenLogin" id="hiddenLogin">
    </form>

    <div id="message" class="success-message hidden"></div>
</div>

<?php
session_start(); // Запускаем сессию, чтобы использовать её для сообщений

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['password']) && !empty($_POST['hiddenLogin'])) {
    $root = "User";
    $login = $_POST['hiddenLogin'];
    $password = $_POST['password'];
    $server = "localhost";
    $user = "admin";
    $pw = "admin";
    $db = "Yagudin";

    $connect = mysqli_connect($server, $user, $pw, $db);

    if (!$connect) {
        die("Ошибка соединения: " . mysqli_connect_error());
    }

    // Проверка существования пользователя
    $checkUser = mysqli_prepare($connect, "SELECT COUNT(*) FROM `users` WHERE `login` = ?");
    mysqli_stmt_bind_param($checkUser, "s", $login);
    mysqli_stmt_execute($checkUser);
    mysqli_stmt_bind_result($checkUser, $userExists);
    mysqli_stmt_fetch($checkUser);
    mysqli_stmt_close($checkUser);

    if ($userExists > 0) {
        // Устанавливаем сообщение об ошибке
        echo '<script>document.getElementById("message").innerText = "Пользователь с таким именем уже существует!"; document.getElementById("message").classList.replace("success-message", "error-message"); document.getElementById("message").classList.remove("hidden");</script>';
    } else {
        // Подготовка и выполнение запроса
        $stmt = mysqli_prepare($connect, "INSERT INTO `users`(`root`, `login`, `password`) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $root, $login, $password);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Устанавливаем сообщение об успехе
        if ($result) {
            $_SESSION['success_message'] = "Пользователь успешно зарегистрирован!";
            mysqli_close($connect);
            header("Location: " . $_SERVER['PHP_SELF']); // Редирект на ту же страницу
            exit();
        } else {
            echo '<script>document.getElementById("message").innerText = "Ошибка при регистрации."; document.getElementById("message").classList.replace("success-message", "error-message"); document.getElementById("message").classList.remove("hidden");</script>';
        }
    }

    mysqli_close($connect);
}

// Выводим сообщение об успехе, если оно существует
if (isset($_SESSION['success_message'])) {
    echo '<script>document.getElementById("message").innerText = "' . $_SESSION['success_message'] . '";</script>';
    echo '<script>document.getElementById("message").classList.remove("hidden");</script>';
    unset($_SESSION['success_message']); // Удаляем сообщение из сессии
}
?>

<script>
    // Переносим логин в скрытое поле в форме пароля
    document.getElementById('login').addEventListener('input', function() {
        document.getElementById('hiddenLogin').value = this.value;
    });
</script>
</body>
</html>
