<?php
session_start();

// Получаем ошибки и сразу удаляем из сессии
$errorsProfile  = $_SESSION['flash_errors_pf']  ?? [];
unset($_SESSION['flash_errors_pf']);

$errorsPassword = $_SESSION['flash_errors_pw'] ?? [];
unset($_SESSION['flash_errors_pw']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Привет, <?= htmlspecialchars($user['username']) ?></h1>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <p>Телефон: <?= htmlspecialchars($user['phonenum']) ?></p>

        <form action="../controllers/update_profile.php" method="post">
            <p>Имя:<input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"></p>
            <p>Email:<input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></p>
            <p>Телефон:<input type="text" name="phonenum" value="<?= htmlspecialchars($user['phonenum']) ?>"></p>
            <button type="submit">Сохранить</button>

            <?php if (!empty($errorsProfile)): ?>
                <div class="error-messages">
                    <ul>
                        <?php foreach ($errorsProfile as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </form>

        <br>

        <form action="../controllers/change_password.php" method="post">
            <p>Старый пароль:<input type="password" name="current_password"></p>
            <p>Новый пароль:<input type="password" name="new_password"></p>    
            <p>Повторите новый пароль:<input type="password" name="confirm_password"></p>
            <button type="submit">Сохранить</button>

            <?php if (!empty($errorsPassword)): ?>
                <div class="error-messages">
                    <ul>
                        <?php foreach ($errorsPassword as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </form>

        <form action="../controllers/logout.php" method="post">
            <button type="submit" style="margin-top: 20px;">Выйти</button>
        </form>
    </div>
</body>
</html>
