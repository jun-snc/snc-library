@extends('admin.layout')

@section('title', 'ダッシュボード')

@section('content')
<h2 style="margin-bottom: 2rem;">ダッシュボード</h2>

<!-- グラフィックデザインライブラリ -->
<div class="card" style="margin-bottom: 2rem;">
    <h3 style="margin-bottom: 1.5rem; color: #3498db;">グラフィックデザインライブラリ</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
        <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
            <h4 style="color: #3498db; font-size: 2rem; margin-bottom: 0.5rem;">{{ $graphicGenresCount }}</h4>
            <p style="color: #666;">ジャンル</p>
        </div>
        <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
            <h4 style="color: #2ecc71; font-size: 2rem; margin-bottom: 0.5rem;">{{ $graphicTagsCount }}</h4>
            <p style="color: #666;">タグ</p>
        </div>
        <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
            <h4 style="color: #e74c3c; font-size: 2rem; margin-bottom: 0.5rem;">{{ $graphicImagesCount }}</h4>
            <p style="color: #666;">画像</p>
        </div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.genres.index', 'graphic') }}" class="btn" style="text-align: center; background: #2ecc71;">ジャンル管理</a>
        <a href="{{ route('admin.tags.index', 'graphic') }}" class="btn" style="text-align: center; background: #9b59b6;">タグ管理</a>
        <a href="#" class="btn" style="text-align: center;">画像管理</a>
    </div>
</div>

<!-- 空間デザインライブラリ -->
<div class="card">
    <h3 style="margin-bottom: 1.5rem; color: #e67e22;">空間デザインライブラリ</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
        <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
            <h4 style="color: #3498db; font-size: 2rem; margin-bottom: 0.5rem;">{{ $spatialGenresCount }}</h4>
            <p style="color: #666;">ジャンル</p>
        </div>
        <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
            <h4 style="color: #2ecc71; font-size: 2rem; margin-bottom: 0.5rem;">{{ $spatialTagsCount }}</h4>
            <p style="color: #666;">タグ</p>
        </div>
        <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
            <h4 style="color: #e74c3c; font-size: 2rem; margin-bottom: 0.5rem;">{{ $spatialImagesCount }}</h4>
            <p style="color: #666;">画像</p>
        </div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.genres.index', 'spatial') }}" class="btn" style="text-align: center; background: #2ecc71;">ジャンル管理</a>
        <a href="{{ route('admin.tags.index', 'spatial') }}" class="btn" style="text-align: center; background: #9b59b6;">タグ管理</a>
        <a href="#" class="btn" style="text-align: center;">画像管理</a>
    </div>
</div>
@endsection