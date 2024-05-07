<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\User\UserInitPasswordRequest;
use App\Repository\UserRepository;

/**
 * @template-implements ProviderInterface<UserInitPasswordRequest>
 */
final class UserInitPasswordRequestProvider implements ProviderInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?UserInitPasswordRequest
    {
        $user = $this->userRepository->findOneBy(['initPasswordToken' => $uriVariables['token']]);

        if (!$user) {
            return null;
        }

        return new UserInitPasswordRequest($user);
    }
}
