<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Tag;
use App\Models\Image;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // グラフィックデザインライブラリの統計
        $graphicGenresCount = Genre::byLibraryType('graphic')->count();
        $graphicTagsCount = Tag::byLibraryType('graphic')->count();
        $graphicImagesCount = Image::byLibraryType('graphic')->count();

        // 空間デザインライブラリの統計
        $spatialGenresCount = Genre::byLibraryType('spatial')->count();
        $spatialTagsCount = Tag::byLibraryType('spatial')->count();
        $spatialImagesCount = Image::byLibraryType('spatial')->count();

        return view('admin.dashboard', compact(
            'graphicGenresCount',
            'graphicTagsCount',
            'graphicImagesCount',
            'spatialGenresCount',
            'spatialTagsCount',
            'spatialImagesCount'
        ));
    }
}
