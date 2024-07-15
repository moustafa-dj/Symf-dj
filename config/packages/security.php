<?php
 namespace App\Config\Packages;
 use App\Entity\Admin;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Config\SecurityConfig;

 return static function(SecurityConfig $security): void
 {
     $security->provider('app_admin_provider')
            ->entity()->class(Admin::class)
            ->property('email');

    $security->passwordHasher(PasswordAuthenticatedUserInterface::class)
            ->algorithm('auto');
 };