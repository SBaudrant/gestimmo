<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @template-implements ProcessorInterface<void>
 */
class UserUpdatePasswordRequestProcessor implements ProcessorInterface
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordEncoder,
        private ManagerRegistry $registry,
    ) {
    }

    /**
     * @param \App\Dto\User\UserUpdatePasswordRequest $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $encodedPassword = $this->userPasswordEncoder->hashPassword($data->getUser(), $data->getNewPassword());
        $data->getUser()->setPassword($encodedPassword);

        $this->registry->getManager()->flush();
    }
}
