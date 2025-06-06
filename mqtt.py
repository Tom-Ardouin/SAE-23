import paho.mqtt.client as mqtt
import mysql.connector
import json
from datetime import datetime

# Connexion à la base MySQL
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="sae23"
)
cursor = db.cursor()

# Quand un message est reçu
def on_message(client, userdata, message):
    try:
        payload = message.payload.decode()
        print(f"Message reçu sur {message.topic} : {payload}")

        # Exemple de format JSON attendu :
        # {"capteur": "temp_salle1", "valeur": 23.5}
        data = json.loads(payload)

        capteur = data["capteur"]
        valeur = float(data["valeur"])
        date_mesu = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

        sql = "INSERT INTO Mesure (CAPT, VAL, DATE_MESU) VALUES (%s, %s, %s)"
        cursor.execute(sql, (capteur, valeur, date_mesu))
        db.commit()
        print("Donnée insérée dans la base")

    except Exception as e:
        print("Erreur :", e)

# Configuration du client MQTT
client = mqtt.Client()
client.on_message = on_message

client.connect("localhost", 1883, 60)
client.subscribe("capteurs/#")  # Tous les capteurs

client.loop_forever()
