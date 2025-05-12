<?php

namespace App\Repository\Eloquent;

use App\Models\RaffleCategory;
use App\Repository\BaseRepository;
use App\Repository\Interface\RaffleCategoryRepositoryInterface;

class RaffleCategoryRepository extends BaseRepository implements RaffleCategoryRepositoryInterface
{
    /**
     * Repository constructor.
     *
     * @param RaffleCategory $model
     */
    public function __construct(RaffleCategory $model)
    {
        parent::__construct($model);
    }

    public function filter(array $attributes, int $paginate)
    {
        return $this->model
            ->paginate($paginate);
    }

    public function update(object $model, array $attributes): RaffleCategory
    {
        $model->update($attributes);
        return $model;
    }

    public function delete(object $model): RaffleCategory
    {
        $model->delete();
        return $model;
    }
}