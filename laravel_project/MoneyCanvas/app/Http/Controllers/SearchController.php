<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
use App\Http\Requests\RecordRequest;
use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Traits\CustomTrait;

class SearchController extends Controller
{
    use CustomTrait;

    // record.index（収支一覧画面）のカテゴリ・日付検索
    public function search(Request $request) {
        $user = auth()->id();
        $categories = Category::where('user_id', $user)->get();
        $categoryId = $request->input('category_id');
        // 日付検索フォームから日付の始まりと終わりの値を取得
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $authRecords = Record::where('user_id', $user);

        if($categoryId) {
            // カテゴリが存在していれば、レコードを取得
            $authRecords->where('category_id', $categoryId);
        }
        if($from_date && $to_date) {
            // 検索期間にレコードが存在していれば取得
            $authRecords->whereBetween('date', [$from_date, $to_date]);
        }

        $records = $authRecords->orderBy('date', 'desc')->get();
        $income = $records->where('type', '収入')->sum('amount');
        $spending = $records->where('type', '支出')->sum('amount');
        $sum = $income - $spending;
    
        return view('record.index', compact('records', 'categories', 'income', 'spending', 'sum'));
    }

     // record.home（ホーム画面）の期間検索
    public function searchPeriod(Request $request, $period) {
        $user = auth()->id();
        // 期間検索フォームから値を取得
        $when = $request->input('when');
        
        if($period === 'year') {
            if ($when != '年別検索') {
                $records = Record::where('user_id', $user)
                ->whereYear('date', $when)
                ->get();
            } else {
                $records = Record::where('user_id', $user)->get();
            }
        } elseif($period === 'month') {
            if ($when != '月別検索') {
                // 選択された日付を年と月を分割して年を$selectedYearに代入、月を$selectedMonthに代入
                list($selectedYear, $selectedMonth) = explode('-', $when);
                $records = Record::where('user_id', $user)
                    ->whereYear('date', $selectedYear)
                    ->whereMonth('date', $selectedMonth)
                    ->get();
            } else {
                $records = Record::where('user_id', $user)->get();
            }
        } elseif($period === 'week') {
            if ($when != '週別検索') {
                // 週の選択肢を分割して週の開始日と終了日を取得
                $weekDates = explode(' ～ ', $when);
                $selectedWeekStart = $weekDates[0];
                $selectedWeekEnd = $weekDates[1];
                $records = Record::where('user_id', $user)
                    ->whereBetween('date', [$selectedWeekStart, $selectedWeekEnd])
                    ->get();
            } else {
                $records = Record::where('user_id', $user)->get();
            }
        }
        
        $incomeRecords = $records->where('type', '収入');
        $spendRecords = $records->where('type', '支出');
      

        $income = $incomeRecords->sum('amount');
        $spending = $spendRecords->sum('amount');
        $sum = $income - $spending;

        // 支払日一覧を取得
        $dates = Record::distinct()->orderBy('date', 'desc')->pluck('date')->toArray();

        // 支払日を年毎、月毎、週毎に分ける
        $yearlyDates = $this->getYearlyDates($dates);
        $monthlyDates = $this->getMonthlyDates($dates);
        $weeklyDates = $this->getWeeklyDates($dates);

        // 今年、今月、今週の収入と支出の合計を取得
        $yearlyIncome = $this->getYearlyData($user, '収入')->sum('amount');
        $yearlySpending = $this->getYearlyData($user, '支出')->sum('amount');
        $monthlyIncome = $this->getMonthlyData($user, '収入')->sum('amount');
        $monthlySpending = $this->getMonthlyData($user, '支出')->sum('amount');
        $weeklyIncome = $this->getWeeklyData($user, '収入')->sum('amount');
        $weeklySpending = $this->getWeeklyData($user, '支出')->sum('amount');

        $yearlySum = $yearlyIncome - $yearlySpending;
        $monthlySum = $monthlyIncome - $monthlySpending;
        $weeklySum = $weeklyIncome - $weeklySpending;

        // カテゴリごとの収入と支出を集計
        $incomeData = $this->categoryData($incomeRecords);
        $spendData = $this->categoryData($spendRecords);
        
        return view('record.home', compact('yearlyDates', 'weeklyDates', 'incomeData', 'spendData', 'records', 'income', 'spending', 'sum', 'yearlySum', 'monthlySum', 'weeklySum', 'monthlyDates', 'when', 'yearlyIncome', 'monthlyIncome', 'weeklyIncome', 'yearlySpending', 'monthlySpending', 'weeklySpending'));
    }
}