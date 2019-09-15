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

        $user->setEmail("mentor@oss.unist.hr");
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, "123456")
        );
        $user->setRoles(array("ROLE_ADMIN"));

        $manager->persist($user);

        // USER ACCOUNT
        $user = new User();

        $user->setEmail("student@oss.unist.hr");
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, "123456")
        );
        $user->setRoles(array("ROLE_USER"));

        $manager->persist($user);

        $manager->flush();

        //SUPERADMIN ACCOUNT
        $user = new User();

        $user->setEmail("referada@oss.unist.hr");
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, "123456")
        );
        $user->setRoles(array("ROLE_SUPER_ADMIN"));

        $manager->persist($user);
        $manager->flush();
    }
}
