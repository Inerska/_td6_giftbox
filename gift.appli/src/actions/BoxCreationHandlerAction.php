<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class BoxCreationHandlerAction extends Action
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $libelle = $request->getParsedBody()['libelle'];
        $description = $request->getParsedBody()['description'];

        return Twig::fromRequest($request)->render($response, 'boxCreation.twig',
            ['libelle' => $libelle, 'description' => $description]
        );

    }
}