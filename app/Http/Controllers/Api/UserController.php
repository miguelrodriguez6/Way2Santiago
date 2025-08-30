<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $users = User::all();

            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No users found.'
                ], 404);
            }

            return response()->json([
                'data' => $users
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving users.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Validación de los datos entrantes
            $validatedData = $request->validate([
                'username' => 'required|unique:users|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
//                'description' => 'nullable|max:500',
//                'date_of_birth' => 'required|date',
//                'nationality' => 'required|max:255',
//                'role' => 'required|in:ADMIN,DEFAULT',
            ]);

            // Crear el usuario en la base de datos
            $user = User::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
//                'description' => $validatedData['description'] ?? null,
                'description' => null,
                'date_of_birth' => null,
                'nationality' => null,
                'role' => 'DEFAULT',
//                'role' => $validatedData['role'],
            ]);

            // Si la creación es exitosa, devolver una respuesta de éxito en formato JSON
            return response()->json([
                'message' => 'User created successfully.',
                'data' => $user
            ], 201); // Código 201 para indicar que se ha creado un recurso

        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver un mensaje de error
            return response()->json([
                'message' => 'An error occurred while creating the user.',
                'error' => $e->getMessage()
            ], 500); // Código 500 para error del servidor
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        // Buscar el usuario por su ID
        $user = User::find($id);

        // Si no se encuentra el usuario, devolver error 404
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        // Devolver el usuario encontrado
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'Not implemented yet.'
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        // Buscar el usuario por su ID
        $user = User::find($id);

        // Si no se encuentra el usuario, devolver error 404
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        // Eliminar el usuario
        $user->delete();

        // Devolver la respuesta de eliminación exitosa
        return response()->json([
            'message' => 'User deleted successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Validación de los datos entrantes
            $validatedData = $request->validate([
                'username' => 'required|unique:users|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255'
            ]);

            // Crear el usuario en la base de datos
            $user = User::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'description' => null,
                'date_of_birth' => null,
                'nationality' => null,
                'role' => 'DEFAULT',
            ]);

            // Si la creación es exitosa, devolver una respuesta de éxito en formato JSON
            return response()->json([
                'message' => 'User created successfully.',
                'data' => $user
            ], 201); // Código 201 para indicar que se ha creado un recurso

        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver un mensaje de error
            return response()->json([
                'message' => 'An error occurred while creating the user.',
                'error' => $e->getMessage()
            ], 500); // Código 500 para error del servidor
        }
    }
}
