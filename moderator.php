<?php
// Включение отображения ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных
$mysqli = new mysqli('localhost', 'admin', 'admin', 'project_yagudin');

// Проверка соединения
if ($mysqli->connect_error) {
    die("Ошибка соединения: " . $mysqli->connect_error);
}

// Функция для выполнения запросов
function executeQuery($query) {
    global $mysqli;
    return $mysqli->query($query) ? "Успешно выполнено!" : "Ошибка: " . $mysqli->error;
}

// Обработка форм
$message = '';


    // Добавление менеджера
    if (isset($_POST['add_manager'])) {
        $name = $mysqli->real_escape_string($_POST['name']);
        $surname = $mysqli->real_escape_string($_POST['surname']);
        $phone_number = $mysqli->real_escape_string($_POST['phone_number']);
        $patronymic = $mysqli->real_escape_string($_POST['patronymic']);
        
        $query = "INSERT INTO Manager (Name, Surname, phone_number, patronymic) VALUES ('$name', '$surname', '$phone_number', '$patronymic')";
        $message = executeQuery($query);
    }

    // Удаление менеджера
    if (isset($_POST['delete_manager'])) {
        $manager_id = intval($_POST['manager_id']);
        $query = "DELETE FROM Manager WHERE ID = $manager_id";
        $message = executeQuery($query);
    }

    // Сохранение изменений менеджера
    if (isset($_POST['save_manager'])) {
        $edit_manager_id = intval($_POST['edit_manager_id']);
        $name = $mysqli->real_escape_string($_POST['name']);
        $surname = $mysqli->real_escape_string($_POST['surname']);
        $phone_number = $mysqli->real_escape_string($_POST['phone_number']);
        $patronymic = $mysqli->real_escape_string($_POST['patronymic']);

        $query = "UPDATE Manager SET Name='$name', Surname='$surname', phone_number='$phone_number', patronymic='$patronymic' WHERE ID=$edit_manager_id";
        $message = executeQuery($query);
    }

    // Аналогичные операции для автомобилей, клиентов, услуг и типов услуг...
    // Добавление автомобиля
    if (isset($_POST['add_car'])) {
        $brand = $mysqli->real_escape_string($_POST['brand']);
        $colour = $mysqli->real_escape_string($_POST['colour']);
        $class = $mysqli->real_escape_string($_POST['class']); 
        $hp = intval($_POST['hp']);
        $cost_rent = floatval($_POST['cost_rent']);
        $rental_price = floatval($_POST['rental_price']);
        $car_fund = intval($_POST['car_fund']);
        $release_date = $mysqli->real_escape_string($_POST['release_date']);
        
        $query = "INSERT INTO Car (Brand, Colour, Class, HP, Cost_rent, rental_price, Car_Fund, Release_date) 
                  VALUES ('$brand', '$colour', '$class', $hp, $cost_rent, $rental_price, $car_fund, '$release_date')";
        $message = executeQuery($query);
    }

    // Удаление автомобиля
    if (isset($_POST['delete_car'])) {
        $car_id = intval($_POST['car_id']);
        $query = "DELETE FROM Car WHERE ID = $car_id";
        $message = executeQuery($query);
    }

    // Сохранение изменений автомобиля
    if (isset($_POST['save_car'])) {
        $edit_car_id = intval($_POST['edit_car_id']);
        $brand = $mysqli->real_escape_string($_POST['brand']);
        $colour = $mysqli->real_escape_string($_POST['colour']);
        $class = $mysqli->real_escape_string($_POST['class']); 
        $hp = intval($_POST['hp']);
        $cost_rent = floatval($_POST['cost_rent']);
        $rental_price = floatval($_POST['rental_price']);
        $car_fund = intval($_POST['car_fund']);
        $release_date = $mysqli->real_escape_string($_POST['release_date']);
        
        $query = "UPDATE Car SET Brand='$brand', Colour='$colour', Class='$class', HP=$hp, Cost_rent=$cost_rent, rental_price=$rental_price, 
                  Car_Fund=$car_fund, Release_date='$release_date' WHERE ID=$edit_car_id";
        $message = executeQuery($query);
    }

    // Аналогичные операции для клиентов...
    // Добавление клиента
    if (isset($_POST['add_client'])) {
        $name = $mysqli->real_escape_string($_POST['name']);
        $surname = $mysqli->real_escape_string($_POST['surname']);
        $phone_number = $mysqli->real_escape_string($_POST['phone_number']);
        $patronymic = $mysqli->real_escape_string($_POST['patronymic']);
        $passport_number = intval($_POST['passport_number']);
        $passport_series = intval($_POST['passport_series']);

        $query = "INSERT INTO client (Name, Surname, phone_number, patronymic, Passport_number, Passport_series) 
                  VALUES ('$name', '$surname', '$phone_number', '$patronymic', $passport_number, $passport_series)";
        $message = executeQuery($query);
    }

    // Удаление клиента
    if (isset($_POST['delete_client'])) {
        $client_id = intval($_POST['client_id']);
        $query = "DELETE FROM client WHERE id = $client_id";
        $message = executeQuery($query);
    }

    // Сохранение изменений клиента
    if (isset($_POST['save_client'])) {
        $edit_client_id = intval($_POST['edit_client_id']);
        $name = $mysqli->real_escape_string($_POST['name']);
        $surname = $mysqli->real_escape_string($_POST['surname']);
        $phone_number = $mysqli->real_escape_string($_POST['phone_number']);
        $patronymic = $mysqli->real_escape_string($_POST['patronymic']);
        $passport_number = intval($_POST['passport_number']);
        $passport_series = intval($_POST['passport_series']);
        
        $query = "UPDATE client SET Name='$name', Surname='$surname', phone_number='$phone_number', patronymic='$patronymic', 
                  Passport_number=$passport_number, Passport_series=$passport_series WHERE id=$edit_client_id";
        $message = executeQuery($query);
    }



    // Аналогичные операции для типов услуг...
    // Добавление типа услуги
    if (isset($_POST['add_service_type'])) {
        $title = $mysqli->real_escape_string($_POST['title']);
        $query = "INSERT INTO type_of_service (Title) VALUES ('$title')";
        $message = executeQuery($query);
    }

    // Удаление типа услуги
    if (isset($_POST['delete_service_type'])) {
        $service_type_id = intval($_POST['service_type_id']);
        $query = "DELETE FROM type_of_service WHERE ID = $service_type_id";
        $message = executeQuery($query);
    }

    // Сохранение изменений типа услуги
    if (isset($_POST['save_service_type'])) {
        $edit_service_type_id = intval($_POST['edit_service_type_id']);
        $title = $mysqli->real_escape_string($_POST['title']);
        
        $query = "UPDATE type_of_service SET Title='$title' WHERE ID=$edit_service_type_id";
        $message = executeQuery($query);
    }


