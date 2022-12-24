<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface RepositoryInterface {

    /**
     * @param Request $request
     */
    public function make(Request $request);

    /**
     * @param Model $model
     * @return mixed
     */
    public function store(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function save(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function update(Model $model);
}
