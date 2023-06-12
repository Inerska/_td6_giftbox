<?php

declare(strict_types=1);

namespace gift\app\actions;

use gift\app\infrastructure\exceptions\PrestationIdNotProvidenException;
use gift\app\services\PrestationsService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class PrestationAction extends Action
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        if (!isset($args['id'])) {
            throw new PrestationIdNotProvidenException("L'id de la prestation n'est pas renseigné");
        }

        return Twig::fromRequest($request)->render($response, 'prestation.twig',
            ['prestation' => PrestationsService::getPrestationById(
                $args['id']
            )]
        );
    }
}