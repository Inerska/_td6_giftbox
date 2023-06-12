<?php

namespace gift\app\conf;

use gift\app\actions\AccueilAction;
use gift\app\actions\BoxAppendServiceToAction;
use gift\app\actions\BoxCreationAction;
use gift\app\actions\BoxCreationHandlerAction;
use gift\app\actions\CategoriesAction;
use gift\app\actions\CategoriesCreationAction;
use gift\app\actions\CategoryByIdAction;
use gift\app\actions\PrestationAction;
use gift\app\actions\PrestationsAction;


return function ($app) {
    $app->get('/api[/]', function ($request, $response, $args) {
        $response->getBody()->write('Hello world!');
        return $response;
    });
};