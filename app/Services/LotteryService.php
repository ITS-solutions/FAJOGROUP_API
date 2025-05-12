<?php

namespace App\Services;

use App\Models\Lottery;
use App\Repository\Interface\LotteryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class LotteryService
{
    public function __construct(
        protected LotteryRepositoryInterface $lotteryRepository
    ) {}

    /**
     * Use case: Obtener todos los registros según criterio de filtros y con paginación
     *
     * @param array $attributes
     * @param int   $paginate
     * @return LengthAwarePaginator<Lottery>
     */
    public function filterWithPaginate(array $attributes, int $paginate): LengthAwarePaginator
    {
        return $this->lotteryRepository->filter($attributes, $paginate);
    }

    /**
     * Use case: Obtener un registro según su identificador
     *
     * @param int $id
     * @return ?Lottery
     */
    public function getById(int $id): ?Lottery
    {
        return $this->lotteryRepository->find($id);
    }

    /**
     * Use case: Crear un registro
     *
     * @param array $attributes
     * @return Lottery
     */
    public function create(array $attributes): Lottery
    {
        return $this->lotteryRepository->store($attributes);
    }

    /**
     * Use case: Actualizar un registro
     *
     * @param Lottery $model
     * @param array $attributes
     * @return Lottery
     */
    public function update(Lottery $model, array $attributes): Lottery
    {
        return $this->lotteryRepository->update($model, $attributes);
    }

    /**
     * Use case: Eliminar un registro
     *
     * @param Lottery $model
     * @return Lottery
     */
    public function delete(Lottery $model): Lottery
    {
        return $this->lotteryRepository->delete($model);
    }
}