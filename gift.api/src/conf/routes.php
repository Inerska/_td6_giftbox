<?php

namespace gift\api\conf;

use gift\api\actions\FetchAllCategoriesAction;


return function ($app) {
    $app->get('/api[/]', function ($request, $response, $args) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/api/categories', FetchAllCategoriesAction::class);
};