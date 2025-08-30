<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all accommodations
        $accommodations = Accommodation::all();

        return response()->json($accommodations, 200); // 200 OK
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'country'     => 'required|string|max:255',
            'link'        => 'nullable|url|max:255',
        ]);

        $accommodation = Accommodation::create($validated);

        return response()->json($accommodation, 201); // 201 Created
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accommodation $accommodation)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'address'     => 'sometimes|required|string|max:255',
            'city'        => 'sometimes|required|string|max:255',
            'country'     => 'sometimes|required|string|max:255',
            'link'        => 'sometimes|nullable|url|max:255',
        ]);

        $accommodation->update($validated);

        return response()->json($accommodation); // 200 OK
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accommodation $accommodation)
    {
        $accommodation->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
