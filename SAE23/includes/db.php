<?php
// Configuration InfluxDB
$influx_host = 'http://localhost:8086';
$token = 'TON_TOKEN_ICI';
$org = 'TON_ORG';
$bucket = 'sae23';

// Requête d'exemple (lecture) :
function getLastMeasurements($capteur) {
    global $influx_host, $token, $org, $bucket;

    $query = "from(bucket: \"$bucket\") 
              |> range(start: -1h) 
              |> filter(fn: (r) => r[\"_measurement\"] == \"mesure\" and r[\"capteur\"] == \"$capteur\") 
              |> last()";

    $url = "$influx_host/api/v2/query?org=$org";

    $headers = [
        "Authorization: Token $token",
        "Content-Type: application/vnd.flux",
        "Accept: application/csv"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    if(curl_errno($ch)) {
        echo "Erreur cURL: " . curl_error($ch);
    }
    curl_close($ch);

    return $result;
}
?>