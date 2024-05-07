<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Composite;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY)]
class Compose extends Composite
{
    /** @param list<Constraint> $constraints */
    public function __construct(
        public array $constraints = [],
        public int $min = 0,
        public int|null $max = null,
        public string $minMessage = 'compose.min',
        public string $maxMessage = 'compose.max',
        array $groups = null,
        $payload = null,
    ) {
        parent::__construct($constraints, $groups, $payload);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultOption(): ?string
    {
        return $this->getCompositeOption();
    }

    /**
     * @inheritDoc
     */
    public function getTargets(): string|array
    {
        return [
            static::CLASS_CONSTRAINT,
            static::PROPERTY_CONSTRAINT,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getCompositeOption(): string
    {
        return 'constraints';
    }
}
