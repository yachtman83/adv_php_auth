<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Авторизация</h1>
        <form action="../controllers/login.php" method="POST">
            <p>Логин: <input type="text" name="login" required placeholder="номер или email "> </p>
            <p>Пароль: <input type="password" name="password" required> </p>
            <div
                id="captcha-container"
                class="smart-captcha"
                data-sitekey="<?= $config['yandex_captcha_client_key'] ?>"
            ></div>


            <button type="submit">Войти</button>
            <button type="button" onclick="window.location.href='../controllers/register.php'">Зарегистрироваться</button>
        </form>
        <?php
        session_start();
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']); // очищаем после вывода
        ?>
        <?php if (!empty($errors)): ?>
            <div class="error-messages" style="color: red;">
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