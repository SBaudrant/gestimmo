<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * @template-extends \App\Security\Voter\AbstractVoter<T>
 * @template T of array|\Traversable
 */
class IterableVoter extends AbstractVoter
{
    public function __construct(protected AccessDecisionManagerInterface $accessDecisionManager)
    {
    }

    public function supportsType(string $subjectType): bool
    {
        return $subjectType === 'array' || is_a($subjectType, \Traversable::class, true);
    }

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject): bool
    {
        return parent::supports($attribute, $subject)
            && is_iterable($subject)
        ;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        foreach ($subject as $item) {
            $isGranted = $this
                ->accessDecisionManager
                ->decide(
                    $token,
                    [$attribute],
                    $item,
                )
            ;

            if (!$isGranted) {
                return false;
            }
        }

        return true;
    }
}
