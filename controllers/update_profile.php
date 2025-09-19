<?php
session_start();
require_once __DIR__ . "/../app/db_connect.php";

$errors = [];

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $phonenum = trim($_POST['phonenum']);
    $email    = trim($_POST['email']);

    if (!empty($username) && !empty($phonenum) && !empty($email)) {

        $stmt = $pdo->prepare("
            SELECT id, username, email, phonenum 
            FROM users 
            WHERE (username = :username OR email = :email OR phonenum = :phonenum)
            AND id != :id
            LIMIT 1
        ");
        $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':phonenum' => $phonenum,
            ':id'       => $_SESSION['user_id']
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
        } elseif (empty($errors)) {
            $stmt = $pdo->prepare("UPDATE users SET username=:username, phonenum=:phonenum, email=:email WHERE id=:id");
            $stmt->execute([
                ':username' => $username,
                ':phonenum' => $phonenum,
                ':email'    => $email,
                ':id'       => $_SESSION['user_id']
            ]);
            header("Location: profile.php");
            exit;
        }

    } else {
        $errors[] = "Нельзя оставлять поля пустыми";
    }

     if (!empty($errors)) {
        $_SESSION['flash_errors_pf'] = $errors;
        header("Location: profile.php");
        exit;
    }
}
require __DIR__ . "/../views/profile_view.php";
