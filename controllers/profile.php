<?php
session_start();
require_once __DIR__ . "/../app/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT username, email, phonenum FROM users WHERE id=:id");
$stmt->execute([':id'=>$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

require __DIR__ . "/../views/profile_view.php";