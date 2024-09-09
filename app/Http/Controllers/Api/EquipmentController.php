<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEquipment;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *   schema="Equipment",
 *   type="object",
 *   required={"item"},
 *   @OA\Property(property="item", type="string", example="Estrutura"),
 * )
 */

class EquipmentController extends Controller
{
       /**
    * @OA\Get(
    *     path="/api/equipment",
    *     summary="List equipment with filters and pagination.",
    *     tags={"Equipment"},
    *     @OA\Response(
    *         response=200,
    *         description="Equipment list successfully returned",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="data", type="array",
    *                 @OA\Items(ref="#/components/schemas/Equipment")
    *             ),
    *             @OA\Property(property="links", type="object"),
    *             @OA\Property(property="meta", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="No equipment found"
    *     )
    * )
    */

   public function index(): JsonResponse
   {
       $equipment = Equipment::paginate();
       if ($equipment->isEmpty()) {
           return response()->json([], Response::HTTP_NO_CONTENT);
       }
       return response()->json($equipment, Response::HTTP_OK);
   }

   /**
    * @OA\Post(
    *     path="/api/equipment",
    *     summary="Create a new Equipment",
    *     tags={"Equipment"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 type="object",
    *                 required={"item"},
    *                 @OA\Property(property="item", type="string", example="Fita de Aterramento")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="New equipment created",
    *         @OA\JsonContent(ref="#/components/schemas/Equipment")
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     )
    * )
    */
   public function store(StoreUpdateEquipment $request)
   {
       $equipment = new Equipment;
       $equipment->item = $request->item;
       $equipment->save();

       return response()->json([
           'message' => 'New equipment created!'
       ], Response::HTTP_CREATED);

   }

   /**
    * @OA\Get(
    *     path="/api/equipment/{id}",
    *     summary="Show a specific Equipment",
    *     tags={"Equipment"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID Equipment",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Equipment successfully found",
    *         @OA\JsonContent(ref="#/components/schemas/Equipment")
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Equipment not found"
    *     )
    * )
    */
   public function show(string $id)
   {
       $equipment = Equipment::find($id);
       if (!$equipment) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }
       
       return response()->json($equipment, Response::HTTP_OK);
   }

   /**
    * @OA\Put(
    *     path="/api/equipment/{ID}",
    *     summary="Update a equipment",
    *     tags={"Equipment"},
    *         @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID equipment",
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
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="item", type="integer", example="Parafusos"),
    *       
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Equipment successfully updated",
    *         @OA\JsonContent(ref="#/components/schemas/Equipment")
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     )
    * )
    */
   public function update(StoreUpdateEquipment $request, string $id)
   {
       if (!$equipment = Equipment::find($id)) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }
       $equipment->item = $request->item;
       $equipment->save();

       return response()->json([
           'message' => 'Equipment updated!'
       ], Response::HTTP_OK);

   }

   /**
    * @OA\Delete(
    *     path="/api/equipment/{id}",
    *     summary="Delete a specific Equipment",
    *     tags={"Equipment"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID Equipment",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="Equipment successfully deleted"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Equipment not found"
    *     )
    * )
    */
   public function destroy(string $id)
   {
       if (!$equipment = Equipment::find($id)) {
           return response()->json([], Response::HTTP_NOT_FOUND);
       }

       $equipment->delete();
       return response()->json([
           'message' => 'Equipment deleted!'
       ], Response::HTTP_OK);
   }
}
