<?php

declare(strict_types=1);

namespace gift\app\actions\authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class IdentityAuthenticationSignInAction extends IdentityAction
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        if ($this->authenticationStateProviderService->isAuthenticated()) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/');
        }

        return Twig::fromRequest($request)
            ->render($response, 'authentication/signin.twig');
    }
}
