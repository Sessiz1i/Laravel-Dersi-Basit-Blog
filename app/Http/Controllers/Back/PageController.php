<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use File;

class PageController extends Controller
{
    public function index()
	{
		$pages=Page::all();
		return view('back.pages.index',compact('pages'));
	}

	public function orders(Request $request){
        foreach ($request->get('page') as $key => $order){
            Page::where('id',$order)->update(['order'=> $key]);
        }



    }

	public function update($id)
	{
	    $page=Page::findOrFail($id);
		return view('back.pages.update',compact('page'));

	}
    public function updatePost(Request $request, $id)
    {
        $request->validate([
            'title'=>'min:4',
            'image'=>'image|mimes:jpeg,jpg,png|max:2048'
        ]);
        /** TODO Database kayıt işlemi */
        $page=Page::findOrFail($id);
        $page->title=$request->title;																/** TODO Sütünlar bu şekilde ekleniyo */
        $page->content=$request['content'];
        $page->slug=str_slug($request->title);
        /** TODO Resim dosyası ekleme */
        if ($request->hasFile('image')) {
            $imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension(); /** TODO Resim adı değiştirme Uzantı ekleme */
            $request->image->move(public_path('uploads'),$imageName); 							/** TODO Upload klasörüne Dosya ekleme */
            $page->image='uploads/'.$imageName;
        }
        $page->save();																			/** TODO Tüm sutunlar ve veriler eklendikten sonra tabloya kayıt işlemi */
        toastr()->success($page->title.' Sayfası Güncellendi.');
        return redirect()->route('admin.page.index');
    }

    public function create()
    {
        return view('back.pages.create');
    }

	public function switch(Request $request)
	{
		$pages=Page::findOrFail($request->id);
		$pages->status=$request->statu=='true' ? 1 : 0 ;
		$pages->save();
	}

	public function post(Request $request)
	{
		$request->validate([
			'title'=>'min:4',
			'image'=>'required|image|mimes:jpeg,jpg,png|max:2048'
		]);
		/** TODO Database kayıt işlemi */
		$last=Page::orderBy('order','desc')->first();
		$page= new Page;																			/** TODO Article Modeli çarıldı */
		$page->title=$request->title;																/** TODO Sütünlar bu şekilde ekleniyo */
		$page->content=$request['content'];
		$page->order=$last->order+1;
		$page->slug=str_slug($request->title);
		/** TODO Resim dosyası ekleme */
		if ($request->hasFile('image')) {
			$imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension(); /** TODO Resim adı değiştirme Uzantı ekleme */
			$request->image->move(public_path('uploads'),$imageName); 							/** TODO Upload klasörüne Dosya ekleme */
			$page->image='uploads/'.$imageName;
		}
		$page->save();																			/** TODO Tüm sutunlar ve veriler eklendikten sonra tabloya kayıt işlemi */
		toastr()->success($request->title.' Sayfası Oluşturuldu.');
		return redirect()->route('admin.page.index');

	}
    public function delete($id)
    {
        $page=Page::find($id);
        if (File::exists($page->image)) File::delete(public_path($page->image));
        $page->delete();
        toastr()->success('Sayfasa Silindi');
        return redirect()->route('admin.page.index');
    }
}
