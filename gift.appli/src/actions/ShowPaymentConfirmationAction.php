<?php

declare(strict_types=1);

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class ShowPaymentConfirmationAction extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        return Twig::fromRequest($request)
            ->render($response, 'payConfirmation.twig');
    }
}