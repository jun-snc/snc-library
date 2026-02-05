@extends('admin.layout')

@section('title', '画像管理 - ' . $libraryName)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>画像管理 - {{ $libraryName }}</h2>
    <a href="{{ route('admin.images.create', $libraryType) }}" class="btn">新規登録</a>
</div>

<div class="card">
    @if($images->isEmpty())
    <p style="text-align: center; color: #666; padding: 2rem;">画像がまだ登録されていません。</p>
    @else
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid #ddd;">
                <th style="padding: 1rem; text-align: center; width: 120px;">サムネイル</th>
                <th style="padding: 1rem; text-align: left;">情報</th>
                <th style="padding: 1rem; text-align: center; width: 200px;">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $image)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 1rem; text-align: center;">
                    <img src="{{ Storage::url($image->thumb_path) }}" alt="" style="max-width: 100px; max-height: 100px; border-radius: 4px;">
                </td>
                <td style="padding: 1rem;">
                    <div style="font-weight: 600; margin-bottom: 0.5rem;">{{ $image->original_name }}</div>
                    <div style="color: #666; font-size: 0.9rem; margin-bottom: 0.25rem;">ジャンル: {{ $image->genre?->name }}</div>
                    <div style="color: #666; font-size: 0.9rem; margin-bottom: 0.25rem;">タグ: {{ $image->tags->pluck('name')->join(', ') ?: 'なし' }}</div>
                    <div style="color: #666; font-size: 0.9rem;">メモ: {{ $image->memo ?: 'なし' }}</div>
                </td>
                <td style="padding: 1rem; text-align: center;">
                    <a href="{{ route('admin.images.edit', [$libraryType, $image]) }}" class="btn" style="padding: 0.5rem 1rem; font-size: 0.875rem; margin-right: 0.5rem;">編集</a>
                    <form action="{{ route('admin.images.destroy', [$libraryType, $image]) }}" method="POST" style="display: inline;" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 1.5rem;">
        {{ $images->links() }}
    </div>
    @endif
</div>
@endsection