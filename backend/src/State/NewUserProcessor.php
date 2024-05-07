<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Service\UserService;

/**
 * @template-implements ProcessorInterface<User>
 */
class NewUserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserService $createUserService,
    ) {
    }

    /**
     * @param User $data
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $this->createUserService->create($data);

        return $data;
    }
}
