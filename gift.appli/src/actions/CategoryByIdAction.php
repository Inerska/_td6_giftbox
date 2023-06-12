<?php

declare(strict_types=1);

namespace gift\app\actions;

use CategoryIdNotProvidenException;
use gift\app\services\CategoriesService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;


class CategoryByIdAction extends Action
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        if (!isset($args['id'])) {
            throw new CategoryIdNotProvidenException("L'id de la categorie n'est pas renseigné");
        }

        return Twig::fromRequest($request)->render($response, 'categorie.twig',
            ['categorie' =>
                CategoriesService::getCategorieById(
                    intval($args['id'])
                )
            ]
        );
    }
}
