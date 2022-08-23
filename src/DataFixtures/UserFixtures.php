<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUserName('usuario')
            ->setPassword('$2y$13$ZoQiiaP6aFDT/PcZNpw7MuN5wwpaQ39k0RakZpMEq1Q7C6Y.Iwc.m');

        $manager->persist($user);
        $manager->flush();
    }
}
