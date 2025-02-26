<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Model\User;
use App\Domain\ValueObject\UserId;

class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function findById(UserId $id): ?User
    {
        return $this->em->find(User::class, $id->value());
    }

    public function delete(UserId $id): void
    {
        $user = $this->findById($id);
        if ($user !== null) {
            $this->em->remove($user);
            $this->em->flush();
        }
    }

    public function findByEmail(string $email): ?User
{
    return $this->em->getRepository(User::class)
                    ->findOneBy(['email' => new \App\Domain\ValueObject\Email($email)]);
}
}
