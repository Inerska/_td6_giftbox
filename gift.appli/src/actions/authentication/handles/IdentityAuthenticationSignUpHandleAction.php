<?php

declare(strict_types=1);

namespace gift\app\actions\authentication\handles;

use gift\app\actions\authentication\IdentityAction;
use gift\app\infrastructure\exceptions\auth\EmailAlreadyExistsException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class IdentityAuthenticationSignUpHandleAction extends IdentityAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        try {
            $this->authenticationStateProviderService->signUp(
                $data['pseudonyme'],
                $data['email'],
                $data['password']
            );

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/');

        } catch (EmailAlreadyExistsException) {

            $response->getBody()
                ->write('Email already exists');

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/authentication/signup');
        }
    }
}