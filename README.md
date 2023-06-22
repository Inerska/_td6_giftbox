http://docketu.iutnc.univ-lorraine.fr:22010

---------------------------------------------------------------------------------------------------------------------------------------

# Projet MyGiftBox.net - README

Trello : https://trello.com/invite/espacedetravailuser34047100/ATTIbea51f55d0b6a0b679f8950936ed43a23533F6B7

## Description générale

Le projet MyGiftBox.net a été développé dans le cadre du cours d'architecture logicielle par Alexis Gridel, Théo Pellizzari et Samuel Pomin. Il s'agit d'une application web permettant de choisir, acheter et offrir des coffrets-cadeaux personnalisés. Les coffrets-cadeaux sont composés d'un ensemble de prestations variées telles que des activités sportives, des activités culturelles, de la gastronomie, de l'hébergement, des visites, etc.

L'application MyGiftBox.net offre les fonctionnalités suivantes :

- Catalogue : Permet aux visiteurs de naviguer, rechercher et afficher les prestations proposées. Les prestations sont classées par catégories telles que restauration, hébergement, attention et activité.
- Création d'un coffret : Permet à un visiteur enregistré de créer un coffret en choisissant des prestations à partir d'une box prédéfinie ou d'un coffret vide. Le prix du coffret est calculé automatiquement en fonction des prestations ajoutées.
- Validation et paiement du coffret : Un coffret doit contenir des prestations provenant d'au moins deux catégories différentes pour pouvoir être validé et payé en ligne. Une fois le paiement effectué, une URL unique est générée pour accéder au contenu du coffret.
- Utilisation du coffret : Le bénéficiaire du coffret peut consulter le contenu du coffret et imprimer sa description en utilisant l'URL générée. Si le coffret est un cadeau, un message supplémentaire peut être ajouté lors de sa création.
- Authentification et Contrôle d'accès : La création de coffrets est réservée aux utilisateurs enregistrés et authentifiés. Les visiteurs non enregistrés peuvent consulter le catalogue et les box prédéfinies.

## Installation du projet

Pour installer et exécuter le projet MyGiftBox.net, suivez les étapes ci-dessous :

