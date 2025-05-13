<?php

namespace App\Services;

use App\Models\PaymentMethods;
use App\Repository\Interface\PaymentMethodsRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentMethodsService
{
    public function __construct(
        protected PaymentMethodsRepositoryInterface $paymentMethodsRepository
    ) {}

    /**
     * Use case: Obtener todos los registros según criterio de filtros y con paginación
     *
     * @param array $attributes
     * @param int   $paginate
     * @return LengthAwarePaginator<PaymentMethods>
     */
    public function filterWithPaginate(array $attributes, int $paginate): LengthAwarePaginator
    {
        return $this->paymentMethodsRepository->filter($attributes, $paginate);
    }

    /**
     * Use case: Obtener un registro según su identificador
     *
     * @param int $id
     * @return ?PaymentMethods
     */
    public function getById(int $id): ?PaymentMethods
    {
        return $this->paymentMethodsRepository->find($id);
    }

    /**
     * Use case: Crear un registro
     *
     * @param array $attributes
     * @return PaymentMethods
     */
    public function create(array $attributes): PaymentMethods
    {
        return $this->paymentMethodsRepository->store($attributes);
    }

    /**
     * Use case: Actualizar un registro
     *
     * @param PaymentMethods $model
     * @param array $attributes
     * @return PaymentMethods
     */
    public function update(PaymentMethods $model, array $attributes): PaymentMethods
    {
        return $this->paymentMethodsRepository->update($model, $attributes);
    }

    /**
     * Use case: Eliminar un registro
     *
     * @param PaymentMethods $model
     * @return PaymentMethods
     */
    public function delete(PaymentMethods $model): PaymentMethods
    {
        return $this->paymentMethodsRepository->delete($model);
    }
}