<?php

declare(strict_types=1);

namespace gift\app\actions;

use gift\app\services\box\BoxService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

final class RemovePrestationFromBoxAction extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $boxId = $args['box_id'];
        $prestaId = $args['presta_id'];

        $box = BoxService::getById($boxId);

        if (!$box) {
            throw new HttpNotFoundException($request, 'Box not found.');
        }

        BoxService::getInstance()->removeService($boxId, $prestaId);

        return Twig::fromRequest($request)
            ->render($response, 'cart.twig');
    }
}
