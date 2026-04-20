<?php
namespace App\Service;
use App\Contract\UserManagerInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserManager implements UserManagerInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function preparePassword(User $user): void
    {
        if (!$user->getPlainPassword()) {
            return;
        }

        $user->setPassword(
            $this->passwordHasher->hashPassword($user,
                $user->getPlainPassword())
        );

        $user->eraseCredentials();
    }
}
