<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchRequest;
use App\Http\Resources\MatchResource;
use App\Models\Match;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Illuminate\Support\Facades\Cache;

class MatchController extends Controller
{
    /**
     * @OA\Get (
     ** path="/api/v1/matches",
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
            $query->join('weeks', 'weeks.id', '=', 'matches.week_id')
                ->where('weeks.week', $request->week);
        }
        if ($request->year) {
            if (!$request->week) {
                $query->join('weeks', 'weeks.id', '=', 'matches.week_id');
            }
            $query->join('seasons', 'seasons.id', '=', 'weeks.season')
                ->where('seasons.year', $request->year);
        }

        return response()->json(["data"=> MatchResource::collection($query->get())]);
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
            $image = $request->file('image');
            $name = time().".".$image->getClientOriginalExtension();
            $path= '/images/matches';
            $image->move(public_path($path), $name, 0777, true);
            $data['image']= $path."/".$name;
        }
        $match= $match->create($data);

        return response()->json([
            "data" => new MatchResource($match),
            'message'=>"Match created Successfully"
        ], 201);
    }


    /**
     * @OA\Get  (
     ** path="/api/v1/Matchs/",
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

     *      @OA\Parameter(
     *      name="week",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="video",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="image",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="file"
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
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return response()->json(["data" => new MatchResource(Match::find($id))]);
    }

    /**
     * @OA\Put   (
     ** path="/api/v1/Matchs/1",
     *   tags={"Matches"},
     *   operationId="Matchs",
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
        $Match = Match::findOrFail($id);
        $Match->update($request->input());
        return response()->json([
            "data" => new MatchResource($Match),
            'message'=>"Match updated Successfully"
        ], 201);
    }


    /**
     * @OA\Delete    (
     ** path="/api/v1/matchs/1",
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
        return response()->json(["data" => "Match deleted successfully"]);
    }
    /**
     * @OA\Get (
     ** path="/api/v1/matches",
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
            ->groupBy('seasons.year', 'matches.id')
            ->get();
         return response()->json($matches);
    }
}
