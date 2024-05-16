import os
import requests
import mysql.connector

# Connexion à la base de données MySQL
cnx = mysql.connector.connect(user='root', password='azerty',
                              host='localhost',
                              database='dofus')

# Création d'un curseur pour exécuter des requêtes SQL
cursor = cnx.cursor()

# Exécution de la requête SQL pour obtenir les URL des images
query = ("SELECT id, imgPath FROM equipements")
cursor.execute(query)

# Récupération des URL des images et mise à jour de la base de données
results = cursor.fetchall()  # Récupérer tous les résultats du premier curseur

for id, url in results:
    response = requests.get(url)
    local_path = os.path.join('equipements', f'image{id}.png')  # Chemin local de l'image téléchargée
    with open(local_path, 'wb') as f:
        f.write(response.content)
    # Mise à jour de l'URL dans la base de données
    update_query = ("UPDATE equipements SET imgPath = %s WHERE id = %s")
    new_url = 'file://' + os.path.abspath(local_path)  # Chemin local absolu de l'image
    cursor.execute(update_query, (new_url, id))
    cnx.commit()

# Fermeture de la connexion à la base de données
cursor.close()
cnx.close()
