<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserFixture extends Fixture
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=30; $i++ ) {
            $user = new User();
            $user->setEmail('user'.$i.'@user.com');
            $user->setFirstname('userfirst'.$i);
            $user->setLastname('userlast'.$i);
            $passwordHashed = $this->userPasswordHasherInterface->hashPassword($user, '123123123');
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($passwordHashed);
            $user->setAddress('Street'.$i.'-'.$i);
            $user->setCity('City'.$i);

            $manager->persist($user);
            $manager->flush();
        }
    }
}
