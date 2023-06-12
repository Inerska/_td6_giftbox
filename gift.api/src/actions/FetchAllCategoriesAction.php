<?php

declare(strict_types=1);

namespace gift\api\actions;

use gift\api\models\Categorie;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class FetchAllCategoriesAction extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $categories = Categorie::all();
        $response->getBody()->write(json_encode($categories));

        if (empty($categories)) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json');
    }
}