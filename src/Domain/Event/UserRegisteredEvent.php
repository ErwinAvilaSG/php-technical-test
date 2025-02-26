<?php
declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Model\User;

final class UserRegisteredEvent
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user(): User
    {
        return $this->user;
    }
}
