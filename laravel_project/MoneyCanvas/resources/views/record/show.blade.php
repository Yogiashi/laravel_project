@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-5 mt-5 mx-auto">
        <div class="card">
            <div class="text-center">
                <h2 class="card-header bg-dark text-light">履歴の詳細</h2>
                <div class="card-body">
                    <label for="">日付</label>
                    <h4 class="mx-auto">{{ $record->date }}</h4>
                    @if($record->type == '収入')
                                <h3 class="text-success mx-auto mt-3">{{ $record->type }}</h3>
                            @elseif($record->type == '支出')
                                <h3 class="text-danger w-50 mx-auto mt-3">{{ $record->type }}</h3>
                            @endif
                    <h2 class="mt-3 border-bottom rounded py-2 w-75 mx-auto">¥{{ number_format($record->amount) }}</h2>
                    <div class="">カテゴリ</div>
                    <h3 class="mt-3 text-white w-50 mx-auto" style="background-color: {{ $record->category->color }};">{{ $record->category->name }}</h3>
                    <h5 class="mt-4">{{ $record->note }}</h5>
                    <div class="d-flex justify-content-center mt-5">
                    <a class="btn btn-secondary mx-2" href="{{route('index')}}">戻る</a>
                        <button type="button" class="btn btn-success mx-2" onclick="location.href='/record/edit/{{ $record->id }}'">編集する</button>
                        <form action="{{ route('delete', $record->id) }}" method="POST" onSubmit="return checkDelete()">
                        @csrf
                            <button type="submit" class="btn btn-danger mx-2">削除する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function checkDelete() {
        if(window.confirm('削除してよろしいですか？')) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection