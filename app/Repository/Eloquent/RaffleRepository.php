<?php

namespace App\Repository\Eloquent;

use App\Models\Raffle;
use App\Repository\BaseRepository;
use App\Repository\Interface\RaffleRepositoryInterface;

class RaffleRepository extends BaseRepository implements RaffleRepositoryInterface
{
    /**
     * Repository constructor.
     *
     * @param Raffle $model
     */
    public function __construct(Raffle $model)
    {
        parent::__construct($model);
    }

    public function filter(array $attributes, int $paginate)
    {
        return $this->model
            ->paginate($paginate);
    }

    public function update(object $model, array $attributes): Raffle
    {
        $model->update($attributes);
        return $model;
    }

    public function delete(object $model): Raffle
    {
        $model->delete();
        return $model;
    }
}