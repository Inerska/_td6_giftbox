<?php

declare(strict_types=1);

namespace gift\api\actions;

use gift\api\models\Box;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class FetchBoxByIdAction extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = $args['id'];

        if (empty($id)) {
            $response->getBody()->write(json_encode([
                'type' => 'error',
                'error' => [
                    'code' => 400,
                    'message' => 'Bad request, id is missing',
                ],
            ]));

            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        $box = Box::find($id);

        if (empty($box)) {
            $response->getBody()->write(json_encode([
                'type' => 'error',
                'error' => [
                    'code' => 404,
                    'message' => 'Box not found',
                ],
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $prestations = $box->prestations;
        $prestationsOutput = [];

        foreach ($prestations as $prestation) {
            $prestationsOutput[] = [
                'libelle' => $prestation['libelle'],
                'description' => $prestation['description'],
                'contenu' => [
                    'box_id' => $prestation['contenu']['box_id'],
                    'presta_id' => $prestation['contenu']['presta_id'],
                    'quantite' => $prestation['contenu']['quantite'],
                ],
            ];
        }

        $output = [
            'type' => 'resource',
            'box' => [
                'id' => $box['id'],
                'libelle' => $box['libelle'],
                'description' => $box['description'],
                'message_kdo' => $box['message_kdo'],
                'statut' => $box['statut'],
                'prestations' => $prestationsOutput,
            ],
        ];

        $response->getBody()->write(json_encode($output));

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json');
    }
}