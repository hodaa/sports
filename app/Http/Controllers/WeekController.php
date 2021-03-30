<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWeekRequest;
use App\Http\Resources\WeekResource;
use App\Models\Week;
use App\Http\Requests\WeekRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SeasonRequest;
use Illuminate\Support\Facades\Cache;

class WeekController extends Controller
{

    /**
     * @OA\Get (
     ** path="/api/v1/weeks",
     *   tags={"Weeks"},
     *   operationId="weeks",
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
     * @return Response
     */
    public function index()
    {
        $weeks = Cache::get('seasons', Week::paginate(20));
        return response()->json(["data"=>$weeks]);
    }
    /**
     * @OA\Post  (
     ** path="/api/v1/weeks",
     *   tags={"Weeks"},
     *   operationId="weeks",
     *
     *   @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="season_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *
     *    @OA\Parameter(
     *      name="week",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
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
     * @param WeekRequest $request
     * @return JsonResponse
     */
    public function store(WeekRequest $request): JsonResponse
    {
        $data= $request->input();
        $Week = new Week();
        $Week= $Week->create($data);

        return response()->json([
            "data" => new WeekResource($Week),
            'message'=>"Week created Successfully"
        ], 201);
    }

    /**
     * @OA\Get  (
     ** path="/api/v1/weeks/{id}",
     *   tags={"Weeks"},
     *   summary= "Get Item By ID",
     *   operationId="weeks",
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
        return response()->json(["data" => new WeekResource(Week::find($id))]);
    }

    /**
     * @OA\Put   (
     ** path="/api/v1/weeks/{id}",
     *   tags={"Weeks"},
     *   operationId="weeks",
     *
    @OA\Parameter(
     *      name="title",
     *      in="path",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="season_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *
     *    @OA\Parameter(
     *      name="week",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *
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
     * @param WeekRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateWeekRequest $request, int $id): JsonResponse
    {
        $Week = Week::find($id);
        $Week->update($request->input());
        return response()->json([
            "data" => new WeekResource($Week),
            'message'=>"Week updated Successfully"
        ], 201);
    }

    /**
     * @OA\Delete    (
     ** path="/api/v1/weeks/{id}",
     *   tags={"Weeks"},
     *   operationId="weeks",
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
     *       response=200,
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
        Week::findorFail($id)->delete();
        return response()->json(["message" => "Week deleted successfully"]);
    }
}
