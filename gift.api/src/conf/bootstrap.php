<?php

use gift\app\services\utils\Eloquent;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

$app = \Slim\Factory\AppFactory::create();

$app->addErrorMiddleware(true,false,false);

return $app;
