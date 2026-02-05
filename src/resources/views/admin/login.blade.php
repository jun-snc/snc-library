@extends('admin.layout')

@section('title', 'ログイン')

@section('content')
<div style="max-width: 400px; margin: 4rem auto;">
    <div class="card">
        <h2 style="margin-bottom: 1.5rem; text-align: center;">管理者ログイン</h2>

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="password">パスワード</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                    autofocus>
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn" style="width: 100%;">ログイン</button>
        </form>
    </div>

    <div style="text-align: center; margin-top: 1rem; color: #666;">
        <small>デフォルトパスワード: admin</small>
    </div>
</div>
@endsection