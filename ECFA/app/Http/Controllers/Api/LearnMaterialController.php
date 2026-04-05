<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\LearnMaterial;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LearnMaterialController extends Controller
{
    /**
     * List materials (admin: all; player: published only).
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (! $user instanceof User && ! $user instanceof Player) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $query = LearnMaterial::query()->with('event:id,title,event_date');

        if ($user instanceof Player) {
            $query->where('is_published', true);
        }

        if ($request->filled('weapon')) {
            $request->validate(['weapon' => 'in:Foil,Epee,Sabre']);
            $query->where('weapon', $request->weapon);
        }

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->integer('event_id'));
        }

        $materials = $query->orderBy('weapon')->orderBy('title')->get();

        return response()->json([
            'success' => true,
            'data' => $materials,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'weapon' => 'required|in:Foil,Epee,Sabre',
            'title' => 'required|string|max:200',
            'event_id' => 'nullable|exists:events,id',
            'file' => 'required|file|mimes:pdf|max:15360',
            'is_published' => 'sometimes|boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('learn-materials', 'public');

        $material = LearnMaterial::create([
            'event_id' => $validated['event_id'] ?? null,
            'weapon' => $validated['weapon'],
            'title' => $validated['title'],
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'is_published' => $request->boolean('is_published', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Material uploaded',
            'data' => $material->load('event:id,title'),
        ], 201);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $material = LearnMaterial::find($id);
        if (! $material) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted',
        ]);
    }

    public function download(Request $request, int $id): BinaryFileResponse|JsonResponse
    {
        $user = $request->user();
        if (! $user instanceof User && ! $user instanceof Player) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $material = LearnMaterial::find($id);
        if (! $material) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        if ($user instanceof Player && ! $material->is_published) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        $full = Storage::disk('public')->path($material->file_path);
        if (! is_file($full)) {
            return response()->json(['success' => false, 'message' => 'File missing'], 404);
        }

        return response()->download($full, $material->original_filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
