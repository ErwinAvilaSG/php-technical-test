<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\RegisterUserUseCase;
use App\Application\DTO\RegisterUserRequest;

final class RegisterUserController
{
    public function __construct(
        private RegisterUserUseCase $useCase
    ) {}

    public function register(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $request = new RegisterUserRequest(
            $data['name']     ?? '',
            $data['email']    ?? '',
            $data['password'] ?? ''
        );

        try {
            $responseDTO = $this->useCase->execute($request);
            header('Content-Type: application/json');
            echo json_encode($responseDTO->toArray());
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
