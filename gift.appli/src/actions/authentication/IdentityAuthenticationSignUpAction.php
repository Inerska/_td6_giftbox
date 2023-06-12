<?php

declare(strict_types=1);

namespace gift\app\actions\authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class IdentityAuthenticationSignUpAction extends IdentityAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $response->getBody()->write("SignUp");

        return $response;
    }
}