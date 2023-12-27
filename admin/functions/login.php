<?php
session_start();
require_once 'connect.php';

$login = $_POST['login'] ?? null;
// Получаем пароль и хешируем его с помощью bcrypt
$password = $_POST['password'] ?? null;
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Подготавливаем запрос без пароля
$sql = $pdo->prepare("SELECT id, login, password FROM admin WHERE login=:login");
$sql->execute(['login' => $login]);
$array = $sql->fetch(PDO::FETCH_ASSOC);

// Проверяем, есть ли пользователь и совпадает ли пароль
if ($array && password_verify($password, $array['password'])) {
    $_SESSION["login"] = $array["login"];
    echo '<meta HTTP-EQUIV="Refresh" Content="0; URL=../panel.php">';
} else {
    echo '<meta HTTP-EQUIV="Refresh" Content="0; URL=../">';
}
?>
