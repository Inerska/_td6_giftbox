<?php

declare(strict_types=1);

namespace gift\app\conf;

use gift\app\actions\AccueilAction;
use gift\app\actions\authentication\handles\IdentityAuthenticationSignInHandleAction;
use gift\app\actions\authentication\handles\IdentityAuthenticationSignUpHandleAction;
use gift\app\actions\authentication\IdentityAuthenticationSignInAction;
use gift\app\actions\authentication\IdentityAuthenticationSignOutAction;
use gift\app\actions\authentication\IdentityAuthenticationSignUpAction;
use gift\app\actions\BoxAppendServiceToAction;
use gift\app\actions\BoxCreationAction;
use gift\app\actions\BoxCreationHandlerAction;
use gift\app\actions\CartAction;
use gift\app\actions\CategoriesAction;
use gift\app\actions\CategoriesCreationAction;
use gift\app\actions\CategoryByIdAction;
use gift\app\actions\PayBoxAction;
use gift\app\actions\PrestationAction;
use gift\app\actions\PrestationsAction;
use gift\app\actions\RemovePrestationFromBoxAction;
use gift\app\actions\SigninAction;
use gift\app\actions\SigninHandlerAction;
use gift\app\actions\SignoutAction;
use gift\app\actions\SignupAction;
use gift\app\actions\SignupHandlerAction;
use gift\app\actions\UpdatePrestationQuantityInBoxAction;


return function ($app) {

    $app->get('[/]', AccueilAction::class)->setName('accueil');

    $app->get('/categories[/]', CategoriesAction::class)->setName('categories');

    $app->get('/categorie/{id}', CategoryByIdAction::class)->setName('categorie');

    $app->map(['GET', 'POST'], '/categories/create', CategoriesCreationAction::class)->setName('category_creation');

    $app->get('/prestations/{id}', PrestationsAction::class)->setName('prestations');

    $app->get('/prestation/{id}', PrestationAction::class)->setName('prestation');

    $app->get('/boxes/new', BoxCreationAction::class)->setName('box_creation');

    $app->post('/boxes/new', BoxCreationHandlerAction::class)->setName('box_creation_handler');

    $app->post('/boxes/{id}/services', BoxAppendServiceToAction::class)->setName('box_append_service_to');

    $app->post('/boxes/{id}/prestations/{prestationId}', RemovePrestationFromBoxAction::class)
        ->setName('remove_prestation_from_box');

    $app->group('/auth', function ($app) {
        $app->get('/signup[/]', IdentityAuthenticationSignUpAction::class)->setName('auth.signup');
        $app->post('/signup[/]', IdentityAuthenticationSignUpHandleAction::class)->setName('auth.signup.handle');

        $app->get('/signin[/]', IdentityAuthenticationSignInAction::class)->setName('auth.signin');
        $app->post('/signin[/]', IdentityAuthenticationSignInHandleAction::class)->setName('auth.signin.handle');

        $app->get('/signout[/]', IdentityAuthenticationSignOutAction::class)->setName('auth.signout');
    });

    $app->get('/cart[/]', CartAction::class)->setName('cart');

    $app->post('/boxes/{id}/pay[/]', PayBoxAction::class)->setName('payer');

    $app->post('/cart/{id}/update/{prestationId}', UpdatePrestationQuantityInBoxAction::class)
        ->setName('update_prestation_quantity_in_box');

    $app->get('/debug[/]', function ($request, $response, $args) {
        if (isset($_SESSION)) {
            session_destroy();
        }

        return $response->withStatus(200)->withHeader('Location', '/');
    })->setName('debug');
};