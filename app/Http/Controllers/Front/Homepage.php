<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Mail;

/** ----- Models ----- */
use App\Models\Page;
use App\Models\Article;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Config;


class Homepage extends Controller
{
	public function __construct()
	{
	    if (Config::find(1)->active==0)
	    {
	        return redirect()->to('site-bakimda')->send();             /** TODO Site Bakımda */
	    }
		view()->share('pages',Page::whereStatus(1)->orderBy('order','ASC')->get());
		view()->share('categories',Category::whereStatus(1)->inRandomOrder()->get());
	}

	/** TODO ----- Anasayfa ----- */
    public function index()

    {
        $data['articles']=Article::with('getCategory')->whereStatus(1)->whereHas('getCategory',function($query){
            $query->whereStatus(1);})->orderBy('created_at','DESC')->paginate(5); /** TODO Laravel ile sayfalandırma ( paginate(2) ) */
		$data['articles']->withPath(url('yazilar'));
        return view('front.homepage',$data);
    }

	/** TODO ----- Makale Sayfası ----- */
    public function singe($category,$slug)
    {
    	/** TODO  " Category::whereSlug " Category Modelinden where metoduna Slug da ekleyerek direkt Slug çağırmak */
    	$category=Category::whereSlug($category)->first() ?? abort(403, 'Böyle bir makale bulunamadı');
    	$article=Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403, 'Böyle bir makale bulunamadı.');
    	$article->increment('hit');  /** TODO Database tablosunu 1 artırmak için */
		$data['article']=$article;
    	return view('front.single',$data);
    }

	/** TODO ----- Kategory Sayfası ----- */
    public function category($slug)
	{
		$category=Category::whereStatus(1)->whereSlug($slug)->first() ?? abort(403, 'Böyle bir makale bulunamadı.');
		$data['category']=$category;
		$data['articles']=Article::whereStatus(1)->where('category_id',$category->id)->whereStatus(1)->orderBy('created_at','DESC')->paginate(2); /** TODO Laravel ile sayfalandırma ( paginate(2) ) */

		return view('front.category',$data);
	}

	/** TODO ----- Menüler Sayfası ----- */

	public function page($slug)
	{
	    $page=Page::whereSlug($slug)->first() ?? abort(403, 'Böyle bir sayfa bulunamadı.');
	    $data['page']=$page;
	    return view('Front.page', $data);
	}
	public function contact()
	{
		return view('front.contact');
	}
	public function contactpost(Request $request)
	{
		$rules=[
			'name'=>'required|min:5',
			'email'=>'required|email|',
			'topic'=>'required',
			'message'=>'required|min:10'
		];
		$validate=Validator::make($request->post(),$rules);
		if ($validate->fails())
		{
			return redirect()->route('contact')-> withErrors($validate)->withInput();
		}

		Mail::send([],[],function ($message) use($request){
		    $message->from('iletisim@blogsitesi.com','Blog Sitesi');
		    $message->to('omer.olgn@gmail.com');
		    $message->setBody('Mesajı Gönderen :'.$request->name.'<br>
                        Mesajı Gönderen Mail : '.$request->email.'<br>
                        Mesaj Konusu : '.$request->topic.'<br>
                        Mesaj : '.$request->message.'<br><br>
                        Mesaj Gönderim Tarihi : '.now().'','text/html');
		    $message->subject($request->name.' Blog Sitesi İletişiminden E-Mail gönderdi.');
        });

/*		$contact= new Contact;
		$contact->name=$request->name;
		$contact->email=$request->email;
		$contact->topic=$request->topic;
		$contact->message=$request->message;
		$contact->save();*/
		return redirect()->route('contact')->with('success', 'Mesajınız alınmıştır en kısa sürede dönüş sağlanacaktır.');

	}


}
