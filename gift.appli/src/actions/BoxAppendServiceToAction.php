<?php

declare(strict_types=1);

namespace gift\app\actions;

use gift\app\services\box\BoxService;
use gift\app\services\PrestationNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BoxAppendServiceToAction extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $currentBoxId = $_SESSION['box']['id'];
        try {
            $currentBox = BoxService::getById($currentBoxId);
            $serviceId = $args['id'];

            $res = BoxService::getInstance()->addService($serviceId, $currentBoxId);

            var_dump($res);

        } catch (PrestationNotFoundException $e) {

            $response->getBody()->write('Service not found');

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'text/html');
        }

        $response->getBody()->write('Service added to box');

        return $response
            ->withStatus(200);
    }
}