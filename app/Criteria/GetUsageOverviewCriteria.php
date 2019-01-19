<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GetUsageOverviewCriteria.
 *
 * @package namespace App\Criteria;
 */
class GetUsageOverviewCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('user_id', auth()->user()->id)
            ->selectRaw('count(1) as total')
            ->selectRaw('sum(size) as size')
            ->groupBy('user_id');
    }
}
