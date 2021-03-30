<?php

namespace  App\Contracts;

use App\Http\Requests\Request;

interface CrudInterface
{
    public function index();
    public function store($request);
    public function show($id);
    public function update($request, $id);
    public function destroy($id);
}
