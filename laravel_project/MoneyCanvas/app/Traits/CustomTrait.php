<?php

namespace App\Traits;
use App\Record;
use App\User;
use App\Http\Requests\BlogPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Http\Requests\CategoryRequest;
use Carbon\Carbon;

trait CustomTrait
{
    // カテゴリごとの収支データを集計
    public function categoryData($records)
    {
        $categoryData = [];
    
        foreach ($records as $record) {
            $categoryName = $record->category->name;
            $amount = $record->amount;
            $color = $record->category->color;

            if (array_key_exists($categoryName, $categoryData)) {
                // categoryDataにカテゴリ名があれば収支金額を足す
                $categoryData[$categoryName]['amount'] += $amount;
            } else {
                // categoryDataにカテゴリ名がなければ収支金額とカテゴリカラーを入れる
                $categoryData[$categoryName] = [
                    'amount' => $amount,
                    'color' => $color,
                ];
            }
        }
    
        return $categoryData;
    }

    // 今年の収支を取得
    private function getYearlyData($user, $type) {
        return Record::where('user_id', $user)
        ->where('type', $type)
        ->whereYear('date', now()->year)
        ->get();
    }

    // 今月の収支を取得
    private function getMonthlyData($user, $type) {
        return Record::where('user_id', $user)
            ->where('type', $type)
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->get();
    }

    // 今週の収支を取得
    private function getWeeklyData($user, $type) {
        $weekStartDate = now()->startOfWeek();
        $weekEndDate = now()->endOfWeek();

        return Record::where('user_id', $user)->where('type', $type)
            ->whereBetween('date', [$weekStartDate, $weekEndDate]);
    }

    // 年毎の日付を取得
    public function getYearlyDates($dates)
    {
        $yearlyDates = [];
        foreach ($dates as $date) {
            $Y_date = date('Y', strtotime($date));
            $yearlyDates[$Y_date] = $Y_date;
        }
        return $yearlyDates;
    }

    // 月毎の日付を取得
    public function getMonthlyDates($dates)
    {
        $monthlyDates = [];
        foreach ($dates as $date) {
            $YM_date = date('Y-m', strtotime($date));
            $monthlyDates[$YM_date] = $YM_date;
        }
        return $monthlyDates;
    }

    // 週毎の日付を取得
    public function getWeeklyDates($dates)
    {
        $weeklyDates = [];
        foreach ($dates as $date) {
            $year = date('Y', strtotime($date));
            $weekNumber = date('W', strtotime($date));

            $weekStartDate = date('Y-m-d', strtotime($year . 'W' . $weekNumber));
            $weekEndDate = date('Y-m-d', strtotime($year . 'W' . $weekNumber . '7'));

            $weekRange = $weekStartDate . ' ～ ' . $weekEndDate;

            // 同じ週が $weeklyDates に含まれていない場合に追加
            if (!in_array($weekRange, $weeklyDates)) {
                $weeklyDates[] = $weekRange;
            }
        }
        return $weeklyDates;
    }
}