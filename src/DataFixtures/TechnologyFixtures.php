<?php

namespace App\DataFixtures;

use App\Entity\Technology;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TechnologyFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $php = new Technology();
        $php->setName("PHP");

        $javascript = new Technology();
        $javascript->setName("JavaScript");

        $jquery = new Technology();
        $jquery->setName("Jquery");

        $mysql = new Technology();
        $mysql->setName("MySQL");

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

        $manager->flush();
    }
}
