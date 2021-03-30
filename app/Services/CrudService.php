<?php

namespace App\Services;

use App\Contracts\CrudInterface;
use Illuminate\Database\Eloquent\Model;

class CrudService implements CrudInterface
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        return $this->model->create($data);
    }
    public function create($data)
    {
        return $this->model->create($data);
    }
    public function update($data, $id)
    {
        return $this->model->create($data);
    }
    public function store($data)
    {
        return $this->model->create($data);
    }
    public function show($id)
    {
    }
    public function destroy($id)
    {
    }
}
