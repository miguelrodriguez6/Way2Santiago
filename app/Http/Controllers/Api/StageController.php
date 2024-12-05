<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    // index - Obtener todas las etapas
    public function index(): \Illuminate\Http\JsonResponse
    {
        // Obtener todas las etapas con las relaciones necesarias
        $stages = Stage::with(['creator', 'startLocation', 'endLocation', 'stageComments', 'stageParticipants'])->get();

        return response()->json([
            'data' => $stages
        ]);
    }

    // store - Crear una nueva etapa
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'distance' => 'required|numeric',
            'status' => 'required|in:COMPLETED,PLANNED,AWAITING',
            'user_id_creator' => 'required|exists:users,id',
            'start_location_id' => 'required|exists:locations,id',
            'end_location_id' => 'required|exists:locations,id',
        ]);

        // Crear la nueva etapa
        $stage = Stage::create($validatedData);

        // Cargar las relaciones
        $stage->load(['creator', 'startLocation', 'endLocation', 'stageComments', 'stageParticipants']);

        // Responder con la etapa creada
        return response()->json([
            'message' => 'Stage created successfully.',
            'data' => $stage
        ], 201);
    }

    // show - Obtener una etapa por ID
    public function show($id): \Illuminate\Http\JsonResponse
    {
        // Buscar la etapa por su ID, incluyendo relaciones
        $stage = Stage::with(['creator', 'startLocation', 'endLocation', 'stageComments', 'stageParticipants'])->find($id);

        // Si no se encuentra la etapa, devolver error 404
        if (!$stage) {
            return response()->json([
                'message' => 'Stage not found.'
            ], 404);
        }

        // Responder con los datos de la etapa
        return response()->json([
            'data' => $stage
        ]);
    }

    // update - Actualizar una etapa por ID
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        // Buscar la etapa por su ID
        $stage = Stage::find($id);

        // Si no se encuentra la etapa, devolver error 404
        if (!$stage) {
            return response()->json([
                'message' => 'Stage not found.'
            ], 404);
        }

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'distance' => 'required|numeric',
            'status' => 'required|in:COMPLETED,PLANNED,AWAITING',
            'user_id_creator' => 'required|exists:users,id',
            'start_location_id' => 'required|exists:locations,id',
            'end_location_id' => 'required|exists:locations,id',
        ]);

        // Actualizar los datos de la etapa
        $stage->update($validatedData);

        // Cargar las relaciones actualizadas
        $stage->load(['creator', 'startLocation', 'endLocation', 'stageComments', 'stageParticipants']);

        // Responder con la etapa actualizada
        return response()->json([
            'message' => 'Stage updated successfully.',
            'data' => $stage
        ]);
    }

    // destroy - Eliminar una etapa por ID
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        // Buscar la etapa por su ID
        $stage = Stage::find($id);

        // Si no se encuentra la etapa, devolver error 404
        if (!$stage) {
            return response()->json([
                'message' => 'Stage not found.'
            ], 404);
        }

        // Eliminar la etapa
        $stage->delete();

        // Responder con mensaje de éxito
        return response()->json([
            'message' => 'Stage deleted successfully.'
        ]);
    }
}
