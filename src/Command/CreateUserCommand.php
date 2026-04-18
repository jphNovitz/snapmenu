<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create a new user (admin)'
)]
class CreateUserCommand extends Command
{
    public function __construct(private readonly UserRepository              $userRepository,
                                private readonly UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Create a new user (admin)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('Email');
        $plainPassword = $io->askHidden('Password');

        if (!$email || !$plainPassword) {
            $io->error('Email and password are required.');

            return Command::FAILURE;
        }

        if ($this->userRepository->findOneBy(['email' => $email])) {
            $io->error('Un utilisateur avec cet email existe déjà.');
            return Command::FAILURE;
        }
        $user = new User();
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user,
            $plainPassword));

        $this->userRepository->save($user, true);

        $io->success('Utilisateur créé.');

        return Command::SUCCESS;
    }
}