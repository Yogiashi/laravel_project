@extends('layout')
@section('content')
<div class="row">
    <div class="col-12 mt-5">
        <table class="table table-borderless table-dark rounded">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">{{ now()->format('Y年m月d日') }}</th>
                    <th class="text-center">収入</th>
                    <th class="text-center">支出</th>
                    <th class="text-center">収支</th>
                </tr>
            </thead>
            <tbody class="bg-dark">
                <tr>
                    <th class="text-center">今年の収支</th>
                    <td class="text-center">
                        <h4>¥{{ number_format($yearlyIncome) }}</h4>
                    </td>
                    <td class="text-center">
                        <h4>¥{{ number_format($yearlySpending) }}</h4>
                    </td>
                    <td class="text-center">
                        <h4>¥{{ number_format($yearlySum) }}</h4>
                    </td>
                </tr>
                <tr>
                    <th class="text-center">今月の収支</th>
                    <td class="text-center">
                        <h4>¥{{ number_format($monthlyIncome) }}</h4>
                    </td>
                    <td class="text-center">
                        <h4>¥{{ number_format($monthlySpending) }}</h4>
                    </td>
                    <td class="text-center">
                        <h4>¥{{ number_format($monthlySum) }}</h4>
                    </td>
                </tr>
                <tr>
                    <th class="text-center">今週の収支</th>
                    <td class="text-center">
                        <h4>¥{{ number_format($weeklyIncome) }}</h4>
                    </td>
                    <td class="text-center">
                        <h4>¥{{ number_format($weeklySpending) }}</h4>
                    </td>
                    <td class="text-center">
                        <h4>¥{{ number_format($weeklySum) }}</h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mt-5">
            <div class="card-header d-md-flex justify-content-between bg-dark text-center">
                <h4 class="text-light">収支合計</h4>
                <form method="POST" action="{{ route('searchPeriod', ['period' => 'year']) }}">
                    {{ method_field('get') }}
                    @csrf
                    <select name="when" id="when">
                        <option {{ empty($when) ? 'selected' : '' }}>年別検索</option>
                        @foreach ($yearlyDates as $year)
                            <option value="{{ $year }}" {{ $when == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-secondary">表示</button>
                </form>
                <form method="POST" action="{{ route('searchPeriod', ['period' => 'month']) }}">
                    {{ method_field('get') }}
                    @csrf
                    <select name="when" id="when">
                        <option  {{ empty($when) ? 'selected' : '' }}>月別検索</option>
                        @foreach ($monthlyDates as $month)
                            <option value="{{ $month }}" {{ $when == $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-secondary">表示</button>
                </form>
                <form method="POST" action="{{ route('searchPeriod', ['period' => 'week']) }}">
                    {{ method_field('get') }}
                    @csrf
                    <select name="when" id="when">
                        <option class="text-center" {{ empty($when) ? 'selected' : '' }}>週別検索</option>
                        @foreach ($weeklyDates as $week)
                            <option value="{{ $week }}" {{ $when == $week ? 'selected' : '' }}>{{ $week }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-secondary">表示</button>
                </form>      
            </div>
            <div class="card-body d-md-flex justify-content-around">
                <div class="text-center">
                    <label>収入合計</label>
                    <h4>¥{{ number_format($income) }}</h4>
                </div>
                <div class="text-center">
                    <label>支出合計</label>
                    <h4>¥{{ number_format($spending) }}</h4>
                </div>
                <div class="text-center">
                    <label>収支合計</label>
                    <h4>¥{{ number_format($sum) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-12 mt-5">
        <h4 class="text-center bg-dark text-light rounded p-2">カテゴリ別収入額</h4>
        @if (count($incomeData) == 0)
            <h4 class="text-center" style="margin-top: 250px;">収入データがありません</h4>
        @endif
        <div class="donut-chart-container">
            <canvas id="incomeChart" width="100" height="100"></canvas> 
        </div>
    </div>
    <div class="col-md-6 col-12 mt-5">
        <h4 class="text-center bg-dark text-light rounded p-2">カテゴリ別支出額</h4>
        @if (count($spendData)== 0)
            <h4 class="text-center" style="margin-top: 250px;">支出データがありません</h4>
        @endif
        <div class="donut-chart-container">
            <canvas id="spendChart" width="100" height="100"></canvas>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    // 収入グラフと支出グラフを描画
    function createChart(chartId, data) {
        var ctx = document.getElementById(chartId).getContext('2d');
        var labels = Object.keys(data);
        var chartData = Object.values(data);
        var colors = chartData.map(item => item.color);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: chartData.map(item => item.amount),
                    backgroundColor: colors,
                    borderColor: ['rgba(0, 0, 0, 0)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    createChart('incomeChart', <?php echo json_encode($incomeData); ?>);
    createChart('spendChart', <?php echo json_encode($spendData); ?>);
</script>
@endsection