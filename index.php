<?php

error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');

$root = __DIR__ . DIRECTORY_SEPARATOR;

define("SUBDOMAIN", "domain"); #Наш аккаунт - поддомен

require $root . 'prepare.php'; #Здесь будут производиться подготовительные действия, объявления функций и т.д.
require $root . 'auth.php'; #Здесь будет происходить авторизация пользователя
require $root . 'leads_list.php'; #Получим информацию о сделках без задач
require $root . 'task_add.php'; #Добавляем каждой сделке новую задачу с текстом “Сделка без задачи”

$idLeadsNoTask = getIdLeadsNoTask();

$result = addTask($idLeadsNoTask);

print_r($result);


