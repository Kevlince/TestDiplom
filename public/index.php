<?php

use App\Core\Database;

require __DIR__.'/../vendor/autoload.php';

// Инициализация
$config = require '../config/db.php';
$db = new Database($config);

// Регистрация маршрутов
$router = new Router();
require '../modules/Student/routes.php';
require '../modules/Topic/routes.php';

// Запуск
$router->dispatch(Request::method(), Request::uri());