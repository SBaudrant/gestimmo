<?php

namespace App\Security\Voter;

use App\Enum\OperationAttribute;
use App\Enum\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * @template-extends Voter<value-of<OperationAttribute>, TSubject>
 * @template TSubject of mixed
 */
abstract class AbstractVoter extends Voter
{
    /**
     * @inheritDoc
     */
    public function vote(TokenInterface $token, $subject, array $attributes): int
    {
        $vote = parent::vote($token, $subject, $attributes);

        // if it is denied, grant if ROLE_ADMIN. Abstain means the subject/attribute tuple is not supported.
        if ($vote === VoterInterface::ACCESS_DENIED) {
            foreach ($token->getRoleNames() as $role) {
                if ($role === Role::ADMIN->value) {
                    return static::ACCESS_GRANTED;
                }
            }
        }

        return $vote;
    }

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject): bool
    {
        return OperationAttribute::tryFrom($attribute) !== null;
    }

    public function supportsAttribute(string $attribute): bool
    {
        return OperationAttribute::tryFrom($attribute) !== null;
    }
}
