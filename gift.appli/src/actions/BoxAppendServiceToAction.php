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

            BoxService::addService($currentBox->id, $serviceId);

        } catch (PrestationNotFoundException $e) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->withHeader('Message', 'Box not found');
        }

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'text/html')
            ->withHeader('Message', 'Box updated');
    }
}