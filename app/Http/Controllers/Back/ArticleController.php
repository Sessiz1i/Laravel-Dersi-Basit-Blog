<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /** TODO "--resource" Komutu ile yapılan Controller  Create Read Update Deelete functionları ile oluşturuldu */
    public function index()
    {
    	$articles=Article::orderByRaw('created_at','ASC')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories=Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** Test */
    	$request->validate([
    		'title'=>'min:10',
			'image'=>'required|image|mimes:jpeg,jpg,png|max:2048'
		]);
    	/** TODO Database kayıt işlemi */
		$article= new Article;																			/** TODO Article Modeli çarıldı */
        $article->title=$request->title;																/** TODO Sütünlar bu şekilde ekleniyo */
        $article->category_id=$request->category;
        $article->content=$request['content'];
        $article->slug=str_slug($request->title);
		/** TODO Resim dosyası ekleme */
        if ($request->hasFile('image')) {
        	$imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension(); /** TODO Resim adı değiştirme Uzantı ekleme */
			$request->image->move(public_path('uploads'),$imageName); 							/** TODO Upload klasörüne Dosya ekleme */
			$article->image='uploads/'.$imageName;
        }
        $article->save();																			/** TODO Tüm sutunlar ve veriler eklendikten sonra tabloya kayıt işlemi */
		toastr()->success('', 'Makale Başarıyla Oluşturuldu.');
        return redirect()->route('admin.makaleler.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$article=Article::findOrFail($id);	// TODO Varsa yap yoksa 404 sayfasına yönlendir.
		$categories=Category::all();
		return view('back.articles.edit',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$request->validate([
			'title'=>'min:10',
			'image'=>'image|mimes:jpeg,jpg,png|max:2048'
		]);
		/** TODO Database kayıt işlemi */
		$article=Article::findOrFail($id);
		$article->title=$request->title;																/** TODO Sütünlar bu şekilde ekleniyo */
		$article->category_id=$request->category;
		$article->content=$request['content'];
		$article->slug=str_slug($request->title);
		/** TODO Resim dosyası ekleme */
		if ($request->hasFile('image')) {
			$imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension(); /** TODO Resim adı değiştirme Uzantı ekleme */
			$request->image->move(public_path('uploads'),$imageName); 							/** TODO Upload klasörüne Dosya ekleme */
			$article->image='uploads/'.$imageName;
		}
		$article->save();																			/** TODO Tüm sutunlar ve veriler eklendikten sonra tabloya kayıt işlemi */
		toastr()->success('', $id.'. Makale Güncellendi.');
		return redirect()->route('admin.makaleler.index');
    }
    public function switch(Request $request)
	{
		$article=Article::findOrFail($request->id);
		$article->status=$request->statu=='true' ? 1 : 0 ;
		$article->save();
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
	{
		Article::destroy($id);
		toastr()->success('',$id.'. Makale Silinen Makalelere Taşındı');
		return redirect()->route('admin.makaleler.index');
	}
	public function hardDelete($id)
	{
		$article=Article::onlyTrashed()->find($id);
		if (File::exists($article->image)) File::delete(public_path($article->image));
		Article::onlyTrashed()->find($id)->forceDelete();
		toastr()->success('',$id.'. Makale Tamamen Silindi');
		return redirect()->back();
	}

	public function trashed()
	{
		$articles=Article::onlyTrashed()->orderBy('deleted_at','DESC')->get();
		return view('back.articles.trashed',compact('articles'));
	}
	public function recover($id)
	{
		Article::onlyTrashed()->find($id)->restore();			// TODO Silmekten kurtarma komutu
		toastr()->success('',$id.'. Makale Slinmekten Kurtarıldı.');
		return redirect()->back();
	}



    public function destroy($id){}
}
