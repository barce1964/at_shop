<?php
    //FRONT CONTROLLER

    //Общие настройки

    // $string = '17-01-2021';
    // $pattern = '/([0-9]{2})-([0-9]{2})-([0-9]{4})/';
    // $replacement = 'Год: $3, месяц: $2, день: $1';
    // echo preg_replace($pattern, $replacement, $string);

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //Подключение файлов системы

    define('ROOT', dirname(__FILE__));
    require_once(ROOT . '/components/Router.php');

    //Установка соединения с БД

    //Вызов Router
    $router = new Router();
    $router->run();
?>