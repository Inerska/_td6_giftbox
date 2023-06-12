<?php

declare(strict_types=1);

namespace gift\app\actions\authentication\handles;

use gift\app\actions\authentication\IdentityAction;
use gift\app\infrastructure\exceptions\auth\EmailDoesNotExistException;
use gift\app\infrastructure\exceptions\auth\InvalidPasswordException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class IdentityAuthenticationSignInHandleAction extends IdentityAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        try {
            $this->authenticationStateProviderService->signIn(
                $data['email'],
                $data['password']
            );

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/');

        } catch (EmailDoesNotExistException|InvalidPasswordException $e) {

            $response->getBody()
                ->write($e->getMessage());

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/authentication/signin');
        }
    }
}
