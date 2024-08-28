<?php

namespace App\Http\Controllers\Visit;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitRequest;
use App\Models\Visit\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('visits.index');
    }

    public function onMap()
    {
        $visits = Visit::all();
        return view('visits.onMap', compact('visits'));
    }

    public function get()
    {
        $visits = Visit::paginate(4);
        return response()->json($visits, Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     * @param VisitRequest $visitRequest
     * @return JsonResponse
     */
    public function store(VisitRequest $visitRequest): JsonResponse
    {
        $validated = $visitRequest->validated();
        $visit = Visit::create($validated);

        return response()->json([
            'saved' => true,
            'message' => 'Visit scheduled successfully',
            'visit' => $visit
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param VisitRequest $request
     * @param string $id
     */
    public function update(VisitRequest $request, string $id): JsonResponse
    {
        $visit = Visit::findOrFail($id);
        $visit->update($request->validated());

        return response()->json([
            'saved' => true,
            'message' => 'Visit updated successfully',
            'visit' => $visit
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     */
    public function destroy(string $id): JsonResponse
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();

        return response()->json([
            'deleted' => true,
            'message' => 'Visit deleted successfully',
            'visit' => $visit
        ], Response::HTTP_OK);
    }
}
