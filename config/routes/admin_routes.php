<?php
namespace config\routes;

use App\Controller\Admin\AdminController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use App\Controller\Admin\Auth\AuthController;

return static function (RoutingConfigurator $routes) {
    $routes->collection()
        ->prefix('/manager')
        ->add('admin_login_form', '/login-form')
            ->controller([AuthController::class, 'index'])
            ->methods(['GET'])
        ->add('admin_login', '/login')
            ->controller([AuthController::class, 'login'])
            ->methods(['GET'])
        ->add('dashbord','/dashbored')
            ->controller([AdminController::class , 'index'])
            ->methods(['GET']);
};