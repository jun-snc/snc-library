@extends('admin.layout')

@section('title', 'タグ編集 - ' . $libraryName)

@section('content')
<h2 style="margin-bottom: 2rem;">タグ編集 - {{ $libraryName }}</h2>

<div class="card">
    <form action="{{ route('admin.tags.update', [$libraryType, $tag]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">タグ名 <span style="color: #e74c3c;">*</span></label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $tag->name) }}"
                required
                autofocus>
            @error('name')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn">更新</button>
            <a href="{{ route('admin.tags.index', $libraryType) }}" class="btn" style="background: #95a5a6;">キャンセル</a>
        </div>
    </form>
</div>
@endsection