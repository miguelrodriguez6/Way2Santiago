<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // index - Obtener todas las ubicaciones
    public function index(): \Illuminate\Http\JsonResponse
    {
        $locations = Location::all();
        return response()->json([
            'data' => $locations
        ]);
    }

    // store - Crear una nueva ubicación
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Crear la nueva ubicación
        $location = Location::create($validatedData);

        // Responder con la ubicación creada
        return response()->json([
            'message' => 'Location created successfully.',
            'data' => $location
        ], 201);
    }

    // show - Obtener una ubicación por ID
    public function show($id): \Illuminate\Http\JsonResponse
    {
        // Buscar la ubicación por su ID
        $location = Location::find($id);

        // Si no se encuentra la ubicación, devolver error 404
        if (!$location) {
            return response()->json([
                'message' => 'Location not found.'
            ], 404);
        }

        // Responder con los datos de la ubicación
        return response()->json([
            'data' => $location
        ]);
    }

    // update - Actualizar una ubicación por ID
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        // Buscar la ubicación por su ID
        $location = Location::find($id);

        // Si no se encuentra la ubicación, devolver error 404
        if (!$location) {
            return response()->json([
                'message' => 'Location not found.'
            ], 404);
        }

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Actualizar los datos de la ubicación
        $location->update($validatedData);

        // Responder con los datos actualizados
        return response()->json([
            'message' => 'Location updated successfully.',
            'data' => $location
        ]);
    }

    // destroy - Eliminar una ubicación por ID
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        // Buscar la ubicación por su ID
        $location = Location::find($id);

        // Si no se encuentra la ubicación, devolver error 404
        if (!$location) {
            return response()->json([
                'message' => 'Location not found.'
            ], 404);
        }

        // Eliminar la ubicación
        $location->delete();

        // Responder con mensaje de éxito
        return response()->json([
            'message' => 'Location deleted successfully.'
        ]);
    }
}
