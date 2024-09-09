<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\{Request, Response, JsonResponse};

/**
 * @OA\Info(
 *   title="API Solar Energy Project Documentation",
 *   version="1.0.0",
 *   description="Solar energy project management."
 * )
 *
 * @OA\Schema(
 *   schema="Project",
 *   type="object",
 *   required={"id", "name", "client_id", "install_type_id", "region", "equipment"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="client_id", type="integer", example=1),
 *   @OA\Property(property="install_type_id", type="integer", example=1),
 *   @OA\Property(property="name", type="string", example="Projeto Solar"),
 *   @OA\Property(property="region", type="string", example="SP"),
 *   @OA\Property(property="equipment", type="array",  
 *      @OA\Items( type="object", 
 *          @OA\Property(property="id", type="integer", example=1),
 *          @OA\Property(property="amount", type="integer", example=2)
 *     )
 *   )
 * )
 */

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="List projects with filters and pagination.",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="client_id",
     *         in="query",
     *         description="Filter by customer id",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by project name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="region",
     *         in="query",
     *         description="Filter by project region",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project list successfully returned",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Project")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No projects found"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $projects = Project::filter($request)->paginate(20);
        if ($projects->isEmpty()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        return response()->json($projects, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Create a new project",
     *     tags={"Projects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name", "client_id", "install_type_id", "region", "equipment"},
     *                 @OA\Property(property="name", type="string", example="Novo Projeto"),
     *                 @OA\Property(property="client_id", type="integer", example=1),
     *                 @OA\Property(property="install_type_id", type="integer", example=1),
     *                 @OA\Property(property="region", type="string", example="SP"),
     *                 @OA\Property(
     *                     property="equipment",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="amount",
     *                             type="integer",
     *                             example=2
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="New project created",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreUpdateProjectRequest $request)
    {
        $project = new Project;
        $project->name = $request->name;
        $project->client_id = $request->client_id;
        $project->install_type_id = $request->install_type_id;
        $project->region = $request->region;
        $project->save();

        foreach($request->equipment as $item){
            $project->equipment()->attach($item['id'], ['amount' => $item['amount']]);
        }

        return response()->json([
            'message' => 'New project created!'
        ], Response::HTTP_CREATED);

    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Show a specific project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project successfully found",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $project = Project::with('equipment')
            ->with('client:id,name,email,phone,document,created_at,updated_at')->find($id);
        if (!$project) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }
        
        return response()->json($project, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{ID}",
     *     summary="Update a project",
     *     tags={"Projects"},
     *         @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name", "client_id", "install_type_id", "region", "equipment"},
     *                 @OA\Property(property="name", type="string", example="Atualizando Projeto"),
     *                 @OA\Property(property="client_id", type="integer", example=1),
     *                 @OA\Property(property="install_type_id", type="integer", example=1),
     *                 @OA\Property(property="region", type="string", example="SP"),
     *                 @OA\Property(
     *                     property="equipment",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="amount",
     *                             type="integer",
     *                             example=2
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(StoreUpdateProjectRequest $request, string $id)
    {
        if (!$project = Project::find($id)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }
        $project->name = $request->name;
        $project->client_id = $request->client_id;
        $project->install_type_id = $request->install_type_id;
        $project->region = $request->region;
        $project->save();

        $items = [];
        foreach($request->equipment as $item){
            $items[$item['id']] = ['amount' => $item['amount']];
        }

        $project->equipment()->sync($items);
        return response()->json([
            'message' => 'Project updated!'
        ], Response::HTTP_OK);

    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Delete a specific project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Project successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        if (!$project = Project::with('equipment')->find($id)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }
        //devido ao uso do softDelete o detach nao e necessario
        //$project->equipment()->detach(); 
        $project->delete();
        return response()->json([
            'message' => 'Project deleted!'
        ], Response::HTTP_OK);
    }
}
