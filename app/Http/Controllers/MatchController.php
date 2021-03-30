<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchRequest;
use App\Http\Resources\MatchResource;
use App\Models\Match;
use App\Services\MatchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Services\CrudService;

class MatchController extends Controller
{
    private $crudService;
    private $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->crudService = new CrudService(new Match());
        $this->matchService = $matchService;
    }
    /**
     * @OA\Get (
     ** path="/api/v1/matches/",
     *   tags={"Matches"},
     *   operationId="matches",
     *

     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *   ),
     *
     *     @OA\Parameter(
     *      name="week",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="year",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer"
     *      )
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = new Match();

        if ($request->week) {
            $query = $this->matchService->filterByWeek($query, $request->week);
        }
        if ($request->year) {
            $query = $this->matchService->filterByYear($query, $request->year, $request->week);
        }

        return response()->json(["data"=> MatchResource::collection($query->paginate(20))]);
    }

    /**
     * @OA\Post  (
     ** path="/api/v1/matches",
     *   tags={"Matches"},
     *   operationId="Matchs",
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
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="image",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="file"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="video",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *    * @OA\Parameter(
     *      name="week_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *       response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
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
     * @param Request $request
     * @return Response
     * @throws FileException
     */
    public function store(MatchRequest $request): JsonResponse
    {
        $data= $request->input();
        $match = new Match();

        if ($request->hasFile('image')) {
            $data['image'] = $this->matchService->uploadImage($request->file('image'));
        }

        $match= $match->create($data);

        return response()->json([
            "data" => new MatchResource($match),
            'message'=>"Match created Successfully"
        ], 201);
    }


    /**
     * @OA\Get  (
     ** path="/api/v1/matches/{id}",
     *   tags={"Matches"},
     *   operationId="Matchs",
     *
     *     @OA\Parameter(
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
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
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
    public function show($id): JsonResponse
    {
        return response()->json(["data" => new MatchResource(Match::findOrFail($id))]);
    }

    /**
     * @OA\Put   (
     ** path="/api/v1/matches/{id}",
     *   tags={"Matches"},
     *   operationId="Matchs",
     *
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
     *      name="title",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="image",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="file"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="video",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *    * @OA\Parameter(
     *      name="week_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *       response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
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
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->input();
        $match = Match::findOrFail($id);

        if ($request->hasFile('image')) {
            $data['image'] = $this->matchService->uploadImage($request->file('image'));
        }
        $match->update($data);
        return response()->json([
            "data" => new MatchResource($match),
            'message'=>"Match updated Successfully"
        ], 201);
    }


    /**
     * @OA\Delete    (
     ** path="/api/v1/matches/{id}",
     *   tags={"Matches"},
     *   operationId="Matchs",
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
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
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
     * @return Response
     */
    public function destroy(int $id): JsonResponse
    {
        Match::findorFail($id)->delete();
        return response()->json(["message" => "Match deleted successfully"]);
    }
    /**
     * @OA\Get (
     ** path="/api/v1/matches-by-year",
     *   tags={"Matches"},
     *   operationId="matches",
     *

     *   @OA\Response(
     *      response=200,
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
     * @return JsonResponse
     */
    public function getMatchesByYear(): JsonResponse
    {
         $matches = Match::join('weeks', 'weeks.id', '=', 'matches.week_id')
            ->join('seasons', 'seasons.id', 'weeks.season_id')
             ->select('seasons.year', 'matches.id', 'matches.title')
            ->groupBy('seasons.year')
            ->select('seasons.year')
            ->selectRaw("count(matches.id) as matches_count")
             ->get();

         return response()->json(["data"=>$matches]);
    }
}
