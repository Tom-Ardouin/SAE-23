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

// Récupérer un message JSON via MQTT
$json = shell_exec("mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/E104/data -C 1");

// Vérification du contenu
if (empty($json)) {
    die("Aucun message MQTT reçu.");
}

$data = json_decode($json, true); // true = tableau associatif
if (!$data || !isset($data[0], $data[1])) {
    print_r($data);
    die("Format JSON incorrect ou incomplet.");
}

// Extraction des données
$mesures = $data[0];
$infos = $data[1];

if (!isset($infos["room"])) {
    die("Champ 'room' manquant dans le JSON.");
}

$nomSalle = $infos["room"];
$date = date('Y-m-d');
$heure = date('H:i:s');

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

// Insérer la salle si elle n’existe pas
$conn->query("INSERT IGNORE INTO Salle (NOM_SA) VALUES ('$nomSalle')");

// Pour chaque capteur, insérer les infos
foreach ($capteurs as $nom => $unite) {
    if (!isset($mesures[$nom])) continue;
    $valeur = $mesures[$nom];
    $nomCapteur = $nom . "_" . $nomSalle;

    // Capteur
    $conn->query("INSERT IGNORE INTO Capteur (NOM_CAPT, TYPE_CAPT, UNITE, SALLE) 
                  VALUES ('$nomCapteur', '$nom', '$unite', '$nomSalle')");

    // Mesure
    $conn->query("INSERT INTO Mesure (Date_MESU, HOR, VAL, CAPT) 
                  VALUES ('$date', '$heure', $valeur, '$nomCapteur')");
}

echo " Données insérées avec succès.";
$conn->close();
?>
