<?php

declare(strict_types=1);

namespace gift\app\actions;

use Exception;
use gift\app\services\box\BoxService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

final class UpdatePrestationQuantityInBoxAction extends Action
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $cartId = $args['id'] ?? null;
        $prestaId = $args['prestationId'] ?? null;
        $quantity = (int)$request->getParsedBody()['quantity'] ?? null;

        if ($cartId === null ||
            $prestaId === null ||
            $quantity === null) {
            throw new HttpNotFoundException($request, 'Invalid parameters.');
        }

        try {
            $result = BoxService::updatePrestationQuantity($cartId, $prestaId, $quantity);

            if ($result === false) {
                throw new Exception('Failed to update prestation quantity.');
            }

        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage(),]));
            return $response->withStatus(500);
        }

        return $response->withStatus(302)->withHeader('Location', '/cart');
    }
}
