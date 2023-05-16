<?php

namespace Src\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class EloquentCriteriaTransformer
{
    public function __construct(
        public Criteria $criteria,
        public Model $model
    ) {
    }

    public function builder(): Builder
    {
        $query = $this->model->newModelQuery();

        /** @var Filter $filter */
        foreach ($this->criteria->filters as $filter) {
            switch ($filter->operator) {
                case FilterOperator::EQUAL:
                    return $query->where($filter->field, '=', $filter->value);
                case FilterOperator::NOT_EQUAL:
                    return $query->where($filter->field, '!=', $filter->value);
            }
        }

        return $query;
    }
}
