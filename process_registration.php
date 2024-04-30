<?php
// Подключение к базе данных
$mysqli = new mysqli("localhost", "root", "", "cyrs");

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка соединения с базой данных: " . $conn->connect_error);
}

// Получение данных из формы
$name = $_POST['name'];
$surname = $_POST['surname'];
$tel_number = $_POST['tel_number'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];

// Хеширование пароля
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Подготовка запроса
$stmt = $conn->prepare("INSERT INTO students (name, surname, tel_number, email, login, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $surname, $tel_number, $email, $login, $hashed_password);

// Выполнение запроса
$stmt->execute();

// Закрытие запроса и соединения
$stmt->close();
$conn->close();

// Перенаправление на страницу входа
header("Location: login_form.html");
?>


