<?php

namespace App\Command;

use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class CreateUserCommand extends Command
{

    /** @var string  */
    protected static $defaultName = 'app:create:user';

    /** @var EntityManagerInterface */
    protected $em;

    /** @var UserPasswordEncoderInterface */
    protected $encoder;

    /**
     * CreateUserCommand constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription("Create a new user")
            ->setHelp("This command allows you to create a new user ...")
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $output->writeln("You are about to create a new user.");

        $questionEmail = new Question("Enter the email of the user : ");
        $questionPassword = new Question("Enter the password of the user : ");
        $questionUsername = new Question("Enter the username of the user : ");

        $email = $helper->ask($input, $output, $questionEmail);
        $password = $helper->ask($input, $output, $questionPassword);
        $username = $helper->ask($input, $output, $questionUsername);

        $slugify = new Slugify();

        $user = new User();
        $user
            ->setEmail($email)
            ->setPassword($this->encoder->encodePassword($user, $password))
            ->setUsername($username)
            ->setSlug($slugify->slugify($username))
            ->setRoles("ROLE_ADMIN")
        ;

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln("Your user has been created !");
    }
}
