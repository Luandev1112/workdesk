<?php

namespace App\Repositories;

interface AbstractInterface
{
    public function getAll();

    public function getPaginated($limit = 10);

    public function getById($id);

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);
}
