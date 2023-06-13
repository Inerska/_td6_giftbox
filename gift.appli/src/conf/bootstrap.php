<?php

use gift\app\services\auth\AuthenticationStateProviderService;
use gift\app\services\box\BoxService;
use gift\app\services\utils\Eloquent;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);

Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');

$twig = Twig::create(__DIR__ . '/../template/');
$app->add(TwigMiddleware::create($app, $twig));
$twig->getEnvironment()
    ->addGlobal('basePath', $app->getBasePath());

$twig->getEnvironment()
    ->addGlobal('service', AuthenticationStateProviderService::getInstance());

$twig->getEnvironment()
    ->addGlobal('cartService', BoxService::getInstance());

return $app;
