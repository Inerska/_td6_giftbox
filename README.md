Projet MyGiftBox.net - README

Description générale

Le projet MyGiftBox.net a été développé dans le cadre du cours d'architecture logicielle par Alexis Gridel, Théo Pellizzari et Samuel Pomin. Il s'agit d'une application web permettant de choisir, acheter et offrir des coffrets-cadeaux personnalisés. Les coffrets-cadeaux sont composés d'un ensemble de prestations variées telles que des activités sportives, des activités culturelles, de la gastronomie, de l'hébergement, des visites, etc.

L'application MyGiftBox.net offre les fonctionnalités suivantes :

Catalogue : Permet aux visiteurs de naviguer, rechercher et afficher les prestations proposées. Les prestations sont classées par catégories telles que restauration, hébergement, attention et activité.
Création d'un coffret : Permet à un visiteur enregistré de créer un coffret en choisissant des prestations à partir d'une box prédéfinie ou d'un coffret vide. Le prix du coffret est calculé automatiquement en fonction des prestations ajoutées.
Validation et paiement du coffret : Un coffret doit contenir des prestations provenant d'au moins deux catégories différentes pour pouvoir être validé et payé en ligne. Une fois le paiement effectué, une URL unique est générée pour accéder au contenu du coffret.
Utilisation du coffret : Le bénéficiaire du coffret peut consulter le contenu du coffret et imprimer sa description en utilisant l'URL générée. Si le coffret est un cadeau, un message supplémentaire peut être ajouté lors de sa création.
Authentification et Contrôle d'accès : La création de coffrets est réservée aux utilisateurs enregistrés et authentifiés. Les visiteurs non enregistrés peuvent consulter le catalogue et les box prédéfinies.

Installation du projet

Pour installer et exécuter le projet MyGiftBox.net, suivez les étapes ci-dessous :

Clonez le dépôt Git du projet depuis l'URL suivante : [URL_DU_DEPOT_GIT].
Assurez-vous d'avoir Docker installé sur votre machine.
Naviguez vers le répertoire racine du projet cloné.
Ouvrez le fichier docker-compose.yml et vérifiez les ports utilisés par les services. Par défaut, les ports 7840 et 7841 sont utilisés pour les services PHP.
Exécutez la commande suivante pour démarrer les conteneurs Docker :
docker-compose up -d
Une fois les conteneurs démarrés, l'application sera accessible à l'adresse : http://localhost:7840.
Pour accéder à l'interface d'administration de la base de données, utilisez l'URL : http://localhost:4500 (Adminer).
Assurez-vous que tous les services sont en cours d'exécution et que l'application fonctionne correctement en accédant à l'URL http://localhost:7840 dans votre navigateur.

Configuration du projet

Avant de pouvoir utiliser pleinement le projet MyGiftBox.net, vous devez effectuer quelques configurations supplémentaires :
Ouvrez le fichier gift.appli/conf/gift.db.conf.ini et vérifiez les paramètres de configuration, tels que les informations de connexion à la base de données,le serveur, etc. Assurez-vous que ces informations sont correctes pour votre environnement.
Importez la base de données initiale en utilisant l'interface d'administration de la base de données (Adminer). Connectez-vous à la base de données en utilisant les informations de connexion spécifiées dans le fichier config/config.php. Importez les fichier SQL contenus dans le répertoire gift.appli/sql.

Organisation du code source

Le code source du projet est organisé de la manière suivante :

Le répertoire actions contient les fichiers PHP principaux de l'application, tels que les contrôleurs, les modèles, les vues, etc.
Le répertoire tests contient les fichiers de tests unitaires pour les différentes fonctionnalités de l'application.
Le répertoire conf contient les fichiers de configuration de l'application.
Le répertoire infrastructure/exception contient les fichiers liés à la gestion des exceptions et des erreurs.
Le répertoire models contient les fichiers de modèles utilisés pour représenter les données de l'application.
Le répertoire scripts contient les scripts utilitaires ou de déploiement liés au projet.
Le répertoire service contient les fichiers de service qui encapsulent la logique métier de l'application.
Le répertoire template contient les fichiers de modèle utilisés pour générer les vues de l'application.
Le répertoire sql contient les fichiers SQL utilisés pour la création et la gestion de la base de données.
Cette structure de répertoires permet une séparation claire des différentes parties du projet, ce qui facilite la maintenance, la collaboration et l'extension du code source. Chaque répertoire a un rôle spécifique dans l'architecture globale de l'application, ce qui rend le code plus organisé et plus facile à comprendre.

Routes de bases de l'API

Les routes de l'API sont définies dans le fichier de configuration gift\api\conf\routes.php. Voici une description de chaque route :

GET /api : Cette route renvoie simplement le message "Hello world!". C'est une route de test pour vérifier si l'API fonctionne correctement.

GET /api/categories : Cette route renvoie toutes les catégories disponibles. Permet de récupérer la liste complète des catégories pour affichage ou traitement ultérieur.

GET /api/categories/{id}/prestations : Cette route renvoie toutes les prestations associées à une catégorie spécifique. Permet de récupérer les prestations d'une catégorie donnée pour affichage ou traitement ultérieur.

GET /api/coffrets/{id} : Cette route renvoie les informations d'un coffret spécifique identifié par son ID. Permet de récupérer les détails d'un coffret pour affichage ou traitement ultérieur.

GET /api/prestations : Cette route renvoie toutes les prestations disponibles. Permet de récupérer la liste complète des prestations pour affichage ou traitement ultérieur.

Chaque route est associée à une action spécifique qui sera exécutée lorsqu'une requête est reçue sur cette route. Les actions sont définies dans les classes correspondantes, telles que FetchAllCategoriesAction, FetchAllPrestationsFromCategoryIdAction, FetchBoxByIdAction, et FetchAllPrestationsAction.
