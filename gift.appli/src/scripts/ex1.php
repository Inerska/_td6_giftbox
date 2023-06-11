<?php

require_once __DIR__ . '/../vendor/autoload.php';

use gift\app\models\Box;
use gift\app\models\Categorie;
use gift\app\models\Prestation;
use Illuminate\Database\Capsule\Manager as DB;

$db = new DB();
$db->addConnection(parse_ini_file(__DIR__ . '\..\conf\gift.db.conf.ini.dist'));
$db->setAsGlobal();
$db->bootEloquent();

//requete 1

$prestations = Prestation::all();

foreach ($prestations as $prestation) {
    echo "Libellé : " . $prestation->libelle . "\n";
    echo "Description : " . $prestation->description . "\n";
    echo "Tarif : " . $prestation->tarif . "\n";
    echo "Unité : " . $prestation->unite . "\n";
    echo "\n";
}

//requete 2

$prestations = Prestation::with('categorie')->get();

foreach ($prestations as $prestation) {
    echo "Libellé : " . $prestation->libelle . "\n";
    echo "Description : " . $prestation->description . "\n";
    echo "Tarif : " . $prestation->tarif . "\n";
    echo "Unité : " . $prestation->unite . "\n";
    echo "Catégorie : " . $prestation->categorie->libelle . "\n";
    echo "\n";
}

//requete 3

$categorie = Categorie::with('prestations')->find(3);

echo "Catégorie : " . $categorie->libelle . "\n";

foreach ($categorie->prestations as $prestation) {
    echo "Libellé : " . $prestation->libelle . "\n";
    echo "Tarif : " . $prestation->tarif . "\n";
    echo "Unité : " . $prestation->unite . "\n";
    echo "\n";
}

//requete 4

$box = Box::find('360bb4cc-e092-3f00-9eae-774053730cb2');

echo "Libellé : " . $box->libelle . "\n";
echo "Description : " . $box->description . "\n";
echo "Montant : " . $box->montant . "\n";


//requete 5

// Charger la box et ses prestations avec eager loading
$box = Box::with('prestations')->find('360bb4cc-e092-3f00-9eae-774053730cb2');

// Afficher les informations de la box
echo "Box " . $box->libelle . " - " . $box->description . " - Montant: " . $box->montant . " " . Box::USD . "<br>";

// Afficher les prestations de la box
foreach ($box->prestations as $presta) {
    echo $presta->libelle . " - Tarif: " . $presta->tarif . " " . Box::USD . " - Unité: " . $presta->unite . " - Quantité: " . $presta->contenu->quantite . "<br>";
}