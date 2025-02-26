<?php
declare(strict_types=1);

namespace App\Application\EventDispatcher;

interface EventDispatcherInterface
{
    public function dispatch(object $event): void;
}
