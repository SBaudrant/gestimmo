<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;

final class UserSearchFilter extends AbstractSearchFilter
{
    /**
     * This function is only used to hook in documentation generators (supported by Swagger and Hydra)
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            'search' => [
                'property' => 'search',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Search the given string in firstName, lastName and email fields (case insensitive)',
                ],
            ],
        ];
    }

    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        // Ensure the given property matches the property we defined
        if (!str_contains($property, 'search')) {
            return;
        }

        $fields = ['firstName', 'lastName', 'email'];

        $searches = explode(' ', $value);
        $searches = array_filter($searches, 'mb_strlen');

        foreach ($searches as $search) {
            $this->addPartialWhere($queryBuilder, $queryNameGenerator, 'o', $fields, $search);
        }
    }
}
