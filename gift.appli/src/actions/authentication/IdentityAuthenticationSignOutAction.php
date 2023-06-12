<?php

declare(strict_types=1);

namespace gift\app\actions\authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class IdentityAuthenticationSignOutAction extends IdentityAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        if ($this->authenticationStateProviderService->isAuthenticated()) {
            $this->authenticationStateProviderService->signOut();

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/');
        }

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/authentication/signin');
    }
}