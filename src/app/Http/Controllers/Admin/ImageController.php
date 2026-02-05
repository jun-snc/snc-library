<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Tag;
use App\Services\ImageProcessingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ImageController extends Controller
{
    public function index(string $libraryType)
    {
        $images = Image::byLibraryType($libraryType)
            ->with(['genre', 'tags'])
            ->latest()
            ->paginate(20);

        $libraryName = $this->getLibraryName($libraryType);

        return view('admin.images.index', compact('images', 'libraryType', 'libraryName'));
    }

    public function create(string $libraryType)
    {
        $genres = Genre::byLibraryType($libraryType)->orderBy('name')->get();
        $tags = Tag::byLibraryType($libraryType)->orderBy('name')->get();
        $libraryName = $this->getLibraryName($libraryType);

        return view('admin.images.create', compact('genres', 'tags', 'libraryType', 'libraryName'));
    }

    public function store(Request $request, string $libraryType, ImageProcessingService $imageProcessingService)
    {
        $validated = $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp'],
            'genre_id' => [
                'required',
                Rule::exists('genres', 'id')->where('library_type', $libraryType),
            ],
            'tags' => ['array'],
            'tags.*' => [
                Rule::exists('tags', 'id')->where('library_type', $libraryType),
            ],
            'memo' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $libraryType, $imageProcessingService, $request) {
            $fileData = $imageProcessingService->processAndStore($request->file('file'), $libraryType);

            $image = Image::create([
                'library_type' => $libraryType,
                'genre_id' => $validated['genre_id'],
                'memo' => $validated['memo'] ?? null,
                'original_path' => $fileData['original_path'],
                'display_path' => $fileData['display_path'],
                'thumb_path' => $fileData['thumb_path'],
                'original_name' => $fileData['original_name'],
                'mime_type' => $fileData['mime_type'],
                'width' => $fileData['width'],
                'height' => $fileData['height'],
            ]);

            if (!empty($validated['tags'])) {
                $image->tags()->sync($validated['tags']);
            }
        });

        return redirect()->route('admin.images.index', $libraryType)
            ->with('success', '画像を登録しました。');
    }

    public function edit(string $libraryType, Image $image)
    {
        if ($image->library_type !== $libraryType) {
            abort(404);
        }

        $genres = Genre::byLibraryType($libraryType)->orderBy('name')->get();
        $tags = Tag::byLibraryType($libraryType)->orderBy('name')->get();
        $libraryName = $this->getLibraryName($libraryType);
        $selectedTags = $image->tags->pluck('id')->toArray();

        return view('admin.images.edit', compact('image', 'genres', 'tags', 'selectedTags', 'libraryType', 'libraryName'));
    }

    public function update(Request $request, string $libraryType, Image $image)
    {
        if ($image->library_type !== $libraryType) {
            abort(404);
        }

        $validated = $request->validate([
            'genre_id' => [
                'required',
                Rule::exists('genres', 'id')->where('library_type', $libraryType),
            ],
            'tags' => ['array'],
            'tags.*' => [
                Rule::exists('tags', 'id')->where('library_type', $libraryType),
            ],
            'memo' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $image) {
            $image->update([
                'genre_id' => $validated['genre_id'],
                'memo' => $validated['memo'] ?? null,
            ]);

            $image->tags()->sync($validated['tags'] ?? []);
        });

        return redirect()->route('admin.images.index', $libraryType)
            ->with('success', '画像を更新しました。');
    }

    public function destroy(string $libraryType, Image $image)
    {
        if ($image->library_type !== $libraryType) {
            abort(404);
        }

        DB::transaction(function () use ($image) {
            $image->tags()->detach();

            Storage::disk('public')->delete([
                $image->original_path,
                $image->display_path,
                $image->thumb_path,
            ]);

            $image->delete();
        });

        return redirect()->route('admin.images.index', $libraryType)
            ->with('success', '画像を削除しました。');
    }

    private function getLibraryName(string $libraryType): string
    {
        return $libraryType === 'graphic' ? 'グラフィックデザイン' : '空間デザイン';
    }
}
