<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Domain\Model\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;

final class UserTest extends TestCase
{
    public function testUserCreation(): void
    {
        $user = new User(
            UserId::generate(),
            new Name('John Doe'),
            new Email('john@example.com'),
            Password::create('StrongPass1!')
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name()->value());
        $this->assertEquals('john@example.com', $user->email()->value());
    }
}
