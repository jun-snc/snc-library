@extends('admin.layout')

@section('title', 'ジャンル作成 - ' . $libraryName)

@section('content')
<h2 style="margin-bottom: 2rem;">ジャンル作成 - {{ $libraryName }}</h2>

<div class="card">
    <form action="{{ route('admin.genres.store', $libraryType) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">ジャンル名 <span style="color: #e74c3c;">*</span></label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                required
                autofocus>
            @error('name')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn">作成</button>
            <a href="{{ route('admin.genres.index', $libraryType) }}" class="btn" style="background: #95a5a6;">キャンセル</a>
        </div>
    </form>
</div>
@endsection