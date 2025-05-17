<?php

namespace App\Repository\Interface;

interface RaffleRepositoryInterface
{
    public function find($id);
    public function filter(array $attributes, int $paginate);
    public function store(array $attributes);
    public function update(object $model, array $attributes);
    public function delete(object $model);
}