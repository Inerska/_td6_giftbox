<?php

namespace gift\app\actions;

use gift\app\services\CategoriesService;
use Psr\Http\Message\ResponseInterface as Response;
use gift\app\models\Categorie;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;


class CategoryByIdAction extends Action
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        return Twig::fromRequest($request)->render($response, 'categorie.twig',
            ['categorie' =>
                CategoriesService::getCategorieById($args['id'])
            ]
        );
    }
}
