<?php

namespace App\Repository\Eloquent;

use App\Models\PaymentMethods;
use App\Repository\BaseRepository;
use App\Repository\Interface\PaymentMethodsRepositoryInterface;

class PaymentMethodsRepository extends BaseRepository implements PaymentMethodsRepositoryInterface
{
    /**
     * Repository constructor.
     *
     * @param PaymentMethods $model
     */
    public function __construct(PaymentMethods $model)
    {
        parent::__construct($model);
    }

    public function filter(array $attributes, int $paginate)
    {
        return $this->model
            ->paginate($paginate);
    }

    public function update(object $model, array $attributes): PaymentMethods
    {
        $model->update($attributes);
        return $model;
    }

    public function delete(object $model): PaymentMethods
    {
        $model->delete();
        return $model;
    }
}