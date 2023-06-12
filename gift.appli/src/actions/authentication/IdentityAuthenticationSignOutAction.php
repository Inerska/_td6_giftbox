<?php

declare(strict_types=1);

namespace gift\app\actions\authentication;

use gift\app\actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class IdentityAuthenticationSignOutAction extends Action
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        // TODO: Implement __invoke() method.
    }
}