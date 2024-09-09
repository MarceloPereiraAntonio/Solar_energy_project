<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\{JsonResponse, Response};

/**
 * @OA\Schema(
 *   schema="Client",
 *   type="object",
 *   required={"id", "name", "email", "phone", "document"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="name", type="string", example="Marcelo"),
 *   @OA\Property(property="email", type="string", example="marcelo@teste.com"),
 *   @OA\Property(property="phone", type="string", example="11981847045"),
 *   @OA\Property(property="document", type="string", example="12345678912"),
 * )
 */
class ClientController extends Controller
{

/**
* @OA\Get(
*     path="/api/client",
*     summary="List clients with filters and pagination.",
*     tags={"Client"},
*     @OA\Response(
*         response=200,
*         description="Client list successfully returned",
*         @OA\JsonContent(
*             type="object",
*             @OA\Property(property="data", type="array",
*                 @OA\Items(ref="#/components/schemas/Client")
*             ),
*             @OA\Property(property="links", type="object"),
*             @OA\Property(property="meta", type="object")
*         )
*     ),
*     @OA\Response(
*         response=204,
*         description="No client found"
*     )
* )
*/
   public function index(): JsonResponse
   {
       $clients = Client::paginate();
       if ($clients->isEmpty()) {
           return response()->json([], Response::HTTP_NO_CONTENT);
       }
       return response()->json($clients, Response::HTTP_OK);
   }

   /**
    * @OA\Post(
    *     path="/api/client",
    *     summary="Create a new project",
    *     tags={"Client"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 type="object",
    *                 required={"name", "email", "phone", "document"},
    *                 @OA\Property(property="name", type="string", example="Marcelo"),
    *                 @OA\Property(property="email", type="string", example="marcelo@teste.com"),
    *                 @OA\Property(property="phone", type="string", example="11981847044"),
    *                 @OA\Property(property="document", type="string", example="48704357898"),
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="New client created",
    *         @OA\JsonContent(ref="#/components/schemas/Client")
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     )
    * )
    */
   public function store(StoreUpdateClientRequest $request)
   {
       $client = new Client;
       $client->name = $request->name;
       $client->email = $request->email;
       $client->phone = $request->phone;
       $client->document = $request->document;
       $client->save();

       return response()->json([
           'message' => 'New client created!'
       ], Response::HTTP_CREATED);

   }

   /**
    * @OA\Get(
    *     path="/api/client/{id}",
    *     summary="Show a specific Client",
    *     tags={"Client"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID Client",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Client successfully found",
    *         @OA\JsonContent(ref="#/components/schemas/Client")
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Client not found"
    *     )
    * )
    */
   public function show(string $id)
   {
       $client = Client::find($id);
       if (!$client) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }
       
       return response()->json($client, Response::HTTP_OK);
   }

   /**
    * @OA\Put(
    *     path="/api/client/{ID}",
    *     summary="Update a client",
    *     tags={"Client"},
    *         @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID client",
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
    *         description="Client successfully updated",
    *         @OA\JsonContent(ref="#/components/schemas/Client")
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     )
    * )
    */
   public function update(StoreUpdateClientRequest $request, string $id)
   {
       if (!$client = Client::find($id)) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }
       $client->name = $request->name;
       $client->email = $request->email;
       $client->phone = $request->phone;
       $client->document = $request->document;
       $client->save();

       return response()->json([
           'message' => 'Client updated!'
       ], Response::HTTP_OK);

   }

   /**
    * @OA\Delete(
    *     path="/api/client/{id}",
    *     summary="Delete a specific Client",
    *     tags={"Client"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID Client",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="Client successfully deleted"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Client not found"
    *     )
    * )
    */
   public function destroy(string $id)
   {
       if (!$client = Client::with('projects')->find($id)) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }
       foreach($client->projects as $project){
           $project->delete();

       }
       $client->delete();
       return response()->json([
           'message' => 'Client deleted!'
       ], Response::HTTP_OK);
   }
}
