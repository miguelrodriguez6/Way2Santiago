<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StageComments;
use Illuminate\Http\Request;

class StageCommentsController extends Controller
{
    // Listar todos los comentarios
    public function index(): \Illuminate\Http\JsonResponse
    {
        $comments = StageComments::with(['user', 'stage'])->get();

        return response()->json([
            'message' => 'Stage comments retrieved successfully.',
            'data' => $comments
        ]);
    }

    // Crear un nuevo comentario
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'message' => 'required|string|max:1000',
            'send_at' => 'required|date',
            'stage_id' => 'required|exists:stages,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $comment = StageComments::create($validatedData);

        return response()->json([
            'message' => 'Stage comment created successfully.',
            'data' => $comment
        ], 201);
    }

    // Mostrar un comentario específico
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $comment = StageComments::with(['user', 'stage'])->find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Stage comment not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Stage comment retrieved successfully.',
            'data' => $comment
        ]);
    }

    // Actualizar un comentario
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $comment = StageComments::find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Stage comment not found.'
            ], 404);
        }

        $validatedData = $request->validate([
            'message' => 'required|string|max:1000',
            'send_at' => 'required|date',
            'stage_id' => 'required|exists:stages,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $comment->update($validatedData);

        return response()->json([
            'message' => 'Stage comment updated successfully.',
            'data' => $comment
        ]);
    }

    // Eliminar un comentario
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $comment = StageComments::find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Stage comment not found.'
            ], 404);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Stage comment deleted successfully.'
        ]);
    }
}
