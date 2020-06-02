<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $this->encoder = $encoder;
        $this->em = $em;
    }

    /**
     * @param ObjectManager $manager
     * @throws ConnectionException
     * @throws DBALException
     */
    public function load(ObjectManager $manager)
    {
        $connection = $this->em->getConnection();
        $plaform = $connection->getDatabasePlatform();
        $connection->beginTransaction();

        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $connection->executeUpdate($plaform->getTruncateTableSQL('user', true));
        $connection->executeUpdate($plaform->getTruncateTableSQL('project', true));
        $connection->executeUpdate($plaform->getTruncateTableSQL('technology', true));
        $connection->executeUpdate($plaform->getTruncateTableSQL('picture', true));
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
        $connection->commit();

        $user = new User();

        $user
            ->setEmail('john@gmail.com')
            ->setUsername('john')
            ->setPassword($this->encoder->encodePassword($user, 'password'))
            ->setSlug('john')
            ->setRoles("ROLE_ADMIN")
        ;

        $manager->persist($user);
        $manager->flush();
    }
}
