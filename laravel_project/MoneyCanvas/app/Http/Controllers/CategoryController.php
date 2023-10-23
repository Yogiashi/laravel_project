<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Category;
use App\User;
use App\Http\Requests\BlogPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Jobs\TestJob;

class CategoryController extends Controller
{
    // 未ログインの場合はログイン画面にリダイレクト
    public function __construct(){
        $this->middleware('auth');
     }

    //カテゴリー登録画面
    public function new() {
        $user = auth()->id();
        $categories = Category::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        return view('category.new', compact('categories'));
    }

    // カテゴリー登録
    public function create(CategoryRequest $request) {
        $user = auth()->id();
        $inputs = $request->all();

        TestJob::dispatch($user, $inputs);
     
        return redirect(route('categoryNew'))->with('flash_message', 'カテゴリを登録しました。');
    }

    // カテゴリー編集画面
    public function edit($id) {
        $category = Category::find($id);
        return view('category.edit', ['category' => $category]);
    }

    // カテゴリーを更新
    public function update(CategoryRequest $request) {
        $inputs = $request->all();
        
        \DB::beginTransaction();
        try {
            $category = Category::find($inputs['id']);
            $category->fill([
                'name' => $inputs['name'],
                'color' => $inputs['color']
            ]);
            $category->save();
            \DB::commit();
        }catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        return redirect(route('categoryNew'))->with('flash_message', 'カテゴリを更新しました。');
    }

    // 記録を削除
    public function delete($id) {
        $category = Category::find($id);
        // カテゴリが使用されている場合は削除できない
        if ($category->record->count() > 0) {
            return redirect(route('categoryNew'))->with('flash_message', 'このカテゴリに関連する記録が存在するため削除できません');
        }
        try {
            $category->budget()->delete();
            Category::destroy($id);
        }catch(\Throwable $e) {
            abort(500);
        }
            return redirect(route('categoryNew'))->with('flash_message', 'カテゴリを削除しました。');
    }
}
