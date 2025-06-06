<?php
include 'includes/db.php'; // Connexion MySQL

// 1. Récupérer un message JSON depuis le broker MQTT
$json = shell_exec("mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/E104/data -C 1");
$data = json_decode($json, true);

// 2. Vérification du format
if (!$data || !isset($data[0], $data[1])) {
    die(" Format JSON incorrect ou message vide.");
}

$mesures = $data[0];
$infos = $data[1];

// 3. Données de référence
$date = date('Y-m-d');
$heure = date('H:i:s');

$batiment = $conn->real_escape_string($infos["Building"]);
$etage = (int) $infos["floor"];
$salle = $conn->real_escape_string($infos["room"]);

// 4. Insérer le bâtiment s'il n'existe pas
$conn->query("INSERT IGNORE INTO Batiment (NOM_BAT) VALUES ('$batiment')");

// 5. Insérer la salle
$conn->query("INSERT IGNORE INTO Salle (NOM_SA, ETAGE, BATIMENT) VALUES ('$salle', $etage, '$batiment')");

// 6. Capteurs à gérer
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

// 7. Boucle : un capteur = un enregistrement
foreach ($capteurs as $type => $unite) {
    if (!isset($mesures[$type])) continue;
    $valeur = $mesures[$type];
    $nomCapteur = $type . "_" . $salle;

    // Ajouter le capteur
    $conn->query("INSERT IGNORE INTO Capteur (NOM_CAPT, TYPE_CAPT, UNITE, SALLE)
                  VALUES ('$nomCapteur', '$type', '$unite', '$salle')");

    // Ajouter la mesure
    $conn->query("INSERT INTO Mesure (Date_MESU, HOR, VAL, CAPT)
                  VALUES ('$date', '$heure', $valeur, '$nomCapteur')");
}

echo " Données insérées avec succès.\n";
?>
