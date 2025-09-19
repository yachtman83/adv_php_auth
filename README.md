# Advanced PHP Authentication

Учебный проект на PHP с авторизацией, регистрацией и защитой с помощью капчи.  
Используется PostgreSQL в качестве базы данных.

## 🚀 Возможности

- Регистрация пользователей (username, email, телефон, пароль)
- Вход по email или телефону
- Проверка уникальности данных при регистрации
- Изменение профиля (имя, email, телефон)
- Смена пароля с проверкой старого
- Flash-сообщения для ошибок и уведомлений
- Капча (поддержка Яндекс SmartCaptcha)
- Безопасное хранение паролей

## 🛠️ Установка и запуск

1. Склонировать репозиторий:

   ```bash
   git clone https://github.com/yachtman83/adv_php_auth.git
   cd adv_php_auth

2. Создайте базу данных PostgreSQL и примените SQL-скрипт для структуры таблиц (пример в database.sql).
   ```sql
   CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    phonenum INT(20) NOT NULL UNIQUE,
    password TEXT NOT NULL
);

3. Скопируйте файл примера конфига:
   ```bash
   cp config/config.example.php config/config.php
4. Укажите в config/config.php свои данные:
   ```php
   return [
    'host' => 'localhost',
    'port' => '5432',
    'dbname' => 'testdb',
    'user' => 'postgres',
    'password' => 'your_password',

    // yandex captcha
    'yandex_captcha_server_key' => 'your_server_key',
    'yandex_captcha_client_key' => 'your_client_key'
];
5. Запустите проект локально (например, через OpenServer) и откройте в браузере:
  ```bash
http://localhost/phpauth/controllers/login.php


## ⚙️ Требования

- PHP 8.x
- PostgreSQL 12+

