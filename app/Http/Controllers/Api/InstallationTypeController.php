<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateInstallationTypeRequest;
use App\Models\InstallationType;
use Illuminate\Http\{JsonResponse, Response};

/**
 * @OA\Schema(
 *   schema="InstallationType",
 *   type="object",
 *   required={"id", "item"},
 *   @OA\Property(property="item", type="string", example="Laje")
 * )
 */
class InstallationTypeController extends Controller
{

    /**
    * @OA\Get(
    *     path="/api/install_type",
    *     summary="List install type with pagination.",
    *     tags={"InstallationType"},
    *     @OA\Response(
    *         response=200,
    *         description="Install type successfully returned",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="data", type="array",
    *                 @OA\Items(ref="#/components/schemas/InstallationType")
    *             ),
    *             @OA\Property(property="links", type="object"),
    *             @OA\Property(property="meta", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="No Installation type found"
    *     )
    * )
    */

   public function index(): JsonResponse
   {
       $install_type = InstallationType::paginate();
       if ($install_type->isEmpty()) {
           return response()->json([], Response::HTTP_NO_CONTENT);
       }
       return response()->json($install_type, Response::HTTP_OK);
   }

   /**
    * @OA\Post(
    *     path="/api/install_type",
    *     summary="Create a new Installation type",
    *     tags={"InstallationType"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 type="object",
    *                 required={"item"},
    *                 @OA\Property(property="item", type="string", example="Laje"),
 
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="New install type created",
    *         @OA\JsonContent(ref="#/components/schemas/InstallationType")
    *     ), 
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     )
    * )
    */
   public function store(StoreUpdateInstallationTypeRequest $request)
   {
       $install_type = new InstallationType;
       $install_type->item = $request->item;
       $install_type->save();

       return response()->json([
           'message' => 'New Installation type created!'
       ], Response::HTTP_CREATED);

   }

   /**
    * @OA\Get(
    *     path="/api/install_type/{id}",
    *     summary="Show a specific Installation type",
    *     tags={"InstallationType"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID Installation type",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Installation type successfully found",
    *         @OA\JsonContent(ref="#/components/schemas/InstallationType")
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Installation type not found"
    *     )
    * )
    */
   public function show(string $id)
   {
       $install_type = InstallationType::find($id);
       if (!$install_type) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }
       
       return response()->json($install_type, Response::HTTP_OK);
   }

   /**
    * @OA\Put(
    *     path="/api/install_type/{ID}",
    *     summary="Update a Installation type",
    *     tags={"InstallationType"},
    *         @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID Installation type",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 type="object",
    *                 required={"id", "item"},
    *                 @OA\Property(property="id", type="string", example="3"),
    *                 @OA\Property(property="name", type="string", example="Campo"),
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Installation type successfully updated",
    *         @OA\JsonContent(ref="#/components/schemas/InstallationType")
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     )
    * )
    */
   public function update(StoreUpdateInstallationTypeRequest $request, string $id)
   {
       if (!$install_type = InstallationType::find($id)) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }
       $install_type->item = $request->item;
       $install_type->save();

       return response()->json([
           'message' => 'Install type updated!'
       ], Response::HTTP_OK);

   }

   /**
    * @OA\Delete(
    *     path="/api/install_type/{id}",
    *     summary="Delete a specific installation type",
    *     tags={"InstallationType"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Delete id install type",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="Install type successfully deleted"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Install type not found"
    *     )
    * )
    */
   public function destroy(string $id)
   {
       if (!$install_type = InstallationType::find($id)) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }
       $install_type->delete();
       return response()->json([
           'message' => 'Install type deleted!'
       ], Response::HTTP_OK);
   }
}
