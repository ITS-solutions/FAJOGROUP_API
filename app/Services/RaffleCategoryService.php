<?php

namespace App\Services;

use App\Models\RaffleCategory;
use App\Repository\Interface\RaffleCategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RaffleCategoryService
{
    public function __construct(
        protected RaffleCategoryRepositoryInterface $raffleCategoryRepository
    ) {}

    /**
     * Use case: Obtener todos los registros según criterio de filtros y con paginación
     *
     * @param array $attributes
     * @param int   $paginate
     * @return LengthAwarePaginator<RaffleCategory>
     */
    public function filterWithPaginate(array $attributes, int $paginate): LengthAwarePaginator
    {
        return $this->raffleCategoryRepository->filter($attributes, $paginate);
    }

    /**
     * Use case: Obtener un registro según su identificador
     *
     * @param int $id
     * @return ?RaffleCategory
     */
    public function getById(int $id): ?RaffleCategory
    {
        return $this->raffleCategoryRepository->find($id);
    }

    /**
     * Use case: Crear un registro
     *
     * @param array $attributes
     * @return RaffleCategory
     */
    public function create(array $attributes): RaffleCategory
    {
        return $this->raffleCategoryRepository->store($attributes);
    }

    /**
     * Use case: Actualizar un registro
     *
     * @param RaffleCategory $model
     * @param array $attributes
     * @return RaffleCategory
     */
    public function update(RaffleCategory $model, array $attributes): RaffleCategory
    {
        return $this->raffleCategoryRepository->update($model, $attributes);
    }

    /**
     * Use case: Eliminar un registro
     *
     * @param RaffleCategory $model
     * @return RaffleCategory
     */
    public function delete(RaffleCategory $model): RaffleCategory
    {
        return $this->raffleCategoryRepository->delete($model);
    }
}