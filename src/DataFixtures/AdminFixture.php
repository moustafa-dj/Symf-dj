<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends Fixture{

    protected UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();

        $admin->setEmail('moustafa@gmail.com')
            ->setName('admin')
            ->setPassword($this->hasher->hashPassword($admin , '123456789'))
            ->setFullName('admin_fullname')
            ->setAdress('adress')
            ->setAbout('this smf_serve_admin')
            ->setPhone('123456789')
            ->setImage('admin_img')
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $manager->flush();
    }
}