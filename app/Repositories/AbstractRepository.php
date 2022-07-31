<?php

namespace App\Repositories;

class AbstractRepository implements AbstractInterface
{
    public function getAll()
    {
        return $this->model->latest()->all();
    }

    public function getPaginated($limit = 10)
    {
        return $this->model->latest()->paginate($limit);
    }

    public function getById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->model->where('id', $id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
