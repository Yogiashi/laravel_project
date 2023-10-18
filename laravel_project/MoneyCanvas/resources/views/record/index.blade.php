@extends('layout')
@section('content')
    <div class="row">
        <div class="col-12 mt-5">
            <div class="d-md-flex justify-content-around mt-3">
                <div class="card w-25 res-title">
                    <div class="card-header">
                        <h4 class="text-center">収入</h4>
                    </div>
                    <h3 class="card-body text-center">{{ number_format($income) }}</h3>
                </div>
                <div class="card w-25">
                    <div class="card-header">
                        <h4 class="text-center">支出</h4>
                    </div>
                    <h3 class="card-body text-center">{{ number_format($spending) }}</h3>
                </div>
                <div class="card w-25">
                    <div class="card-header">
                        <h4 class="text-center">収支</h4>
                    </div>
                    <h3 class="card-body text-center">{{ number_format($sum) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center my-3">
        <div class="col-5 col-md-9 offset-md-2">
            <form method="POST" action="{{ route('search') }}">
                {{method_field('get')}}
                <label for="category_id">カテゴリ:</label>
                <select name="category_id" id="category_id">
                    <option value="" selected>選択してください</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <label for="from_date">開始日:</label>
                <input type="date" name="from_date" id="from_date">
                <label for="to_date">終了日:</label>
                <input type="date" name="to_date" id="to_date">
                <button type="submit" class="btn btn-secondary mt-2 mt-md-0">検索</button>
            </form>
        </div>
        <div class=""><a href="/record/new" class="btn btn-primary p-2">記録する</a></div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-hover text-center">
                <thead class="bg-dark">
                    <tr class="text-white">
                        <th>日付</th>
                        <th>収入/支出</th>
                        <th>金額</th>
                        <th>カテゴリ</th>
                        <th>備考</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                    <tr>
                        <td><a href="/record/{{ $record->id }}">{{ $record->date }} </a></td>
                        @if($record->type == '収入')
                            <td class="text-success">{{ $record->type }}</td>
                        @elseif($record->type == '支出')
                            <td class="text-danger">{{ $record->type }}</td>
                        @endif
                        @if($record->type == '収入')
                            <td class="text-success">+{{ number_format($record->amount) }}</td>
                        @elseif($record->type == '支出')
                            <td class="text-danger">-{{ number_format($record->amount) }}</td>
                        @endif
                        <td><h5 class="rounded text-white p-1 w-50 mx-auto" style="background-color: {{ $record->category->color }};">{{ $record->category->name }}</h5></td>
                        <td>{{ $record->note }}</td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
@endsection