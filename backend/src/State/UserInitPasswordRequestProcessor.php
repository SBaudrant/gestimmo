<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\User\UserInitPasswordRequest;
use App\Service\UserService;

/**
 * @template-implements ProcessorInterface<null>
 */
final class UserInitPasswordRequestProcessor implements ProcessorInterface
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @param UserInitPasswordRequest $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): null
    {
        $this->userService->updatePassword($data->user, $data->password);

        return null;
    }
}