// Получение данных для отображения
$managers = $mysqli->query("SELECT * FROM Manager");
$cars = $mysqli->query("SELECT * FROM Car");
$clients = $mysqli->query("SELECT * FROM client");
$services = $mysqli->query("SELECT * FROM service");
$service_types = $mysqli->query("SELECT * FROM type_of_service");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница модератора</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
         .toggle-section {
            display: none; /* Скрываем все секции по умолчанию */
        }
        .active {
            display: block; /* Показываем активную секцию */
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background-image: url('photo/wallhaven-x6yzoz.jpg'); /* Укажите путь к вашему изображению */
            background-size: cover; /* Заставляет изображение занимать весь экран */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4; /* Светлый фон для всего тела */
            color: #333; /* Темный текст для лучшей читабельности */
            color: white; /* Устанавливает цвет текста по умолчанию на белый */
            transition: background-color 0.3s, color 0.3s; /* Плавный переход для темы */
       }
        .dark-theme {
            background-color: #2c3e50; /* Темный фон для темной темы */
            color: #ecf0f1; /* Светлый текст для темной темы */
        }
        .sidebar {
            width: 60px;
            background-color: #2c3e50; /* Темный фон боковой панели */
            position: fixed;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            transition: width 0.3s; /* Плавное изменение ширины */
        }
        .sidebar:hover {
            width: 200px; /* Ширина боковой панели при наведении */
        }
        .sidebar i {
            font-size: 24px;
            color: white; /* Белый цвет иконок */
            margin: 15px 0;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .sidebar i:hover {
            transform: scale(1.2); /* Увеличение иконки при наведении */
        }
        .content {
            margin-left: 80px; /* Отступ для основного контента */
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #2c3e50; /* Темный цвет заголовков */
        }
        button {
            background-color: #3498db; /* Цвет кнопок */
            color: white; /* Белый текст на кнопках */
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2980b9; /* Темнее при наведении */
        }
        .toggle-section {
            margin: 20px 0;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: none; /* Скрываем все секции по умолчанию */
            background-color: rgba(0, 0, 0, 0.7); /* Черный фон с 70% прозрачностью */
            border-radius: 10px; /* Закругление углов */
            padding: 20px; /* Внутренние отступы */
            margin-bottom: 20px; /* Отступ между секциями */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db; /* Цвет фона заголовков таблицы */
            color: white; /* Цвет текста заголовков таблицы */
        }
        tr:hover {
            background-color: #f1f1f1; /* Цвет строки при наведении */
        }
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .modal h2 {
            text-align: center;
            color: #2c3e50; /* Цвет заголовка модального окна */
        }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input:focus {
            border-color: #3498db; /* Цвет рамки при фокусе */
            outline: none; /* Убираем стандартный контур */
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 50px; /* Уменьшенная ширина для мобильных устройств */
            }
            .sidebar:hover {
                width: 150px; /* Ширина боковой панели при наведении на мобильных устройствах */
            }
            .content {
                margin-left: 60px; /* Отступ для основного контента на мобильных устройствах */
            }
        }
    </style>
    <script>
        function toggleSection(sectionId) {
            const sections = document.querySelectorAll('.toggle-section');
            sections.forEach(section => {
                section.classList.remove('active'); // Убираем класс active у всех секций
            });
            const selectedSection = document.getElementById(sectionId);
            selectedSection.classList.toggle('active'); // Показываем или скрываем выбранную секцию
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-theme');
        }

        // Загрузка страницы
        window.onload = function() {
            // Здесь можно добавить код, который будет выполняться при загрузке страницы, если нужно
        };
    
        function toggleSection(sectionId) {
            const sections = document.querySelectorAll('.toggle-section');
            sections.forEach(section => {
                section.classList.remove('active'); // Убираем класс active у всех секций
            });
            document.getElementById(sectionId).classList.add('active'); // Добавляем класс active только к выбранной секции
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-theme');
        }
        function toggleSection(sectionId) {
            const sections = document.querySelectorAll('.toggle-section');
            sections.forEach(section => {
                section.style.display = 'none'; // Скрываем все секции
            });
            document.getElementById(sectionId).style.display = 'block'; // Показываем выбранную секцию
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-theme');
        }
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
        }
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
        }
        function toggleTheme() {
            document.body.classList.toggle('dark-theme');
        }
        function validateForm(form) {
            // Пример валидации: проверка на пустые поля
            const inputs = form.querySelectorAll('input');
            for (let input of inputs) {
                if (!input.value) {
                    alert('Пожалуйста, заполните все поля.');
                    return false;
                }
            }
            return true;
        }
        // Открытие модальных окон
        function openEditManagerModal(id, name, surname, phone_number, patronymic) {
            document.getElementById('edit_manager_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_surname').value = surname;
            document.getElementById('edit_phone_number').value = phone_number;
            document.getElementById('edit_patronymic').value = patronymic;
            document.getElementById('editManagerModal').style.display = 'flex';
        }
        function closeEditManagerModal() {
            document.getElementById('editManagerModal').style.display = 'none';
        }
        function openEditCarModal(id, brand, colour, className, hp, cost_rent, rental_price, car_fund, release_date) {
            document.getElementById('edit_car_id').value = id;
            document.getElementById('edit_brand').value = brand;
            document.getElementById('edit_colour').value = colour;
            document.getElementById('edit_class').value = className;
            document.getElementById('edit_hp').value = hp;
            document.getElementById('edit_cost_rent').value = cost_rent;
            document.getElementById('edit_rental_price').value = rental_price;
            document.getElementById('edit_car_fund').value = car_fund;
            document.getElementById('edit_release_date').value = release_date;
            document.getElementById('editCarModal').style.display = 'flex';
        }
        function closeEditCarModal() {
            document.getElementById('editCarModal').style.display = 'none';
        }
        function openEditClientModal(id, name, surname, phone_number, patronymic, passport_number, passport_series) {
            document.getElementById('edit_client_id').value = id;
            document.getElementById('edit_client_name').value = name;
            document.getElementById('edit_client_surname').value = surname;
            document.getElementById('edit_client_phone_number').value = phone_number;
            document.getElementById('edit_client_patronymic').value = patronymic;
            document.getElementById('edit_client_passport_number').value = passport_number;
            document.getElementById('edit_client_passport_series').value = passport_series;
            document.getElementById('editClientModal').style.display = 'flex';
        }
        function closeEditClientModal() {
            document.getElementById('editClientModal').style.display = 'none';
        }
        function openEditServiceModal(id, booking_date, date_of_issue, date_of_delivery, date_planned_date, ID_service, id_client, id_auto, id_manager) {
            document.getElementById('edit_service_id').value = id;
            document.getElementById('edit_booking_date').value = booking_date;
            document.getElementById('edit_date_of_issue').value = date_of_issue;
            document.getElementById('edit_date_of_delivery').value = date_of_delivery;
            document.getElementById('edit_date_planned_date').value = date_planned_date;
            document.getElementById('edit_service_ID_service').value = ID_service;
            document.getElementById('edit_service_id_client').value = id_client;
            document.getElementById('edit_service_id_auto').value = id_auto;
            document.getElementById('edit_service_id_manager').value = id_manager;
            document.getElementById('editServiceModal').style.display = 'flex';
        }
        function closeEditServiceModal() {
            document.getElementById('editServiceModal').style.display = 'none';
        }
        function openEditServiceTypeModal(id, title) {
            document.getElementById('edit_service_type_id').value = id;
            document.getElementById('edit_service_type_title').value = title;
            document.getElementById('editServiceTypeModal').style.display = 'flex';
        }
        function closeEditServiceTypeModal() {
            document.getElementById('editServiceTypeModal').style.display = 'none';
        }
    </script>
