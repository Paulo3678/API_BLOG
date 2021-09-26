<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setUsername('usuario')
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$aGtHbktTdGYydU51eHBKcw$YsPUojxG4nssxKCYJl1FbnScpfaLkh6+6ieqEK3HRUs');
        // 123456
        $manager->persist($user);
        $manager->flush();
    }
}
