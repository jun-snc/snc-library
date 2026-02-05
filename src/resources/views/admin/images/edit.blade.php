@extends('admin.layout')

@section('title', '画像編集 - ' . $libraryName)

@section('content')
<h2 style="margin-bottom: 2rem;">画像編集 - {{ $libraryName }}</h2>

<div class="card" style="margin-bottom: 1.5rem;">
    <div style="display: flex; gap: 1.5rem; align-items: flex-start;">
        <img src="{{ Storage::url($image->thumb_path) }}" alt="" style="max-width: 160px; max-height: 160px; border-radius: 4px;">
        <div>
            <div style="font-weight: 600; margin-bottom: 0.5rem;">{{ $image->original_name }}</div>
            <div style="color: #666; font-size: 0.9rem;">サイズ: {{ $image->width }} × {{ $image->height }}</div>
        </div>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.images.update', [$libraryType, $image]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="genre_id">ジャンル <span style="color: #e74c3c;">*</span></label>
            <select
                id="genre_id"
                name="genre_id"
                class="form-control @error('genre_id') is-invalid @enderror"
                required>
                <option value="">選択してください</option>
                @foreach($genres as $genre)
                <option value="{{ $genre->id }}" @selected(old('genre_id', $image->genre_id) == $genre->id)>{{ $genre->name }}</option>
                @endforeach
            </select>
            @error('genre_id')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>タグ</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 0.5rem;">
                @forelse($tags as $tag)
                <label style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tags', $selectedTags)))>
                    <span>{{ $tag->name }}</span>
                </label>
                @empty
                <span style="color: #666;">タグが登録されていません。</span>
                @endforelse
            </div>
            @error('tags.*')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="memo">メモ</label>
            <textarea
                id="memo"
                name="memo"
                class="form-control @error('memo') is-invalid @enderror"
                rows="4">{{ old('memo', $image->memo) }}</textarea>
            @error('memo')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn">更新</button>
            <a href="{{ route('admin.images.index', $libraryType) }}" class="btn" style="background: #95a5a6;">キャンセル</a>
        </div>
    </form>
</div>
@endsection