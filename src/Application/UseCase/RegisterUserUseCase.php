<?php
declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\RegisterUserRequest;
use App\Application\DTO\UserResponseDTO;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Model\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\Event\UserRegisteredEvent;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Application\EventDispatcher\EventDispatcherInterface;

final class RegisterUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        // Verificar si el email ya existe
        if ($this->userRepository->findByEmail($request->email()) !== null) {
            throw new UserAlreadyExistsException("El email ya se encuentra registrado.");
        }
        
        $user = new User(
            UserId::generate(),
            new Name($request->name()),
            new Email($request->email()),
            Password::create($request->password())
        );

        $this->userRepository->save($user);
        $this->eventDispatcher->dispatch(new UserRegisteredEvent($user));

        return UserResponseDTO::fromEntity($user);
    }
}
