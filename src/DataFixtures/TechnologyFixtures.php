<?php

namespace App\DataFixtures;

use App\Entity\Technology;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TechnologyFixtures extends Fixture
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

        $php = new Technology();
        $php->setName("PHP");

        $javascript = new Technology();
        $javascript->setName("JavaScript");

        $jquery = new Technology();
        $jquery->setName("Jquery");

        $ajax = new Technology();
        $ajax->setName("Ajax");

        $mysql = new Technology();
        $mysql->setName("MySQL");

        $nginx = new Technology();
        $nginx->setName("Nginx");

        $twig = new Technology();
        $twig->setName("Twig");

        $html = new Technology();
        $html->setName("HTML");

        $css = new Technology();
        $css->setName("CSS");

        $symfony = new Technology();
        $symfony->setName("Symfony");

        $bootstrap = new Technology();
        $bootstrap->setName("Bootstrap");

        $phpunit = new Technology();
        $phpunit->setName("PHPUnit");

        $behat = new Technology();
        $behat->setName("Behat");

        $apiRest = new Technology();
        $apiRest->setName("API REST");

        $blackfire = new Technology();
        $blackfire->setName("Blackfire");

        $adr = new Technology();
        $adr->setName("ADR");

        $mvc = new Technology();
        $mvc->setName("MVC");

        $wordpress = new Technology();
        $wordpress->setName("WordPress");

        $phpstan = new Technology();
        $phpstan->setName("PHPStan");

        $phpcodesniffer = new Technology();
        $phpcodesniffer->setName("PHPCodesniffer");

        $manager->persist($php);
        $manager->persist($javascript);
        $manager->persist($jquery);
        $manager->persist($mysql);
        $manager->persist($html);
        $manager->persist($css);
        $manager->persist($symfony);
        $manager->persist($bootstrap);
        $manager->persist($phpunit);
        $manager->persist($behat);
        $manager->persist($apiRest);
        $manager->persist($blackfire);
        $manager->persist($adr);
        $manager->persist($wordpress);
        $manager->persist($phpstan);
        $manager->persist($phpcodesniffer);
        $manager->persist($twig);
        $manager->persist($mvc);
        $manager->persist($nginx);
        $manager->persist($ajax);

        $manager->flush();
    }
}
