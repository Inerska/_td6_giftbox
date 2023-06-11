<?php

declare(strict_types=1);

namespace gift\app\actions;

use Exception;
use gift\app\services\PrestationsService;
use gift\app\services\utils\CsrfService;
use gift\test\services\prestations\PrestationServiceTest;
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

        $token = $data['token'] ?? '';

        CsrfService::checkToken($token);

        $result = PrestationsService::createCategory($data);

        if (!$result) {
            throw new Exception('Failed to create category');
        }

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/categories');
    }
}