<?php

namespace App\Services;

use App\Models\RaffleDetail;
use App\Repository\Interface\RaffleDetailRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RaffleDetailService
{
    public function __construct(
        protected RaffleDetailRepositoryInterface $raffleDetailRepository
    ) {}

    /**
     * Use case: Obtener todos los registros según criterio de filtros y con paginación
     *
     * @param array $attributes
     * @param int   $paginate
     * @return LengthAwarePaginator<RaffleDetail>
     */
    public function filterWithPaginate(array $attributes, int $paginate): LengthAwarePaginator
    {
        return $this->raffleDetailRepository->filter($attributes, $paginate);
    }

    /**
     * Use case: Obtener un registro según su identificador
     *
     * @param int $id
     * @return ?RaffleDetail
     */
    public function getById(int $id): ?RaffleDetail
    {
        return $this->raffleDetailRepository->find($id);
    }

    /**
     * Use case: Crear un registro
     *
     * @param array $attributes
     * @return RaffleDetail
     */
    public function create(array $attributes): RaffleDetail
    {
        return $this->raffleDetailRepository->store($attributes);
    }

    /**
     * Use case: Actualizar un registro
     *
     * @param RaffleDetail $model
     * @param array $attributes
     * @return RaffleDetail
     */
    public function update(RaffleDetail $model, array $attributes): RaffleDetail
    {
        return $this->raffleDetailRepository->update($model, $attributes);
    }

    /**
     * Use case: Eliminar un registro
     *
     * @param RaffleDetail $model
     * @return RaffleDetail
     */
    public function delete(RaffleDetail $model): RaffleDetail
    {
        return $this->raffleDetailRepository->delete($model);
    }
}