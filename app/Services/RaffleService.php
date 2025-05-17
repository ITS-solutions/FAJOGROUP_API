<?php

namespace App\Services;

use App\Models\Raffle;
use App\Repository\Interface\RaffleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RaffleService
{
    public function __construct(
        protected RaffleRepositoryInterface $raffleRepository
    ) {}

    /**
     * Use case: Obtener todos los registros según criterio de filtros y con paginación
     *
     * @param array $attributes
     * @param int   $paginate
     * @return LengthAwarePaginator<Raffle>
     */
    public function filterWithPaginate(array $attributes, int $paginate): LengthAwarePaginator
    {
        return $this->raffleRepository->filter($attributes, $paginate);
    }

    /**
     * Use case: Obtener un registro según su identificador
     *
     * @param int $id
     * @return ?Raffle
     */
    public function getById(int $id): ?Raffle
    {
        return $this->raffleRepository->find($id);
    }

    /**
     * Use case: Crear un registro
     *
     * @param array $attributes
     * @return Raffle
     */
    public function create(array $attributes): Raffle
    {
        return $this->raffleRepository->store($attributes);
    }

    /**
     * Use case: Actualizar un registro
     *
     * @param Raffle $model
     * @param array $attributes
     * @return Raffle
     */
    public function update(Raffle $model, array $attributes): Raffle
    {
        return $this->raffleRepository->update($model, $attributes);
    }

    /**
     * Use case: Eliminar un registro
     *
     * @param Raffle $model
     * @return Raffle
     */
    public function delete(Raffle $model): Raffle
    {
        return $this->raffleRepository->delete($model);
    }
}