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
        if (!isset($request->getQueryParams()['id'])) {
            throw new CategorieNotFoundException("L'id de la categorie n'est pas renseigné");
        }

        return Twig::fromRequest($request)->render($response, 'prestations.twig',
            ['prestations' => PrestationsService::getPrestationsByCategorieId(
                $request->getQueryParams()['id']
            )]
        );
    }
}