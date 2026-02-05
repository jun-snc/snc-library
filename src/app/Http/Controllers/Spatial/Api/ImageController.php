<?php

namespace App\Http\Controllers\Spatial\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $query = Image::byLibraryType('spatial')->with(['genre', 'tags'])->latest();

        // ジャンルフィルター
        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }

        // タグフィルター（OR条件）
        if ($request->filled('tags')) {
            $tagIds = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            });
        }

        $images = $query->get()->map(function ($image) {
            return [
                'id' => $image->id,
                'thumb_url' => asset('storage/' . $image->thumb_path),
                'display_url' => asset('storage/' . $image->display_path),
                'original_url' => asset('storage/' . $image->original_path),
                'original_name' => $image->original_name,
                'width' => $image->width,
                'height' => $image->height,
                'genre' => $image->genre?->name,
                'tags' => $image->tags->pluck('name')->toArray(),
                'memo' => $image->memo,
            ];
        });

        return response()->json($images);
    }

    public function show(Image $image)
    {
        if ($image->library_type !== 'spatial') {
            abort(404);
        }

        return response()->json([
            'id' => $image->id,
            'thumb_url' => asset('storage/' . $image->thumb_path),
            'display_url' => asset('storage/' . $image->display_path),
            'original_url' => asset('storage/' . $image->original_path),
            'original_name' => $image->original_name,
            'width' => $image->width,
            'height' => $image->height,
            'genre' => $image->genre?->name,
            'tags' => $image->tags->pluck('name')->toArray(),
            'memo' => $image->memo,
        ]);
    }
}
