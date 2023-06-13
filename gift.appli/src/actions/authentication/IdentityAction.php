<?php

declare(strict_types=1);

namespace gift\app\actions\authentication;

use gift\app\actions\Action;
use gift\app\services\auth\AuthenticationStateProviderService;

abstract class IdentityAction extends Action
{
    protected AuthenticationStateProviderService $authenticationStateProviderService;

    public function __construct()
    {
        $this->authenticationStateProviderService = new AuthenticationStateProviderService();
    }
}