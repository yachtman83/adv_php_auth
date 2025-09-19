<?php

session_start();
require_once __DIR__ . "/../app/db_connect.php";



$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["name"]);
    $phonenum = trim($_POST["phonenum"]);
    $email    = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($username) || empty($phonenum) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "Заполните все поля!";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Пароли не совпадают";
    }

    if (empty($errors)) {

        try {
            $stmt = $pdo->prepare("SELECT username, email, phonenum FROM users WHERE username =:username OR email = :email OR phonenum = :phonenum LIMIT 1");
            $stmt->execute([
                ":username" => $username,
                ":email" => $email,
                ":phonenum" => $phonenum
            ]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                if (isset($existing['username']) && $existing['username'] === $username) {
                    $errors[] = "Имя пользователя уже занято!";
                } elseif (isset($existing['email']) && $existing['email'] === $email) {
                    $errors[] = "Email уже зарегистрирован!";
                } elseif (isset($existing['phonenum']) && $existing['phonenum'] == $phonenum) {
                    $errors[] = "Телефон уже зарегистрирован!";
                }
            }
            
        } catch (PDOException $e) {
            $errors[] = "Ошибка при проверке уникальности";
        }
    }
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, phonenum, email, password) VALUES (:username, :phonenum, :email, :password)");
            $stmt->execute([
                ":username" => $username,
                ":phonenum" => $phonenum,
                ":email" => $email,
                ":password" => $hashedPassword
            ]);
            header("location: login.php");
            exit; 
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                $errors[] = "Пользователь с таким логином, email или телефоном уже существует!";
            } else {
                $errors[] = "Ошибка при сохранении данных. Попробуйте позже.";
            }
        }
    } 
    if (!empty($errors)) {
        $_SESSION['flash_errors'] = $errors;
        header("Location: register.php");
        exit;
    }
}
require_once __DIR__ . "/../views/register_view.php";