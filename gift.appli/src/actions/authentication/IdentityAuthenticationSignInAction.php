<?php

declare(strict_types=1);

namespace gift\app\actions\authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class IdentityAuthenticationSignInAction extends IdentityAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
    }
}