<?php

namespace App\Http\Controllers\Spatial;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        $genres = Genre::byLibraryType('spatial')->orderBy('name')->get();
        $tags = Tag::byLibraryType('spatial')->orderBy('name')->get();
        $libraryType = 'spatial';
        $libraryName = '空間デザイン';

        return view('spatial.index', compact('genres', 'tags', 'libraryType', 'libraryName'));
    }
}
