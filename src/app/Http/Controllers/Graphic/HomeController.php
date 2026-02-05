<?php

namespace App\Http\Controllers\Graphic;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        $genres = Genre::byLibraryType('graphic')->orderBy('name')->get();
        $tags = Tag::byLibraryType('graphic')->orderBy('name')->get();
        $libraryType = 'graphic';
        $libraryName = 'グラフィックデザイン';

        return view('graphic.index', compact('genres', 'tags', 'libraryType', 'libraryName'));
    }
}
