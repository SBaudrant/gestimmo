<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractSearchFilter extends AbstractFilter
{
    /**
     * @param string[] $fields
     */
    protected function addPartialWhere(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $alias,
        array $fields,
        string $value,
    ): void {
        $this->addWhere($queryBuilder, $queryNameGenerator, $alias, $fields, $value, 'like');
    }

    /**
     * @param string[] $fields
     */
    protected function addExactWhere(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $alias,
        array $fields,
        mixed $value,
    ): void {
        $this->addWhere($queryBuilder, $queryNameGenerator, $alias, $fields, $value, 'eq');
    }

    /**
     * @param string[] $fields
     * @param string $comparison One of comparison operator included in Expr class, which must take 2 parameters.
     */
    private function addWhere(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $alias,
        array $fields,
        mixed $value,
        string $comparison,
    ): void {
        $parameterName = $queryNameGenerator->generateParameterName('search_filter');
        $expr = $queryBuilder->expr();

        $queryBuilder->andWhere(
            $expr->orX(
                ...array_map(
                    function ($field) use ($expr, $comparison, $alias, $parameterName): string {
                        return $expr->$comparison($expr->lower(sprintf('%s.%s', $alias, $field)), $expr->lower(sprintf(':%s', $parameterName)));
                    },
                    $fields,
                ),
            ),
        );

        $queryBuilder->setParameter($parameterName, '%' . $value . '%');
    }
}
