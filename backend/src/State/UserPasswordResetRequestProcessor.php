<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\UserRepository;
use App\Service\UserService;

/**
 * @template-implements ProcessorInterface<null>
 */
final class UserPasswordResetRequestProcessor implements ProcessorInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private UserService $userService,
    ) {
    }

    /**
     * @param \App\Dto\User\UserPasswordResetRequest $data
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): null
    {
        $user = $this->userRepository->findOneBy(['email' => $data->email]);
        if ($user === null) {
            return null;
        }

        $this->userService->resetPassword($user);

        return null;
    }
}
