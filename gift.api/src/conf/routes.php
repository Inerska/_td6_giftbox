<?php

declare(strict_types=1);

namespace gift\api\conf;

use gift\api\actions\FetchAllCategoriesAction;
use gift\api\actions\FetchAllPrestationsAction;
use gift\api\actions\FetchAllPrestationsFromCategoryIdAction;
use gift\api\actions\FetchBoxByIdAction;


return function ($app) {
    $app->get('/api[/]', function ($request, $response, $args) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/api/categories', FetchAllCategoriesAction::class);

    $app->get('/api/categories/{id}/prestations', FetchAllPrestationsFromCategoryIdAction::class);

    $app->get('/api/coffrets/{id}', FetchBoxByIdAction::class);

    $app->get('/api/prestations', FetchAllPrestationsAction::class);
};