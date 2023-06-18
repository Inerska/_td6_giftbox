<?php

declare(strict_types=1);

namespace gift\app\actions\authentication\handles;

use gift\app\actions\authentication\IdentityAction;
use gift\app\infrastructure\exceptions\auth\EmailAlreadyExistsException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class IdentityAuthenticationSignUpHandleAction extends IdentityAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        try {
            $this->authenticationStateProviderService->signUp(
                $data['username'],
                $data['email'],
                $data['password']
            );

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/');

        } catch (EmailAlreadyExistsException$e) {

            return Twig::fromRequest($request)
                ->render($response, 'authentication/signup.twig', [
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'error' => "Email déjà exitant"
                ]);
        } catch (InvalidArgumentException) {
            return Twig::fromRequest($request)
                ->render($response, 'authentication/signup.twig', [
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'error' => "Le mot de passe doit contenir au moins 5 caractères, avec 1 lettre majuscule et 1 symbole."
                ]);
        }
    }
}