<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeasonResource;
use App\Models\Season;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SeasonRequest;
use Illuminate\Support\Facades\Cache;

class SeasonController extends Controller
{

    /**
     * @OA\Get (
     ** path="/api/v1/seasons",
     *  summary ="Get all Items",
     *  tags={"Seasons"},
     *   operationId="seasons",
     *

     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *   ),

     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
         $seasons = Cache::get('seasons', Season::paginate(20));
         return response()->json(["data"=>$seasons]);
    }
    /**
     * @OA\Post  (
     ** path="/api/v1/seasons",

     *   tags={"Seasons"},
     *   operationId="seasons",
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="year",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *       response=201,
     *       description="Success",
     *   ),
     *
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

    /**
     * Store a newly created resource in storage.
     *
     * @param SeasonRequest $request
     * @return JsonResponse
     */
    public function store(SeasonRequest $request): JsonResponse
    {


        $data= $request->input();
        $season = new Season();
        $season= $season->create($data);

        return response()->json([
            "data" => new SeasonResource($season),
            'message'=>"Season created Successfully"
        ], 201);
    }

    /**
     * @OA\Get  (
     ** path="/api/v1/seasons/",
     *  summary ="Get item by id",
     *   tags={"Seasons"},
     *   operationId="seasons",
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),

     *   @OA\Response(
     *       response=201,
     *       description="Success",
     *   ),
     *
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(["data" => new SeasonResource(Season::find($id))]);
    }

    /**
     * @OA\Put   (
     ** path="/api/v1/seasons/{id}",
     *   tags={"Seasons"},
     *   operationId="seasons",
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="year",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *       response=201,
     *       description="Success",
     *   ),
     *
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {

        $season = Season::findOrFail($id);
        $season->update($request->input());
        return response()->json([
            "data" => new SeasonResource($season),
            'message'=>"Season updated Successfully"
        ], 201);
    }

    /**
     * @OA\Delete    (
     ** path="/api/v1/seasons/{id}",
     *   tags={"Seasons"},
     *   operationId="seasons",
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *       response=201,
     *       description="Success",
     *   ),
     *
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
         Season::findorFail($id)->delete();
         return response()->json(["message" => "Season deleted successfully"]);
    }
}
