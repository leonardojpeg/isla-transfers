<?php

$env = parse_ini_file(__DIR__ . '/../.env');

$host = $env['DB_HOST'];
$db = $env['DB_NAME'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];
$port = $env['DB_PORT'];
$charset = 'utf8mb4';


    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=$charset", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Conexión correcta";
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }

?>