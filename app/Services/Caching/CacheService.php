<?php

namespace App\Services\Caching;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    private $model;

    /**
     * CacheService constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $cache_key
     */
    public function reWriteCachedData($cache_key)
    {
        Cache::forever($cache_key, $this->model::all());
    }

}
