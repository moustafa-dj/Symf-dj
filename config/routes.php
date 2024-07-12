<?php

namespace App\Config;
use App\Controller\admin\auth\AuthController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function(RoutingConfigurator $routes)
{
    $routes->collection()->prefix('/admin')
            ->add('admin.login-form','/login-form')
            ->controller([AuthController::class ,'index'])->methods(['GET']);
};