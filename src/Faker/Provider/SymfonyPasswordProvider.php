<?php declare(strict_types=1);

namespace App\Faker\Provider;

use App\Entity\User;
use ContainerAPQKsV4\getSecurity_PasswordHasherFactoryService;
use Faker\Generator;
use Faker\Provider\Base;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class SymfonyPasswordProvider extends Base
{
    /** @var UserPasswordHasherInterface */
    private $passwordHasher;

    public function __construct(Generator $generator, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($generator);

        $this->passwordHasher = $passwordHasher;
    }

    /**
     *
     * @param string $plainPassword
     * @param string|null $salt
     *
     * @return string
     */
    public function symfonyPassword(string $plainPassword, string $salt = null): string
    {
//        $password = $this->encoderFactory->getEncoder($userClass)->encodePassword($plainPassword, $salt);
        $password = $this->passwordHasher->hashPassword(new User(), $plainPassword, $salt);

        return $this->generator->parse($password);
    }
}