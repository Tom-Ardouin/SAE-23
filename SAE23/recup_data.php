<?php
// Connexion MySQL
$host = 'localhost';
$user = 'sae23PA';
$password = 'passroot';
$dbname = 'sae23';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

// Récupération du message MQTT (1 message uniquement)
$json = shell_exec("mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/E104/data -C 1");

// Vérifie si du contenu a été reçu
if (empty($json)) {
    die("Aucun message reçu depuis le broker MQTT.");
}

$data = json_decode($json, true);
if (!$data) {
    die("Erreur de décodage JSON.");
}

// Affiche le contenu pour vérification
echo "<pre>"; print_r($data); echo "</pre>";

// Extraire les infos
$nomSalle = $data["room"];
$date = date('Y-m-d');
$heure = date('H:i:s');

// Capteurs attendus
$capteurs = [
    "temperature" => "°C",
    "humidity" => "%",
    "activity" => "",
    "co2" => "ppm",
    "tvoc" => "ppb",
    "illumination" => "lux",
    "infrared" => "",
    "infrared_and_visible" => "",
    "pressure" => "hPa"
];

// 1. Insérer la salle si elle n'existe pas
$conn->query("INSERT IGNORE INTO Salle (NOM_SA) VALUES ('$nomSalle')");

// 2. Insérer les capteurs et les mesures
foreach ($capteurs as $type => $unite) {
    if (!isset($data[$type])) continue;

    $valeur = $data[$type];
    $nomCapteur = $type . "_" . $nomSalle;

    // Ajouter le capteur si inexistant
    $conn->query("INSERT IGNORE INTO Capteur (NOM_CAPT, TYPE_CAPT, UNITE, SALLE) 
                  VALUES ('$nomCapteur', '$type', '$unite', '$nomSalle')");

    // Insérer la mesure
    $conn->query("INSERT INTO Mesure (Date_MESU, HOR, VAL, CAPT)
                  VALUES ('$date', '$heure', $valeur, '$nomCapteur')");
}

echo " Mesures insérées avec succès.";
$conn->close();
?>
