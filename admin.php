<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт Администратора</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Ваши стили остаются без изменений */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .table-container {
            display: inline-block;
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        button[onclick="document.getElementById('modal').style.display='block'"],
        button[onclick="document.getElementById('editModal').style.display='block'"] {
            display: inline-block;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }
    </style>
</head>
<body>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Роль</th>
                    <th>Логин</th>
                    <th>Действия</th>
                    <th>Пароль</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Параметры подключения к базе данных
                $server = "localhost";
                $user = "admin";
                $pw = "admin";
                $db = "project_yagudin";

                // Соединение с базой данных
                $connect = mysqli_connect($server, $user, $pw, $db);
                if (!$connect) {
                    die("Ошибка соединения: " . mysqli_connect_error());
                }

                // Удаление пользователя, если указан параметр delete
                if (isset($_GET['delete'])) {
                    $idToDelete = intval($_GET['delete']);
                    $deleteQuery = "DELETE FROM `users` WHERE `id` = ?";
                    $stmt = mysqli_prepare($connect, $deleteQuery);
                    mysqli_stmt_bind_param($stmt, "i", $idToDelete);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    echo "Пользователь удален.";
                }

                // Обработка редактирования пользователя
                if (isset($_POST['editLogin'])) {
                    $editId = intval($_POST['editId']);
                    $editRole = $_POST['editRole'];
                    $editLogin = $_POST['editLogin'];
                    $editPassword = $_POST['editPassword'];

                    // SQL-запрос для обновления данных пользователя
                    $updateQuery = "UPDATE `users` SET `root` = ?, `login` = ?, `password` = ? WHERE `id` = ?";
                    $stmt = mysqli_prepare($connect, $updateQuery);
                    mysqli_stmt_bind_param($stmt, "sssi", $editRole, $editLogin, $editPassword, $editId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    header('Location: ' . $_SERVER['PHP_SELF'] . '?message=' . urlencode("Пользователь обновлен."));
                    exit;
                }

                // SQL-запрос для получения всех пользователей
                $query = "SELECT * FROM `users`";
                $result = mysqli_query($connect, $query);

                // Вывод данных в таблицу
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['root']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['login']) . "</td>";
                        echo "<td>";
                        echo "<button onclick='openEditModal(" . $row['id'] . ", \"" . htmlspecialchars($row['root']) . "\", \"" . htmlspecialchars($row['login']) . "\", \"" . htmlspecialchars($row['password']) . "\")'>Редактировать</button> | ";
                        echo "<a href='?delete=" . $row['id'] . "' onclick='return confirm(\"Вы уверены, что хотите удалить?\");'>Удалить</a>";
                        echo "</td>";
                        echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Нет пользователей.</td></tr>";
                }

                // Закрываем соединение
                mysqli_close($connect);
                ?>
            </tbody>
        </table>
    </div>

    <div class="add-button-container">
        <button onclick="document.getElementById('modal').style.display='block'">Добавить пользователя</button>
    </div>

    <!-- Модальное окно для добавления пользователя -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modal').style.display='none'">&times;</span>
            <h2>Добавить нового пользователя</h2>
            <form action="" method="POST">
                <label for="newRole">Роль:</label>
                <select name="newRole" id="newRole">
                    <option value="Admin">Admin</option>
                    <option value="Moderator">Moderator</option>
                    <option value="User">User</option>
                    <option value="Owner">Owner</option>
                </select>

                <label for="newLogin">Логин:</label>
                <input name="newLogin" id="newLogin" required>

                <label for="newPassword">Пароль:</label>
                <input name="newPassword" type="password" id="newPassword" required>

                <input type="submit" value="Добавить">
            </form>
        </div>
    </div>

    <!-- Модальное окно для редактирования пользователя -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('editModal').style.display='none'">&times;</span>
            <h2>Редактировать пользователя</h2>
            <form action="" method="POST">
                <input type="hidden" name="editId" id="editId">
                <label for="editRole">Роль:</label>
                <select name="editRole" id="editRole">
                    <option value="Admin">Admin</option>
                    <option value="Moderator">Moderator</option>
                    <option value="User">User</option>
                    <option value="Owner">Owner</option>
                </select>

                <label for="editLogin">Логин:</label>
                <input name="editLogin" id="editLogin" required>

                <label for="editPassword">Пароль:</label>
                <input name="editPassword" type="password" id="editPassword" required>

                <input type="submit" value="Сохранить изменения">
            </form>
        </div>
    </div>

    <!-- Модальное окно для сообщений -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('messageModal').style.display='none'">&times;</span>
            <p id="messageText"></p>
        </div>
    </div>

    <?php
    // Обработка добавления нового пользователя
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newLogin'])) {
        $newRole = $_POST['newRole'];
        $newLogin = $_POST['newLogin'];
        $newPassword = $_POST['newPassword'];

        // Повторное подключение к базе данных
        $connect = mysqli_connect($server, $user, $pw, $db);
        if (!$connect) {
            die("Ошибка соединения: " . mysqli_connect_error());
        }

        // SQL-запрос для добавления нового пользователя
        $insertQuery = "INSERT INTO `users`(`root`, `login`, `password`) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connect, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sss", $newRole, $newLogin, $newPassword);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Новый пользователь добавлен.";
        } else {
            $message = "Ошибка: " . mysqli_error($connect);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($connect);
        
        // Перенаправление на ту же страницу
        header('Location: ' . $_SERVER['PHP_SELF'] . '?message=' . urlencode($message));
        exit; // Завершение скрипта
    }

    // Получение сообщения из URL
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        echo "<script>
                document.getElementById('messageText').innerText = '$message';
                document.getElementById('messageModal').style.display = 'block';
              </script>";
    }
    ?>

    <script>
        // Открытие модального окна для редактирования
        function openEditModal(id, role, login, password) {
            document.getElementById('editId').value = id;
            document.getElementById('editRole').value = role;
            document.getElementById('editLogin').value = login;
            document.getElementById('editPassword').value = password;
            document.getElementById('editModal').style.display = 'block';
        }

        // Закрытие модального окна при клике вне его
        window.onclick = function(event) {
            if (event.target == document.getElementById('modal')) {
                document.getElementById('modal').style.display = "none";
            }
            if (event.target == document.getElementById('messageModal')) {
                document.getElementById('messageModal').style.display = "none";
            }
            if (event.target == document.getElementById('editModal')) {
                document.getElementById('editModal').style.display = "none";
            }
        }
    </script>
</body>
</html>
