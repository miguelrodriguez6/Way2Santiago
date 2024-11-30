<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StageParticipants;
use Illuminate\Http\Request;

class StageParticipantsController extends Controller
{
    // Listar todos los participantes
    public function index(): \Illuminate\Http\JsonResponse
    {
        $participants = StageParticipants::with(['user', 'stage'])->get();

        return response()->json([
            'message' => 'Stage participants retrieved successfully.',
            'data' => $participants
        ]);
    }

    // Crear un nuevo participante
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'user_id' => 'required|exists:users,id',
            'joined_at' => 'required|date',
        ]);

        $participant = StageParticipants::create($validatedData);

        return response()->json([
            'message' => 'Stage participant added successfully.',
            'data' => $participant
        ], 201);
    }

    // Mostrar un participante específico
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $participant = StageParticipants::with(['user', 'stage'])->find($id);

        if (!$participant) {
            return response()->json([
                'message' => 'Stage participant not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Stage participant retrieved successfully.',
            'data' => $participant
        ]);
    }

    // Actualizar un participante
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $participant = StageParticipants::find($id);

        if (!$participant) {
            return response()->json([
                'message' => 'Stage participant not found.'
            ], 404);
        }

        $validatedData = $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'user_id' => 'required|exists:users,id',
            'joined_at' => 'required|date',
        ]);

        $participant->update($validatedData);

        return response()->json([
            'message' => 'Stage participant updated successfully.',
            'data' => $participant
        ]);
    }

    // Eliminar un participante
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $participant = StageParticipants::find($id);

        if (!$participant) {
            return response()->json([
                'message' => 'Stage participant not found.'
            ], 404);
        }

        $participant->delete();

        return response()->json([
            'message' => 'Stage participant deleted successfully.'
        ]);
    }
}
