<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($libraryType)
    {
        $tags = Tag::byLibraryType($libraryType)->withCount('images')->latest()->get();
        $libraryName = $this->getLibraryName($libraryType);
        return view('admin.tags.index', compact('tags', 'libraryType', 'libraryName'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($libraryType)
    {
        $libraryName = $this->getLibraryName($libraryType);
        return view('admin.tags.create', compact('libraryType', 'libraryName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $libraryType)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:tags,name,NULL,id,library_type,' . $libraryType,
        ]);

        Tag::create([
            'library_type' => $libraryType,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.tags.index', $libraryType)
            ->with('success', 'タグを作成しました。');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($libraryType, Tag $tag)
    {
        $libraryName = $this->getLibraryName($libraryType);
        return view('admin.tags.edit', compact('tag', 'libraryType', 'libraryName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $libraryType, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:tags,name,' . $tag->id . ',id,library_type,' . $libraryType,
        ]);

        $tag->update($request->only('name'));

        return redirect()->route('admin.tags.index', $libraryType)
            ->with('success', 'タグを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($libraryType, Tag $tag)
    {
        // タグの削除時は関連付けのみ削除し、画像は残す
        $tag->images()->detach();
        $tag->delete();

        return redirect()->route('admin.tags.index', $libraryType)
            ->with('success', 'タグを削除しました。');
    }

    /**
     * Get library name in Japanese.
     */
    private function getLibraryName($libraryType)
    {
        return $libraryType === 'graphic' ? 'グラフィックデザイン' : '空間デザイン';
    }
}