</head>
</head>
<body>
<div class="sidebar">
        <a href="index.php" title="Главная">
            <i class="fas fa-home"></i>
        </a>
        <i class="fas fa-users" title="Менеджеры" onclick="toggleSection('managers_section')"></i>
        <i class="fas fa-car" title="Автомобили" onclick="toggleSection('cars_section')"></i>
        <i class="fas fa-user" title="Клиенты" onclick="toggleSection('clients_section')"></i>
        <i class="fas fa-concierge-bell" title="Услуги" onclick="toggleSection('services_section')"></i>
        <i class="fas fa-cogs" title="Типы услуг" onclick="toggleSection('service_types_section')"></i>
        <i class="fas fa-adjust" title="Темная тема" onclick="toggleTheme()"></i>
    </div>
    <div class="content">
        <h1>Управление записями</h1>

               <!-- Секция для менеджеров -->
               <div id="managers_section" class="toggle-section">
            <h2>
                <button onclick="toggleSection('add_manager_section')">Добавление менеджера</button>
            </h2>
            <div id="add_manager_section" class="toggle-section">
                <form method="post" onsubmit="return validateForm(this);">
                    <label for="name">Имя:</label>
                    <input type="text" name="name" placeholder="Имя" maxlength="30" required>
                    <br>
                    <label for="surname">Фамилия:</label>
                    <input type="text" name="surname" placeholder="Фамилия" maxlength="30" required>
                    <br>
                    <label for="phone_number">Телефон:</label>
                    <input type="text" name="phone_number" placeholder="Телефон" maxlength="11" required>
                    <br>
                    <label for="patronymic">Отчество:</label>
                    <input type="text" name="patronymic" placeholder="Отчество" maxlength="40" required>
                    <br>
                    <button type="submit" name="add_manager">Добавить</button>
                </form>
            </div>
        

            <h2>
                <button onclick="toggleSection('managers_table')">Менеджеры</button>
            </h2>
            <div id="managers_table" class="toggle-section">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Телефон</th>
                        <th>Отчество</th>
                        <th>Действия</th>
                    </tr>
                    <?php while ($row = $managers->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['ID'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['Surname'] ?></td>
                            <td><?= $row['phone_number'] ?></td>
                            <td><?= $row['patronymic'] ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="manager_id" value="<?= $row['ID'] ?>">
                                    <button type="submit" name="delete_manager" onclick="return confirm('Вы уверены, что хотите удалить этого менеджера?')">Удалить</button>
                                </form>
                                <button onclick="openEditManagerModal(<?= $row['ID'] ?>, '<?= $row['Name'] ?>', '<?= $row['Surname'] ?>', '<?= $row['phone_number'] ?>', '<?= $row['patronymic'] ?>')">Редактировать</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>

        <div id="cars_section" class="toggle-section">
            <h2>
                <button onclick="toggleSection('add_car_section')">Добавление автомобиля</button>
            </h2>
            <div id="add_car_section" class="toggle-section">
                <form method="post" onsubmit="return validateForm(this);">
                    <label for="brand">Марка:</label>
                    <input type="text" name="brand" placeholder="Марка" maxlength="30" required>
                    <br>
                    <label for="colour">Цвет:</label>
                    <input type="text" name="colour" placeholder="Цвет" maxlength="30" required>
                    <br>
                    <label for="class">Класс:</label>
                    <input type="text" name="class" placeholder="Класс" maxlength="30" required>
                    <br>
                    <label for="hp">Лошадиные силы:</label>
                    <input type="number" name="hp" placeholder="Лошадиные силы" required>
                    <br>
                    <label for="cost_rent">Стоимость аренды:</label>
                    <input type="number" name="cost_rent" placeholder="Стоимость аренды" step="0.01" required>
                    <br>
                    <label for="rental_price">Цена аренды:</label>
                    <input type="number" name="rental_price" placeholder="Цена аренды" step="0.01" required>
                    <br>
                    <label for="car_fund">Фонд автомобиля:</label>
                    <input type="number" name="car_fund" placeholder="Фонд автомобиля" required>
                    <br>
                    <label for="release_date">Дата выпуска:</label>
                    <input type="date" name="release_date" required>
                    <br>
                    <button type="submit" name="add_car">Добавить</button>
                </form>
            </div>

            <h2>
                <button onclick="toggleSection('cars_table')">Автомобили</button>
            </h2>
            <div id="cars_table" class="toggle-section">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Марка</th>
                        <th>Цвет</th>
                        <th>Класс</th>
                        <th>Лошадиные силы</th>
                        <th>Стоимость аренды</th>
                        <th>Цена аренды</th>
                        <th>Фонд автомобиля</th>
                        <th>Дата выпуска</th>
                        <th>Действия</th>
                    </tr>
                    <?php while ($row = $cars->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ID'] ?></td>
                        <td><?= $row['Brand'] ?></td>
                        <td><?= $row['Colour'] ?></td>
                        <td><?= $row['Class'] ?></td>
                        <td><?= $row['HP'] ?></td>
                        <td><?= $row['Cost_rent'] ?></td>
                        <td><?= $row['rental_price'] ?></td>
                        <td><?= $row['Car_Fund'] ?></td>
                        <td><?= $row['Release_date'] ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="car_id" value="<?= $row['ID'] ?>">
                                <button type="submit" name="delete_car" onclick="return confirm('Вы уверены, что хотите удалить этот автомобиль?')">Удалить</button>
                            </form>
                            <button onclick="openEditCarModal(<?= $row['ID'] ?>, '<?= $row['Brand'] ?>', '<?= $row['Colour'] ?>', '<?= $row['Class'] ?>', <?= $row['HP'] ?>, <?= $row['Cost_rent'] ?>, <?= $row['rental_price'] ?>, <?= $row['Car_Fund'] ?>, '<?= $row['Release_date'] ?>')">Редактировать</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>

       <!-- Секция для клиентов -->
       <div id="clients_section" class="toggle-section">
            <h2>
                <button onclick="toggleSection('add_client_section')">Добавление клиента</button>
            </h2>
            <div id="add_client_section" class="toggle-section">
                <form method="post" onsubmit="return validateForm(this);">
                    <label for="name">Имя:</label>
                    <input type="text" name="name" placeholder="Имя" maxlength="30" required>
                    <br>
                    <label for="surname">Фамилия:</label>
                    <input type="text" name="surname" placeholder="Фамилия" maxlength="30" required>
                    <br>
                    <label for="phone_number">Телефон:</label>
                    <input type="text" name="phone_number" placeholder="Телефон" maxlength="11" required>
                    <br>
                    <label for="patronymic">Отчество:</label>
                    <input type="text" name="patronymic" placeholder="Отчество" maxlength="40" required>
                    <br>
                    <label for="passport_number">Номер паспорта:</label>
                    <input type="number" name="passport_number" placeholder="Номер паспорта" required>
                    <br>
                    <label for="passport_series">Серия паспорта:</label>
                    <input type="number" name="passport_series" placeholder="Серия паспорта" required>
                    <br>
                    <button type="submit" name="add_client">Добавить</button>
                </form>
            </div>

            <h2>
                <button onclick="toggleSection('clients_table')">Клиенты</button>
            </h2>
            <div id="clients_table" class="toggle-section">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Телефон</th>
                        <th>Отчество</th>
                        <th>Номер паспорта</th>
                        <th>Серия паспорта</th>
                        <th>Действия</th>
                    </tr>
                    <?php while ($row = $clients->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['Surname'] ?></td>
                            <td><?= $row['phone_number'] ?></td>
                            <td><?= $row['patronymic'] ?></td>
                            <td><?= $row['Passport_number'] ?></td>
                            <td><?= $row['Passport_series'] ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="client_id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete_client" onclick="return confirm('Вы уверены, что хотите удалить этого клиента?')">Удалить</button>
                                </form>
                                <button onclick="openEditClientModal(<?= $row['id'] ?>, '<?= $row['Name'] ?>', '<?= $row['Surname'] ?>', '<?= $row['phone_number'] ?>', '<?= $row['patronymic'] ?>', <?= $row['Passport_number'] ?>, <?= $row['Passport_series'] ?>)">Редактировать</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>

       

        <!-- Секция для типов услуг -->
        <div id="service_types_section" class="toggle-section">
            <h2>
                <button onclick="toggleSection('add_service_type_section')">Добавление типа услуги</button>
            </h2>
            <div id="add_service_type_section" class="toggle-section">
                <form method="post" onsubmit="return validateForm(this);">
                    <label for="title">Название услуги:</label>
                    <input type="text" name="title" placeholder="Название услуги" maxlength="50" required>
                    <br>
                    <button type="submit" name="add_service_type">Добавить</button>
                </form>
            </div>

            <h2>
                <button onclick="toggleSection('service_types_table')">Типы услуг</button>
            </h2>
            <div id="service_types_table" class="toggle-section">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Название услуги</th>
                        <th>Действия</th>
                    </tr>
                    <?php while ($row = $service_types->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ID'] ?></td>
                        <td><?= $row['Title'] ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="service_type_id" value="<?= $row['ID'] ?>">
                                <button type="submit" name="delete_service_type" onclick="return confirm('Вы уверены, что хотите удалить этот тип услуги?')">Удалить</button>
                            </form>
                            <button onclick="openEditServiceTypeModal(<?= $row['ID'] ?>, '<?= $row['Title'] ?>')">Редактировать</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>