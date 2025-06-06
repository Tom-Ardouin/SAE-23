<?php
$conn = new mysqli("localhost", "sae23PA", "passroot", "sae23");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>