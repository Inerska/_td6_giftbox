<?php

namespace gift\api\conf;

use gift\api\actions\FetchAllCategoriesAction;
use gift\api\actions\FetchBoxByIdAction;


return function ($app) {
    $app->get('/api[/]', function ($request, $response, $args) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/api/categories', FetchAllCategoriesAction::class);

    $app->get('/api/boxes/{id}', FetchBoxByIdAction::class);
};