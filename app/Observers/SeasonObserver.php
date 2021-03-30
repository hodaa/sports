<?php

namespace App\Observers;

use App\Models\Season;
use App\Services\Caching\CacheService;

class SeasonObserver
{
    private $cacheService;

    public function __construct()
    {
        $this->cacheService = new CacheService(new Season());
    }

    /**
     * Handle the white list ip "created".
     * @throws Exception
     */
    public function created()
    {
        $this->cacheService->reWriteCachedData("seasons");
    }


    /**
     * @throws Exception
     */
    public function updated()
    {
        $this->cacheService->reWriteCachedData('seasons');
    }


    /**
     * Handle the white list ip "deleted" .
     * @throws Exception
     */
    public function deleted()
    {
        $this->cacheService->reWriteCachedData('seasons');
    }
}
