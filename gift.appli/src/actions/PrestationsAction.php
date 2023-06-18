<?php

declare(strict_types=1);

namespace gift\app\actions;

use gift\app\services\CategorieNotFoundException;
use gift\app\services\PrestationsService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class PrestationsAction extends Action
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        if (!isset($args['id'])) {
            throw new CategorieNotFoundException("L'id de la categorie n'est pas renseigné");
        }

        $sort = $request->getQueryParams()['sort'] ?? null;

        var_dump($sort);

        return Twig::fromRequest($request)->render($response, 'prestations.twig',
            ['prestations' => PrestationsService::getPrestationsByCategorieId(
                intval($args['id']), $sort
            )]
        );
    }
}
