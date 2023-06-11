<?php

namespace gift\app\conf;

use gift\app\actions\BoxCreationAction;
use gift\app\actions\BoxCreationHandlerAction;
use gift\app\actions\CategoriesAction;
use gift\app\actions\CategoryByIdAction;
use gift\app\actions\PrestationAction;
use gift\app\actions\PrestationsAction;
use gift\app\actions\AccueilAction;





return function ($app) {

    $app->get('[/]',AccueilAction::class)->setName('accueil');

    $app->get('/categories[/]', CategoriesAction::class)->setName('categories');

    $app->get('/categorie/{id}', CategoryByIdAction::class)->setName('categorie');

    $app->get('/prestations', PrestationsAction::class)->setName('prestations');

    $app->get('/prestation', PrestationAction::class)->setName('prestation');

    $app->get('/boxes/new', BoxCreationAction::class)->setName('box_creation');

    $app->post('/boxes/new', BoxCreationHandlerAction::class)->setName('box_creation_handler');

    

};