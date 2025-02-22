<?php
// config/db.php

$host = 'crossover.proxy.rlwy.net';
$port = '45546';                     
$dbname = 'railway';                 
$user = 'postgres';                  
$password = 'ggiacPLtVMbXVGDDOglcDbQnBetsLZZX';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
