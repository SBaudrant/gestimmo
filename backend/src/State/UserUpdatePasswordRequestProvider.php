<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\User\UserUpdatePasswordRequest;
use App\Repository\UserRepository;

/**
 * @template-implements ProviderInterface<UserUpdatePasswordRequest>
 */
class UserUpdatePasswordRequestProvider implements ProviderInterface
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): UserUpdatePasswordRequest | null
    {
        $user = $this->userRepository->find($uriVariables['user']);
        if (!$user) {
            return null;
        }

        return new UserUpdatePasswordRequest($user);
    }
}
