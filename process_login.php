<?php
session_start();
// Подключение к базе данных
$mysqli = new mysqli("localhost", "root", "", "cyrs");

// Проверка подключения
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Получение данных из формы
$login = $_POST['login'];
$password = $_POST['password'];

echo "Login: " . $login . "<br>";
echo "Password: " . $password . "<br>";

// Подготовленный запрос для проверки авторизации студента
$stmt_student = $mysqli->prepare("SELECT * FROM clin WHERE login = ?");
$stmt_student->bind_param("s", $login);
$stmt_student->execute();
$result_student = $stmt_student->get_result();

echo "Student rows: " . $result_student->num_rows . "<br>";

// Проверка наличия студента в базе данных
if ($result_student->num_rows == 1) {
    // Получаем данные студента
    $row_student = $result_student->fetch_assoc();
    $hashed_password_student = $row_student['password'];

    echo "Student hashed password: " . $hashed_password_student . "<br>";

    // Проверяем введенный пароль с хэшированным паролем из базы данных
    if (password_verify($password, $hashed_password_student)) {

       
        $_SESSION['login'] = $login;
        header('Location: index.html');
        exit;
    } else {
        // Пароль неверный
        echo "Неправильный пароль для студента<br>";
        exit;
    }
}


// Если логин не найден ни среди студентов, ни среди учителей
echo "Неправильный логин или пароль<br>";
exit;

// Закрытие подключения
$stmt_student->close();
$mysqli->close();
?>
