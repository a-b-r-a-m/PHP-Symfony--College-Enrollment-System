<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // ADMIN ACCOUNT
        $user = new User();

        $user->setEmail("admin@localhost.com");
        //$user->setFirstName("Admin");
        //$user->setLastName("Account");
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, "adminpassword")
        );
        $user->setRoles(array("ROLE_ADMIN"));

        $manager->persist($user);

        // USER ACCOUNT
        $user = new User();

        $user->setEmail("user@localhost.com");
        //$user->setFirstName("User");
        //$user->setLastName("Account");
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, "userpassword")
        );
        $user->setRoles(array("ROLE_USER"));

        $manager->persist($user);

        $manager->flush();
    }
}
