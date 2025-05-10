<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
	/**
	 * @param array $attributes
	 * @return Model
	 */
	public function store(array $attributes): Model;

	/**
	 * @param $id
	 * @return Collection
	 */
	public function find($id): ?Collection;
}