1. Clonez le dépôt Git du projet depuis l'URL suivante : https://github.com/Inerska/_td6_giftbox.git
2. Assurez-vous d'avoir Docker installé sur votre machine.
3. Naviguez vers le répertoire racine du projet cloné.
4. Ouvrez le fichier `docker-compose.yml` et vérifiez les ports utilisés par les services. Par défaut, les ports 7840 et 7841 sont utilisés pour les services PHP.
5. Exécutez la commande suivante pour démarrer les conteneurs Docker : `docker-compose up -d`
6. Une fois les conteneurs démarrés, l'application sera accessible à l'adresse : [http://localhost:7840](http://localhost:7840).
7. Pour accéder à l'interface d'administration de la base de données, utilisez l'URL : [http://localhost:4500](http://localhost:4500) (Adminer).
8. Assurez-vous que tous les services sont en cours d'exécution et que l'application fonctionne correctement en accédant à l'URL [http://localhost:7840](http://localhost:7840) dans votre navigateur.

## Configuration du projet

Avant de pouvoir utiliser pleinement le projet MyGiftBox.net, vous devez effectuer quelques configurations supplémentaires :

1. Ouvrez le fichier gift.appli/conf/gift.db.conf.ini et vérifiez les paramètres de configuration, tels que les informations de connexion à la base de données, le serveur, etc. Assurez-vous que ces informations sont correctes pour votre environnement.
2. Importez la base de données initiale en utilisant l'interface d'administration de la base de données (Adminer). Connectez-vous à la base de données en utilisant les informations de connexion spécifiées dans le fichier config/config.php. Importez les fichiers SQL contenus dans le répertoire gift.appli/sql.

## Configuration du projet

Avant de pouvoir utiliser pleinement le projet MyGiftBox.net, vous devez effectuer quelques configurations supplémentaires :

1. Ouvrez le fichier `gift.appli/conf/gift.db.conf.ini` et vérifiez les paramètres de configuration, tels que les informations de connexion à la base de données, le serveur, etc. Assurez-vous que ces informations sont correctes pour votre environnement.
2. Importez la base de données initiale en utilisant l'interface d'administration de la base de données (Adminer). Connectez-vous à la base de données en utilisant les informations de connexion spécifiées dans le fichier `config/config.php`. Importez les fichiers SQL contenus dans le répertoire `gift.appli/sql`.

## Organisation du code source

Le code source du projet est organisé de la manière suivante :

- Le répertoire `actions` contient les fichiers PHP principaux de l'application, tels que les contrôleurs, les modèles, les vues, etc.
- Le répertoire `tests` contient les fichiers de tests unitaires pour les différentes fonctionnalités de l'application.
- Le répertoire `conf` contient les fichiers de configuration de l'application.
- Le répertoire `infrastructure/exception` contient les fichiers liés à la gestion des exceptions et des erreurs.
- Le répertoire `models` contient les fichiers de modèles utilisés pour représenter les données de l'application.
- Le répertoire `scripts` contient les scripts utilitaires ou de déploiement liés au projet.
- Le répertoire `service` contient les fichiers de service qui encapsulent la logique métier de l'application.
- Le répertoire `template` contient les fichiers de modèle utilisés pour générer les vues de l'application.
- Le répertoire `sql` contient les fichiers SQL utilisés pour la création et la gestion de la base de données.

Cette structure de répertoires permet une séparation claire des différentes parties du projet, ce qui facilite la maintenance, la collaboration et l'extension du code source. Chaque répertoire a un rôle spécifique dans l'architecture globale de l'application, ce qui rend le code plus organisé et plus facile à comprendre.

# Routes de test de l'application

Les routes de l'API sont définies dans le fichier de configuration `gift/api/conf/routes.php`. Voici une description de chaque route avec une explication de leur utilité :

- **Accueil** : `/`  
    Cette route renvoie la page d'accueil de l'application.

- **Liste des catégories** : `/categories`  
    Cette route renvoie la liste complète des catégories disponibles.

- **Détails d'une catégorie** : `/categorie/{id}`  
    Cette route renvoie les détails d'une catégorie spécifique identifiée par son ID.

- **Création d'une catégorie** : `/categories/create`  
    Cette route permet de créer une nouvelle catégorie en affichant un formulaire de création et en traitant les données soumises.

- **Liste des prestations** : `/prestations/{id}`  
    Cette route renvoie la liste des prestations associées à une catégorie spécifique identifiée par son ID.

- **Détails d'une prestation** : `/prestation/{id}`  
    Cette route renvoie les détails d'une prestation spécifique identifiée par son ID.

- **Création d'un coffret** : `/boxes/new`  
    Cette route affiche un formulaire pour créer un nouveau coffret.

- **Traitement de la création d'un coffret** : `/boxes/new`  
    Cette route traite les données soumises lors de la création d'un nouveau coffret.

- **Ajout d'un service à un coffret** : `/boxes/{id}/services`  
    Cette route permet d'ajouter un service à un coffret spécifique identifié par son ID.

- **Suppression d'une prestation d'un coffret** : `/boxes/{id}/prestations/{prestationId}`  
    Cette route permet de supprimer une prestation d'un coffret spécifique identifié par son ID.

- **Inscription et connexion** :  
    - Inscription : `/auth/signup`  
    Cette route affiche un formulaire d'inscription et traite les données soumises lors de l'inscription.
    - Connexion : `/auth/signin`  
    Cette route affiche un formulaire de connexion et traite les données soumises lors de la connexion.

- **Déconnexion** : `/auth/signout`  
    Cette route permet à l'utilisateur de se déconnecter de l'application.

- **Panier** : `/cart`  
    Cette route affiche le contenu du panier de l'utilisateur.

- **Paiement d'un coffret** : `/boxes/{id}/pay`  
    Cette route permet de procéder au paiement d'un coffret spécifique identifié par son ID.

- **Mise à jour de la quantité d'une prestation dans le panier** : `/cart/{id}/update/{prestationId}`  
    Cette route permet de mettre à jour la quantité d'une prestation dans le panier.

- **Mode de débogage** : `/debug`  
    Cette route permet de réinitialiser la session de débogage et redirige vers la page d'accueil.

- **Confirmation de paiement** : `/payment-confirmation`  
    Cette route affiche la confirmation de paiement après avoir effectué un paiement.
