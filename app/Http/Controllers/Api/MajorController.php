<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MajorResource;
use App\Models\Major;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * GET /api/majors
     */
    public function index(): JsonResponse
    {
        $majors = Major::withCount('students')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data'    => MajorResource::collection($majors),
        ]);
    }

    /**
     * POST /api/majors  (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:10|unique:majors',
            'name'        => 'required|string|max:100',
            'faculty'     => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $major = Major::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Major created successfully.',
            'data'    => new MajorResource($major),
        ], 201);
    }

    /**
     * GET /api/majors/{id}
     */
    public function show(Major $major): JsonResponse
    {
        $major->loadCount('students');

        return response()->json([
            'success' => true,
            'data'    => new MajorResource($major),
        ]);
    }

    /**
     * PUT /api/majors/{id}  (Admin only)
     */
    public function update(Request $request, Major $major): JsonResponse
    {
        $validated = $request->validate([
            'code'        => 'sometimes|string|max:10|unique:majors,code,' . $major->id,
            'name'        => 'sometimes|string|max:100',
            'faculty'     => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $major->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Major updated successfully.',
            'data'    => new MajorResource($major),
        ]);
    }

    /**
     * DELETE /api/majors/{id}  (Admin only)
     */
    public function destroy(Major $major): JsonResponse
    {
        if ($major->students()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete major with existing students.',
            ], 422);
        }

        $major->delete();

        return response()->json([
            'success' => true,
            'message' => 'Major deleted successfully.',
        ]);
    }
}
