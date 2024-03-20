<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_user(): void
    {
        $user = new User();

        $user->setEmail('myemail@test.test');
        $user->setPassword('password');
        $user->setIsVerified(true);
        $user->setRoles(['ROLE_TEST']);

        $this->assertEquals('myemail@test.test', $user->getEmail());
        $this->assertEquals('password', $user->getPassword());
        $this->assertContains('ROLE_TEST', $user->getRoles());
        $this->assertTrue($user->isVerified());
    }
}
