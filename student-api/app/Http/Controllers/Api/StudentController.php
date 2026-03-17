<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * List students with search, filter & pagination.
     * GET /api/students
     *
     * Query params:
     *   search   - string  (name, NIM, email)
     *   status   - active | inactive | graduated | dropout
     *   major_id - integer
     *   gender   - male | female
     *   per_page - integer (default 10, max 50)
     *   sort_by  - name | nim | gpa | semester | created_at (default created_at)
     *   sort_dir - asc | desc (default desc)
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->get('per_page', 10), 50);
        $sortBy  = in_array($request->sort_by, ['name', 'nim', 'gpa', 'semester', 'created_at'])
                    ? $request->sort_by : 'created_at';
        $sortDir = $request->sort_dir === 'asc' ? 'asc' : 'desc';

        $students = Student::with('major')
            ->search($request->search)
            ->filterStatus($request->status)
            ->filterMajor($request->major_id)
            ->filterGender($request->gender)
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data'    => StudentResource::collection($students),
            'meta'    => [
                'total'        => $students->total(),
                'per_page'     => $students->perPage(),
                'current_page' => $students->currentPage(),
                'last_page'    => $students->lastPage(),
                'from'         => $students->firstItem(),
                'to'           => $students->lastItem(),
            ],
            'links' => [
                'first' => $students->url(1),
                'last'  => $students->url($students->lastPage()),
                'prev'  => $students->previousPageUrl(),
                'next'  => $students->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Create a new student (Admin only).
     * POST /api/students
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        $student = Student::create($request->validated());
        $student->load('major');

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully.',
            'data'    => new StudentResource($student),
        ], 201);
    }

    /**
     * Get a single student.
     * GET /api/students/{id}
     */
    public function show(Student $student): JsonResponse
    {
        $student->load('major');

        return response()->json([
            'success' => true,
            'data'    => new StudentResource($student),
        ]);
    }

    /**
     * Update student data (Admin only).
     * PUT /api/students/{id}
     */
    public function update(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        $student->update($request->validated());
        $student->load('major');

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data'    => new StudentResource($student),
        ]);
    }

    /**
     * Soft delete a student (Admin only).
     * DELETE /api/students/{id}
     */
    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully.',
        ]);
    }

    /**
     * List soft-deleted students (Admin only).
     * GET /api/students/trashed
     */
    public function trashed(): JsonResponse
    {
        $students = Student::onlyTrashed()->with('major')->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => StudentResource::collection($students),
            'meta'    => [
                'total'        => $students->total(),
                'current_page' => $students->currentPage(),
                'last_page'    => $students->lastPage(),
            ],
        ]);
    }

    /**
     * Restore a soft-deleted student (Admin only).
     * POST /api/students/{id}/restore
     */
    public function restore(int $id): JsonResponse
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        $student->restore();

        return response()->json([
            'success' => true,
            'message' => 'Student restored successfully.',
            'data'    => new StudentResource($student->load('major')),
        ]);
    }

    /**
     * Permanently delete a student (Admin only).
     * DELETE /api/students/{id}/force
     */
    public function forceDelete(int $id): JsonResponse
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        $student->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Student permanently deleted.',
        ]);
    }
}
