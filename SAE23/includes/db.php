<?php
$host = 'localhost';          // Serveur MySQL
$db   = 'sae23';              // Nom de la base de données
$user = 'sae23PA';               // Nom d'utilisateur
$pass = 'passroot';                   // Mot de passe
$charset = 'utf8mb4';         // Jeu de caractères

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
