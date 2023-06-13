<?php

namespace gift\app\actions;

use gift\app\services\box\BoxService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BoxCreationHandlerAction extends Action
{

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $libelle = $request->getParsedBody()['libelle'];
        $description = $request->getParsedBody()['description'];

        $result = BoxService::create([
            'name' => $libelle,
            'description' => $description
        ]);

        if (!$result) {
            throw new Exception('Failed to create box');
        }

        return Twig::fromRequest($request)->render($response, 'boxCreation.twig',
            [
                'libelle' => $libelle,
                'description' => $description
            ]
        );

    }
}