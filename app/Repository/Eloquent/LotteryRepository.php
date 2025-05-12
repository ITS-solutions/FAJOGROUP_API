<?php

namespace App\Repository\Eloquent;

use App\Models\Lottery;
use App\Repository\BaseRepository;
use App\Repository\Interface\LotteryRepositoryInterface;

class LotteryRepository extends BaseRepository implements LotteryRepositoryInterface
{
    /**
     * Repository constructor.
     *
     * @param Lottery $model
     */
    public function __construct(Lottery $model)
    {
        parent::__construct($model);
    }

    public function filter(array $attributes, int $paginate)
    {
        return $this->model
            ->paginate($paginate);
    }

    public function update(object $model, array $attributes): Lottery
    {
        $model->update($attributes);
        return $model;
    }

    public function delete(object $model): Lottery
    {
        $model->delete();
        return $model;
    }
}