<?php

namespace gift\app\actions;

namespace gift\app\actions;
use gift\app\models\Categorie;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class BoxCreationAction extends Action
{

    public function __invoke(ServerRequestInterface $request, Response $response, $args):Response
    {
        return Twig::fromRequest($request)->render($response, 'boxCreationForm.twig');
    }
}