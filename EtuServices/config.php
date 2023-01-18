<?php
$server = "localhost";
$bd = "EtuServices";
$user = "root";
$mdp = "root";

try {
    $conn = new PDO("mysql:host=$server;dbname=$bd;charset=utf8", $user, $mdp);
} catch (PDOException $e) {
    printf("Échec de la connexion : %s\n", $e->getMessage());
    exit();
}