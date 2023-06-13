<?php

declare(strict_types=1);

namespace gift\app\actions;

use gift\app\services\auth\AuthenticationStateProviderService;
use gift\app\services\box\BoxService;
use gift\app\services\CategoriesService;
use gift\app\services\PrestationNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class BoxAppendServiceToAction extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $currentBoxId = $_SESSION['box']['id'];

        try {
            $currentBox = BoxService::getById($currentBoxId);
            $serviceId = $args['id'];

            $res = BoxService::getInstance()->addService($serviceId, $currentBoxId);

        } catch (PrestationNotFoundException $e) {

            $response->getBody()->write('Service not found');

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'text/html');
        }

        return Twig::fromRequest($request)->render($response, 'accueil.twig', [
            'categories' => CategoriesService::getCategories(),
            'service' => AuthenticationStateProviderService::getInstance(),
        ]);
    }
}