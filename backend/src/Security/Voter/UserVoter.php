<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @template-extends \App\Security\Voter\AbstractVoter<User>
 */
class UserVoter extends AbstractVoter
{
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        return $subject === $user;
    }

    protected function supports($attribute, $subject): bool
    {
        return parent::supports($attribute, $subject) && $subject instanceof User;
    }

    public function supportsType(string $subjectType): bool
    {
        return is_a($subjectType, User::class, true);
    }
}
