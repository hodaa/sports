<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Documention for Sports League APIs",
     *      description="Documention for Sports League API",
     *      @OA\Contact(
     *          email="hoda.hussin@gmail.com"
     *      ),
     *
     * )
     *
     *
     *
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
