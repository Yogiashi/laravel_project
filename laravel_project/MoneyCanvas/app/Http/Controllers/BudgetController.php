<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Budget;
use App\User;
use App\Record;
use App\Http\Requests\BlogPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\BudgetRequest;
use App\Traits\CustomTrait;

class BudgetController extends Controller
{
    use CustomTrait;
    // 未ログインの場合はログイン画面にリダイレクト
    public function __construct() {
        $this->middleware('auth');
     }

     // 予算一覧画面
     public function index() {
        $user = auth()->id();
        $months = $this->getBudgetsByMonth();
        asort($months);
        $records = Record::where('user_id', $user)->get();
        $spendRecords = $records->where('type', '支出');
        $categorySpendData = $this->categoryDataByMonth($spendRecords);
        return view('budget.index', compact('months', 'categorySpendData'));
     }

     // 支払日を月毎に集計、その中でカテゴリ毎の収支金額を集計
     private function categoryDataByMonth($records) {
         $categoryData = [];
     
         foreach ($records as $record) {
             $categoryName = $record->category->name;
             $amount = $record->amount;
             $color = $record->category->color;
             $paymentMonth = date('n', strtotime($record->date));
     
             if (!array_key_exists($paymentMonth, $categoryData)) {
                // $categoryDataに支払い月がなければ、エントリを作成
                 $categoryData[$paymentMonth] = [];
             }
     
             if (!array_key_exists($categoryName, $categoryData[$paymentMonth])) {
                // $categoryData[$paymentMonth]にカテゴリ名がなければ、金額とカテゴリカラーを設定
                 $categoryData[$paymentMonth][$categoryName] = [
                     'amount' => 0,
                     'color' => $color,
                 ];
             }
     
             $categoryData[$paymentMonth][$categoryName]['amount'] += $amount;
         }
         return $categoryData;
     }
     
     // 月毎の予算を集計
     private function getBudgetsByMonth() {
        $user = auth()->id();
        $budgets = Budget::where('user_id', $user)->get();
     
        $months = [];

        foreach ($budgets as $budget) {
            // 予算データから月を取得
            $month = $budget->month;
    
            if (!isset($months[$month])) {
                // $monthsに月がなければ、予算月とデータの配列を作成
                $months[$month] = (object)[
                    'name' => $month,
                    'data' => [], 
                ];
            }
            // 予算月に対するデータを設定
            $months[$month]->data[] = $budget;
        }
     
         return $months;
     }

     // 予算作成画面
     public function new() {
        $user = auth()->id();
        $categories = Category::where('user_id', $user)->get();
        return view('budget.new', compact('categories'));
     }

     // 予算作成
     public function create(BudgetRequest $request) {
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            Budget::create($inputs);
            \DB::commit();
        }catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        return redirect(route('budgetIndex'))->with('flash_message', '予算を作成しました。');
     }

     // 予算情報の編集画面
     public function edit($id) {
        $budget = Budget::find($id);
        $user = auth()->id();
        $categories = Category::where('user_id', $user)->get();
        
        return view('budget.edit', compact('budget', 'categories'));
    }

    // 予算情報を更新
    public function update(BudgetRequest $request) {
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            $budget = Budget::find($inputs['id']);
            $budget->fill([
                'category_id' => $inputs['category_id'],
                'amount' => $inputs['amount'],
                'month' => $inputs['month'],
            ]);
            $budget->save();
            \DB::commit();
        }catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        return redirect(route('budgetIndex'))->with('flash_message', '予算を更新しました。');
    }

    // 予算を削除
    public function delete($id) {
        try {
            Budget::destroy($id);
        }catch(\Throwable $e) {
            abort(500);
        }
        return redirect(route('budgetIndex'))->with('flash_message', '予算を削除しました。');
    }
}
