
<?php

$DB_DSN = 'mysql:host=localhost;dbname=squid_game;charset=utf8mb4';
$DB_USER = 'root';
$DB_PASS = '';

$options =[
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
];

try {

    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);
}
catch(PDOException $pe){
     die("Erreur de connexion à la base de données : " . $pe->getMessage());
}