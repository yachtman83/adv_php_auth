<?php
session_start();
require_once __DIR__ . "/../app/db_connect.php";

$errors = [];

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current  = trim($_POST['current_password']);
    $new      = trim($_POST['new_password']);
    $confirm  = trim($_POST['confirm_password']);
    if (empty($current) || empty($new) || empty($confirm)) {
        $errors[] = "Все поля обязательны";
    } elseif ($new !== $confirm) {
        $errors[] = "пароли не совпадают.";
    } else {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id=:id");
        $stmt->execute([':id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current, $user['password'])) {
            $errors[] = "Неверный старый пароль";
            
        } else {
            $newHash = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password=:pw WHERE id=:id");
            $stmt->execute([
                ':pw' => $newHash,
                ':id' => $_SESSION['user_id']
            ]);
            header("Location: profile.php");
            exit;
        }
    }
     if (!empty($errors)) {
        $_SESSION['flash_errors_pw'] = $errors;
        header("Location: profile.php");
        exit;
    }
}
require __DIR__ . "/../views/profile_view.php";