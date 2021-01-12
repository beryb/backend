<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Creates user.
     *
     * @param ObjectManager $manager
     *
     * @return User
     */
    private function createUser(ObjectManager $manager)
    {
        // Initializes user
        $user = new User();

        // Fills with data
        $user->setUsername('demo');
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'demo'
            )
        );

        // Saves
        $manager->persist($user);
        $manager->flush();

        // Returns object
        return $user;
    }


    /**
     * Loads fixtures.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Creates user
        $user = $this->createUser($manager);
    }
}
