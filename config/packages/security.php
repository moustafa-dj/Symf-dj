<?php
 namespace App\Config\Packages;

 use App\Entity\Admin;
 use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
 use Symfony\Config\SecurityConfig;
 
 return static function (SecurityConfig $security): void {
     // Define the admin provider
        $security->provider('app_admin_provider')
                ->entity()
                ->class(Admin::class)
                ->property('email');
        
        // Define the password hasher
        $security->passwordHasher(PasswordAuthenticatedUserInterface::class)
                ->algorithm('auto');
        
        // Define the firewalls
        $security->firewall('admin')
                ->pattern('^/manager')
                ->formLogin()
                ->loginPath('admin_login_form')
                ->checkPath('login-form')
                ->enableCsrf(true); 

        $security->firewall('client')
                ->pattern('^/client')
                ->formLogin()
                ->loginPath('client/login')
                ->checkPath('client/login')
                ->enableCsrf(true)
                ->checkpath('/client/logout');
        $security->accessControl()->path('^/client')->roles(['ROLE_CLIENT']);
        
        $security->firewall('employee')
                ->pattern('^/employee')
                ->formLogin()
                ->loginPath('employee/login')
                ->checkPath('employee/login')
                ->enableCsrf(true)
                ->checkpath('/employee/logout');

        $security->accessControl()->path('^/employee')->roles(['ROLE_EMPLOYEE']);
 };
 