@extends('layout')
@section('content')
<div class="row">
    <div class="col-12 col-md-12 mt-5 mx-auto">
        <div class="text-center mb-5">
            <!-- 月を切り替えるボタン -->
            @foreach($months as $month)
                <button class="btn btn-dark month-button" data-month="{{ $month->name }}">{{ $month->name }}月の予算</button>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <div id="budget-container" class="">
                @foreach($months as $month)
                    <div class="budget-month card" data-month="{{ $month->name }}" style="width: 50vw;">
                        <div class="card-header bg-dark">
                            <h2 class="text-center text-light">{{ $month->name }}月の予算</h2>
                        </div>
                        <table class="card-body table text-center">
                        @foreach ($month->data as $budget)
                            <tr>
                                <td class="align-middle"><h5 class="rounded text-white p-1 text-center" style="background-color: {{ $budget->category->color }};">{{ $budget->category->name }}</h5></td>
                                <td class="align-middle">
                                @if (isset($categorySpendData[$month->name]))
                                    @php
                                        $foundCategorySpend = false;
                                    @endphp
                                    @foreach ($categorySpendData[$month->name] as $category => $spendInfo)
                                        @if($category === $budget->category->name)
                                            <div class="">¥{{ number_format($spendInfo['amount']) }} / ¥{{ number_format($budget->amount) }}</div>
                                            @if($budget->amount < $spendInfo['amount'])
                                            <div class="text-danger">¥{{ number_format($budget->amount - $spendInfo['amount']) }}超過</div>
                                            @else
                                            <div class="text-primary">残¥{{ number_format($budget->amount - $spendInfo['amount']) }}</div>
                                            @endif
                                            @php
                                                $foundCategorySpend = true;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!$foundCategorySpend)
                                        <div>0 / ¥{{ number_format($budget->amount) }}</div>
                                        <div class="text-primary">残¥{{ number_format($budget->amount) }}</div>
                                    @endif
                                @else
                                    <div>0 / ¥{{ number_format($budget->amount) }}</div>
                                    <div class="text-primary">残¥{{ number_format($budget->amount) }}</div>
                                @endif
                                </td>
                                <td><button type="button" class="btn btn-success" onclick="location.href='/budget/edit/{{ $budget->id }}'">編集する</button></td> 
                                <td class="">
                                    <form action="{{ route('budgetDelete', $budget->id) }}" method="POST" onSubmit="return checkDelete()">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">削除する</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                @endforeach
                <div class="float-right"><a href="/budget/new" class="btn btn-primary p-1 m-1">予算を追加する</a></div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const budgetContainer = document.getElementById('budget-container');
        const monthButtons = document.querySelectorAll('.month-button');
        
        // 初めに最初の月を表示
        showMonth('{{ date('n') }}');

        // 月の切り替えボタンがクリックされたときの処理
        monthButtons.forEach(button => {
            button.addEventListener('click', function() {
                const selectedMonth = this.getAttribute('data-month');
                showMonth(selectedMonth);
            });
        });

        // 指定された月を表示する関数
        function showMonth(monthName) {
            const allMonthContainers = budgetContainer.querySelectorAll('.budget-month');
            allMonthContainers.forEach(container => {
                container.style.display = 'none';
            });

            const selectedMonthContainer = budgetContainer.querySelector(`[data-month="${monthName}"]`);
            if (selectedMonthContainer) {
                selectedMonthContainer.style.display = 'block';
            }
        }
    });
</script>
@endsection