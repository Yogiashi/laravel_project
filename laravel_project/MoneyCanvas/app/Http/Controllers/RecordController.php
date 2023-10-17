<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RecordRequest;
use App\Record;
use App\User;
use App\Http\Requests\BlogPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Http\Requests\CategoryRequest;
use Carbon\Carbon;
use App\Traits\CustomTrait;

class RecordController extends Controller
{
    use CustomTrait;
    // 未ログインの場合はログイン画面にリダイレクト
    public function __construct(){
        $this->middleware('auth');
     }

    // ホーム画面
    public function home(Request $request) {
        $user = auth()->id();
        $records = Record::where('user_id', $user)->get();
        // 期間(年別、月別、週別)検索の値を取得
        $when = $request->input('when');
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

        return view('record.home', compact('when', 'yearlyDates', 'monthlyDates', 'weeklyDates', 'incomeData', 'spendData', 'records', 'income', 'spending', 'sum', 'yearlySum', 'monthlySum', 'weeklySum', 'yearlyIncome', 'monthlyIncome', 'weeklyIncome', 'yearlySpending', 'monthlySpending', 'weeklySpending'));
    }

    // 収支記録一覧
    public function index() {
        $user = auth()->id();
        $categories = Category::where('user_id', $user)->get();
        $records = Record::where('user_id', $user)->get()->sortByDesc('date');
        $income = $records->where('type', '収入')->sum('amount');
        $spending = $records->where('type', '支出')->sum('amount');
        $sum = $income - $spending;
        return view('record.index', compact('records', 'categories', 'income', 'spending', 'sum'));
    }
   // 記録フォーム
    public function new() {
        $user = auth()->id();
        $categories = Category::where('user_id', $user)->get();
        return view('record.new', ['categories' => $categories]);
    }
    
    // 収支の記録
    public function create(RecordRequest $request) {
        $user = auth()->id();
        $inputs = $request->all();
        
        \DB::beginTransaction();
        try {
            Record::create($inputs);
            \DB::commit();
        }catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        return redirect(route('index'))->with('flash_message', '記録が完了しました。');
    }

    // 記録詳細
    public function show($id) {
        $record = Record::find($id);
        return view('record.show', ['record' => $record]);
    }

    // 編集画面
    public function edit($id) {
        $user = auth()->id();
        $categories = Category::where('user_id', $user)->get();
        $record = Record::find($id);
        return view('record.edit', ['record' => $record, 'categories' => $categories]);
    }

    // 記録を更新
    public function update(RecordRequest $request) {
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            $record = Record::find($inputs['id']);
            $record->fill([
                'category_id' => $inputs['category_id'],
                'type' => $inputs['type'],
                'date' => $inputs['date'],
                'amount' => $inputs['amount'],
                'note' => $inputs['note']
            ]);
            $record->save();
            \DB::commit();
        }catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        return redirect(route('show', ['id' => $record]))->with('flash_message', '内容を更新しました。');
    }

    // 記録を削除
    public function delete($id) {
        try {
            Record::destroy($id);
        }catch(\Throwable $e) {
            abort(500);
        }
            return redirect(route('index'))->with('flash_message', '記録を削除しました。');
    }
}