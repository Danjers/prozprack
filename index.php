<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма входа</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error-message {
            display: none;
            color: red;
            margin-top: 10px;
        }
    </style>
    <script>
        function validateForm(event) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');
            if (username === "" || password === "") {
                errorMessage.style.display = 'block'; // Показать сообщение
                return false; // Не отправлять форму
            } 
            errorMessage.style.display = 'none'; // Скрыть сообщение
            return true; // Отправить форму
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <form id="loginForm" action="" method="POST" onsubmit="return validateForm(event)">
            <h1>Форма входа</h1>
            <div class="input-box"> 
                <input type="text" id="username" name="login" placeholder="Имя пользователя" required>
            </div>
            <div class="input-box"> 
                <input type="password" id="password" name="password" placeholder="Пароль" required>
            </div>
            <button type="submit" class="btn">Войти</button>
            <div class="error-message" id="errorMessage">Неверное имя пользователя или пароль.</div>
            <div class="remember">
                <label for=""><input type="checkbox">Запомнить меня</label>
            </div>
            <div class="register-link">
                <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
            </div>
        </form>    
    </div>
</body>
<?php
session_start(); // Начинаем сессию

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    // Параметры подключения
    $server = "localhost";
    $user = "admin";
    $pw = "admin";
    $db = "project_yagudin";

    // Соединение с базой данных
    $connect = mysqli_connect($server, $user, $pw, $db);
    if (!$connect) {
        die("Ошибка соединения: " . mysqli_connect_error());
    }

    // Подготовка SQL-запроса
    $stmt = mysqli_prepare($connect, "SELECT `root` FROM `users` WHERE `login` = ? AND `password` = ?");
    mysqli_stmt_bind_param($stmt, "ss", $login, $password);

    // Выполнение запроса
    if (!mysqli_stmt_execute($stmt)) {
        echo "Ошибка выполнения запроса: " . mysqli_error($connect);
    } else {
        // Получение результата
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $root = $user_data['root'];
            // Сохраняем имя пользователя в сессии
            $_SESSION['username'] = $login; // или используйте другое поле, если нужно

            // Перенаправление в зависимости от роли
            switch ($root) {
                case 'Admin':
                    header("Location: admin.php");
                    break;
                case 'Moderator':
                    header("Location: moderator.php");
                    break;
                case 'User':
                    header("Location: user.php");
                    break;
                case 'Owner':
                    header("Location: owner.php");
                    break;
                default:
                    echo "Неизвестная роль.";
                    break;
            }
            exit();
        } else {
            echo "Неверный логин или пароль.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
?>
</html>