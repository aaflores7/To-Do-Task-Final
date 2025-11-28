<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->user()->todos()->with('category');

        // 1. Search by Title or Description
        if ($request->has('search') && $request->search) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }

        // 2. Filter by Status
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_completed', false);
            }
        }

        // 3. Sort (Existing logic)
        if ($request->query('sort') === 'due_date') {
            // Sort by due_date ASC (earliest first). 
            // The orderByRaw ensures NULL due_dates come last.
            $query->orderByRaw('CASE WHEN due_date IS NULL THEN 1 ELSE 0 END, due_date ASC');
        } else {
            // Default: Newest created first
            $query->orderBy('created_at', 'desc');
        }

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Security check: ensure category belongs to user
        if (isset($validated['category_id'])) {
             $category = \App\Models\Category::find($validated['category_id']);
             if ($category && $category->user_id !== $request->user()->id) {
                 abort(403, 'Unauthorized category');
             }
        }

        $todo = $request->user()->todos()->create($validated);
        return response()->json($todo->load('category'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = Todo::findOrFail($id);
        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $todo = $request->user()->todos()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
            'due_date' => 'nullable|date',
        ]);

        $todo->update($validated);
        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $todo = $request->user()->todos()->findOrFail($id);
        $todo->delete();
        return response()->json(null, 204);
    }
}