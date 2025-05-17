<?php

namespace App\Repository\Eloquent;

use App\Models\RaffleDetail;
use App\Repository\BaseRepository;
use App\Repository\Interface\RaffleDetailRepositoryInterface;

class RaffleDetailRepository extends BaseRepository implements RaffleDetailRepositoryInterface
{
    /**
     * Repository constructor.
     *
     * @param RaffleDetail $model
     */
    public function __construct(RaffleDetail $model)
    {
        parent::__construct($model);
    }

    public function filter(array $attributes, int $paginate)
    {
        return $this->model
            ->paginate($paginate);
    }

    public function update(object $model, array $attributes): RaffleDetail
    {
        $model->update($attributes);
        return $model;
    }

    public function delete(object $model): RaffleDetail
    {
        $model->delete();
        return $model;
    }
}