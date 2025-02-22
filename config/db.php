<?php
// config/db.php


$host = 'crossover.proxy.rlwy.net'; // Хост из Railway (через прокси)
$port = '45546';                     
$dbname = 'railway';                 
$user = 'postgres';                  // Имя пользователя (из строки подключения)
$password = 'ggiacPLtVMbXVGDDOglcDbQnBetsLZZX'; // Пароль из Railway


try {

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Успешное подключение к базе данных!";

    //$pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
