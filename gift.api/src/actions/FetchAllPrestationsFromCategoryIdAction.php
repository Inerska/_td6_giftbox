<?php

declare(strict_types=1);

namespace gift\api\actions;

use gift\api\models\Prestation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class FetchAllPrestationsFromCategoryIdAction extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $prestations = Prestation::where('cat_id', $args['id'])->get();

        if (empty($prestations)) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $response
            ->getBody()
            ->write(json_encode($prestations));

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json');
    }
}