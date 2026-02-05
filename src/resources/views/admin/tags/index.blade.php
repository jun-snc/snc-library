@extends('admin.layout')

@section('title', 'タグ管理 - ' . $libraryName)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>タグ管理 - {{ $libraryName }}</h2>
    <a href="{{ route('admin.tags.create', $libraryType) }}" class="btn">新規作成</a>
</div>

<div class="card">
    @if($tags->isEmpty())
    <p style="text-align: center; color: #666; padding: 2rem;">タグがまだ登録されていません。</p>
    @else
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid #ddd;">
                <th style="padding: 1rem; text-align: left;">名前</th>
                <th style="padding: 1rem; text-align: center; width: 120px;">画像数</th>
                <th style="padding: 1rem; text-align: center; width: 200px;">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 1rem;">{{ $tag->name }}</td>
                <td style="padding: 1rem; text-align: center;">{{ $tag->images_count }}</td>
                <td style="padding: 1rem; text-align: center;">
                    <a href="{{ route('admin.tags.edit', [$libraryType, $tag]) }}" class="btn" style="padding: 0.5rem 1rem; font-size: 0.875rem; margin-right: 0.5rem;">編集</a>
                    <form action="{{ route('admin.tags.destroy', [$libraryType, $tag]) }}" method="POST" style="display: inline;" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection