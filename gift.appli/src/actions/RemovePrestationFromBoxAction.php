<?php

declare(strict_types=1);

namespace gift\app\actions;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use gift\app\services\box\BoxService;

final class RemovePrestationFromBoxAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $boxId = $args['id'] ?? null;
        $prestaId = $args['prestationId'] ?? null;

        if ($boxId === null
            || $prestaId === null) {
            throw new HttpNotFoundException($request, 'Invalid box or prestation id.');
        }

        try {
            $result = BoxService::removeService($boxId, $prestaId);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage(),]));
            return $response->withStatus(500);
        }

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/cart');
    }
}