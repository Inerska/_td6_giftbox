<?php

declare(strict_types=1);

namespace gift\app\actions;

use gift\app\services\auth\AuthenticationStateProviderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class CartAction extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $service = AuthenticationStateProviderService::getInstance();

        if (!$service->isAuthenticated()) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/auth/signin');
        }

        return Twig::fromRequest($request)
            ->render($response, 'cart.twig');
    }
}