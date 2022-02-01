<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewAdminUserCommand extends Command
{
    protected static $defaultName = 'crm:new-admin-user';
    protected static $defaultDescription = 'Cadastro de novos usuários admin';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email')
            ->addArgument('senha', InputArgument::REQUIRED, 'Senha')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->entityManager;

        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $senha = $input->getArgument('senha');

        if ($email && $senha) {

            $user = new User();
            $user->setEmail($email);
            $user->setPlainPassword($senha);

            $user->addRole("ROLE_ADMIN");

            $em->persist($user);
            $em->flush();

            
            $io->note(sprintf('Email: %s', $email));
            $io->note(sprintf('Senha provisória: %s', $senha));
        }

        $io->success('Usuário cadastrado com sucesso');

        return Command::SUCCESS;
    }
}
