<?php

namespace App\Security\Voter;

use App\Enum\OperationAttribute;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Cette classe abstraite permet de définir un voter "clé en main" pour les données de référence qui autorise
 * tout le monde à les récupérer.
 *
 * Pour l'utiliser, définir une nouvelle classe qui étend celle-ci pour l'objet de référence et passer dans le constructeur
 * de la classe parent le FQCN de l'objet de référence (par exemple Brand::class).
 *
 * @template-extends \App\Security\Voter\AbstractVoter<T>
 * @template T
 */
abstract class AbstractReferentialVoter extends AbstractVoter
{
    /**
     * @param class-string<T> $supportedClass
     */
    public function __construct(
        private readonly string $supportedClass,
    ) {
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return $attribute === OperationAttribute::GET_ITEM->value || $attribute === OperationAttribute::GET_COLLECTION->value;
    }

    protected function supports($attribute, $subject): bool
    {
        return parent::supports($attribute, $subject) && is_a($subject, $this->supportedClass, true);
    }

    public function supportsType(string $subjectType): bool
    {
        return is_a($subjectType, $this->supportedClass, true);
    }
}
