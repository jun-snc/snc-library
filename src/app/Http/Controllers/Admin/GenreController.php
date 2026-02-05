<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($libraryType)
    {
        $genres = Genre::byLibraryType($libraryType)->withCount('images')->latest()->get();
        $libraryName = $this->getLibraryName($libraryType);
        return view('admin.genres.index', compact('genres', 'libraryType', 'libraryName'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($libraryType)
    {
        $libraryName = $this->getLibraryName($libraryType);
        return view('admin.genres.create', compact('libraryType', 'libraryName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $libraryType)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:genres,name,NULL,id,library_type,' . $libraryType,
        ]);

        Genre::create([
            'library_type' => $libraryType,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.genres.index', $libraryType)
            ->with('success', 'ジャンルを作成しました。');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($libraryType, Genre $genre)
    {
        $libraryName = $this->getLibraryName($libraryType);
        return view('admin.genres.edit', compact('genre', 'libraryType', 'libraryName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $libraryType, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:genres,name,' . $genre->id . ',id,library_type,' . $libraryType,
        ]);

        $genre->update($request->only('name'));

        return redirect()->route('admin.genres.index', $libraryType)
            ->with('success', 'ジャンルを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($libraryType, Genre $genre)
    {
        // 紐づく画像がある場合は削除不可
        if ($genre->images()->count() > 0) {
            return back()->with('error', 'このジャンルには画像が紐づいているため削除できません。');
        }

        $genre->delete();

        return redirect()->route('admin.genres.index', $libraryType)
            ->with('success', 'ジャンルを削除しました。');
    }

    /**
     * Get library name in Japanese.
     */
    private function getLibraryName($libraryType)
    {
        return $libraryType === 'graphic' ? 'グラフィックデザイン' : '空間デザイン';
    }
}
