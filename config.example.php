<?php
// Скопіюйте цей файл як config.php та заповніть значення.
// config.php у gitignore — не комітьте секрети.

return [
    // Telegram Bot API. Створіть бота через @BotFather, отримайте token.
    // chat_id отримати: написати боту → https://api.telegram.org/bot<TOKEN>/getUpdates
    // Можна задати кілька chat_id через кому для дублювання.
    'telegram' => [
        'enabled'  => true,
        'token'    => 'YOUR_BOT_TOKEN_HERE',
        'chat_ids' => ['123456789'],
    ],

    // Email-дублювання (через PHP mail() — на Hostinger працює з власного домену).
    'email' => [
        'enabled' => true,
        'to'      => ['hello@axiom-technology.eu'],
        'from'    => 'no-reply@axiom-technology.eu',
        'subject' => 'Нова заявка з axiom-technology.eu',
    ],

    // Опціонально: лог-файл заявок (можна для backup, якщо телеграм/пошта впадуть).
    'log' => [
        'enabled' => true,
        'path'    => __DIR__ . '/leads/leads.log',
    ],

    // Анти-спам: мінімальна тривалість заповнення форми (секунди).
    'min_form_time' => 2,
];
