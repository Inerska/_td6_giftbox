<?php

declare(strict_types=1);

namespace gift\app\actions;

use Exception;
use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CategoriesCreationAction extends Action
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        if ($request->getMethod() === 'GET') {
            return Twig::fromRequest($request)->render($response, 'categorieCreationForm.twig', [
                'token' => CsrfService::generateToken(),
            ]);
        }

        $data = $request->getParsedBody();

        $token = $data['csrf_token'] ?? '';

        try {
            CsrfService::checkToken($token);
        } catch (Exception $e) {
        }

        return Twig::fromRequest($request)
            ->render($response, 'categorieCreationHandled.twig', [
                'libelle' => $data["libelle"],
                'description' => $data["description"],
            ]);
    }
}