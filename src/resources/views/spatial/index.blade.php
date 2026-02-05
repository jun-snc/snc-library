@extends('layouts.public')

@section('title', $libraryName)
@section('header-title', $libraryName . 'ライブラリ')

@section('content')
<div class="filters">
    <div class="filter-group">
        <label for="genreFilter">ジャンル</label>
        <select id="genreFilter" onchange="applyFilters()">
            <option value="">すべて</option>
            @foreach($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="filter-group">
        <label>タグ</label>
        <div class="tag-filters">
            @forelse($tags as $tag)
            <div class="tag-filter" data-tag-id="{{ $tag->id }}" onclick="toggleTag(this)">
                {{ $tag->name }}
            </div>
            @empty
            <span style="color: var(--text-secondary);">タグがありません</span>
            @endforelse
        </div>
    </div>
</div>

<div class="image-grid" id="imageGrid">
    <div class="no-results">読み込み中...</div>
</div>
@endsection

@push('scripts')
<script>
    const libraryType = '{{ $libraryType }}';
    const apiUrl = '{{ route("${libraryType}.api.images.index") }}';
    let allImages = [];

    async function loadImages() {
        const genreId = document.getElementById('genreFilter').value;
        const selectedTags = Array.from(document.querySelectorAll('.tag-filter.active'))
            .map(el => el.dataset.tagId);

        const params = new URLSearchParams();
        if (genreId) params.append('genre_id', genreId);
        if (selectedTags.length) params.append('tags', selectedTags.join(','));

        const url = `${apiUrl}?${params.toString()}`;

        try {
            const response = await fetch(url);
            allImages = await response.json();
            renderImages();
        } catch (error) {
            console.error('画像の読み込みに失敗しました:', error);
            document.getElementById('imageGrid').innerHTML =
                '<div class="no-results">画像の読み込みに失敗しました</div>';
        }
    }

    function renderImages() {
        const grid = document.getElementById('imageGrid');

        if (allImages.length === 0) {
            grid.innerHTML = '<div class="no-results">画像がありません</div>';
            return;
        }

        grid.innerHTML = allImages.map((image, index) => `
            <div class="image-item" onclick="openLightbox(allImages, ${index})">
                <img src="${image.thumb_url}" alt="${image.original_name}">
                <div class="image-info">
                    <div class="name">${image.original_name}</div>
                    <div class="meta">
                        ${image.genre || ''}
                        ${image.tags.length ? ' | ' + image.tags.join(', ') : ''}
                    </div>
                </div>
            </div>
        `).join('');
    }

    function toggleTag(element) {
        element.classList.toggle('active');
        applyFilters();
    }

    function applyFilters() {
        loadImages();
    }

    // 初期読み込み
    loadImages();
</script>
@endpush