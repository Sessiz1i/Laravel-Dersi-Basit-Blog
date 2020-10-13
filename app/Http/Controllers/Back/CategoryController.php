<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;

class CategoryController extends Controller
{
    public function index()
	{
		$categories=Category::all();
		return view('back.categories.index',compact('categories'));
	}

    public function create(Request $request)
    {
        $isExist=Category::whereSlug(str_slug($request->newCategory))->first();
        if ($isExist)
        {
            toastr()->error($request->newCategory . ' adında bir KATEGORİ mevcut');
            return redirect()->back();
        }
        $category=new Category;
        $category->name=$request->newCategory;
        $category->slug=str_slug($request->newCategory);
        $category->save();
        toastr()->success('Yeni bir KATEGORİ eklendi.');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $isSlug=Category::whereSlug(str_slug($request->slug))->whereNotIn('id',[$request->id])->first();
        $isName=Category::whereName($request->category)->whereNotIn('id',[$request->id])->first();
        if ($isName or $isSlug)
        {
            toastr()->error($request->category . ' adında bir KATEGORİ mevcut');
            return redirect()->back();
        }
        $category=Category::find($request->id);
        $category->name=$request->category;
        $category->slug=str_slug($request->slug);
        $category->save();
        toastr()->success('Kategori Güncellendi');
        return redirect()->back();
    }

	public function getData(Request $request)
	{
	    $category=Category::findOrFail($request->id);
		return response()->json($category);
	}

	public function switch(Request $request)
	{
		$categories=Category::findOrFail($request->id);
		$categories->status=$request->statu=='true' ? 1 : 0 ;
		$categories->save();
	}

    public function delete(Request $request)
    {
        $message=null;
        $category=Category::findOrFail($request->id);
        if($category->id==1){
            toastr()->error($request->name.'. Adlı Kategori Silinemez.');
            return redirect()->back();
        }
        $count=$category->articleCount();
        if($count>0){
            Article::where('category_id',$category->id)->update(['category_id'=>1]);
            $defaultCategory=Category::find(1);
            $message=$category->name.' Adlı Kategoriye ait '.$count.' makale '.$defaultCategory->name.' kategorisine eklendi.';
        }
            Category::destroy($request->id);
            toastr()->success('',$category->name.'. Adlı Kategori Silindi.<br>'.$message);
            return redirect()->route('admin.category.index');
    }
}
