<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $categoryId = $request->input('category_id');
    
        $query = Video::with(['user', 'category'])->orderBy('created_at', 'desc');
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    
        $videos = $query->paginate($perPage);
    
        return response()->json([
            'message' => 'Videos retrieved successfully',
            'status' => 200,
            'data' => [
                'videos' => $videos->items(),
                'meta' => [
                    'current_page' => $videos->currentPage(),
                    'per_page' => $videos->perPage(),
                    'total' => $videos->total(),
                    'last_page' => $videos->lastPage(),
                ]
            ]
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'video' => 'required|file|mimes:mp4,mov,avi|max:102400', // 100MB max
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Generate unique slug
        $slug = Str::slug($validated['title']);
        $count = Video::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        // Store video file
        $videoPath = $request->file('video')->store('videos', 'public');
        
        // Store thumbnail if provided
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $video = Video::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Video uploaded successfully',
            'status' => 201,
            'data' => $video->load(['user', 'category'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return response()->json([
            'message' => 'Video retrieved successfully',
            'status' => 200,
            'data' => $video->load(['user', 'category'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $this->authorize('update', $video);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if (isset($validated['title'])) {
            $slug = Str::slug($validated['title']);
            $count = Video::where('slug', $slug)->where('id', '!=', $video->id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            $validated['slug'] = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($video->thumbnail_path) {
                Storage::disk('public')->delete($video->thumbnail_path);
            }
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $video->update($validated);

        return response()->json([
            'message' => 'Video updated successfully',
            'status' => 200,
            'data' => $video->load(['user', 'category'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $this->authorize('delete', $video);

        // Delete video file
        if ($video->video_path) {
            Storage::disk('public')->delete($video->video_path);
        }

        // Delete thumbnail if exists
        if ($video->thumbnail_path) {
            Storage::disk('public')->delete($video->thumbnail_path);
        }

        $video->delete();

        return response()->json([
            'message' => 'Video deleted successfully',
            'status' => 200,
            'data' => null
        ]);
    }
}
