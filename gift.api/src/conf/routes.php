<?php

declare(strict_types=1);

namespace gift\api\conf;

use gift\api\actions\FetchAllCategoriesAction;
use gift\api\actions\FetchAllPrestationsAction;
use gift\api\actions\FetchAllPrestationsFromCategoryIdAction;
use gift\api\actions\FetchBoxByIdAction;

const API_PREFIX = '/api';

return function ($app) {
    $app->get(API_PREFIX . '[/]', function ($request, $response, $args) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get(API_PREFIX . '/categories', FetchAllCategoriesAction::class);

    $app->get(API_PREFIX . '/categories/{id}/prestations', FetchAllPrestationsFromCategoryIdAction::class);

    $app->get(API_PREFIX . '/coffrets/{id}', FetchBoxByIdAction::class);

    $app->get(API_PREFIX . '/prestations', FetchAllPrestationsAction::class);
};