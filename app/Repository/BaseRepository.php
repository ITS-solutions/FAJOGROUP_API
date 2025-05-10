<?php

namespace App\Repository;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
	/**
	* @var Model
	*/
	protected $model;

	/**
	* BaseRepository constructor.
	*
	* @param Model $model
	*/
	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
    * @param array $attributes
    *
    * @return Model
    */
	public function store(array $attributes): Model
	{
		return $this->model->create($attributes);
	}

	/**
	* @param $id
	* @return Collection
	*/
	public function find($id): ?Collection
	{
		return $this->model->find($id);
	}
}
