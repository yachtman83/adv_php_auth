<?php
session_start();
require_once __DIR__ . "/../app/db_connect.php";
require_once __DIR__ . "/../helpers/captcha.php";
$config = require __DIR__ . "/../config/config.php";

$errors = [];

if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['smart-token'] ?? null;
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);

    if (!$token || !check_captcha($token, $config)) {
        $errors[] = "Ошибка: не пройдена проверка капчи";
    }

    if (empty($login) || empty($password)) {
        $errors[] = "Заполните все поля";
    }

    if (empty($errors)) {
        $validLogin = false;

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $validLogin = true;
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :login");
        } elseif (is_numeric($login)) {
            $validLogin = true;
            $stmt = $pdo->prepare("SELECT * FROM users WHERE phonenum = :login");
        }

        if (!$validLogin) {
            $errors[] = "Неверный формат логина. Используйте email или номер телефона.";
        } else {
            $stmt->execute([":login" => $login]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: profile.php");
                exit;
            } else {
                $errors[] = "Неверный логин или пароль";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['flash_errors'] = $errors;
        header("Location: login.php");
        exit;
    }
}

require "../views/login_view.php";
