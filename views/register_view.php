<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Регистрация</h1>

        <form action="../controllers/register.php" method="POST">
            <p>Имя: <input type="text" name="name" required></p>
            <p>Телефон: <input type="number" name="phonenum" required></p>
            <p>Почта: <input type="email" name="email" required></p>
            <p>Пароль: <input type="password" name="password" required></p>
            <p>Повторите пароль: <input type="password" name="confirm_password" required></p>

            <button type="submit">Зарегистрироваться</button>
            <button type="button" onclick="window.location.href='../controllers/login.php'">Назад</button>
        </form>

        <?php
        session_start();
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);
        ?>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
