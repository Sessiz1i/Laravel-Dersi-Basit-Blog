<?php

	/**
	 *--------------------------------------------------------------------------
	 * Backend Routes
	 *--------------------------------------------------------------------------
	 */
    /** Bakım Route */
	Route::get('site-bakimda',function (){return view('front.bakim');}); /** TODO Site Bakımda Route */

    /** HomePage Route's */
	Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function ()
	{
		Route::get('login','Back\AuthController@login')->name('login');
		Route::post('login','Back\AuthController@loginPost')->name('login.post');
	});
	Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function ()
	{
		Route::get('makaleler/silinenler','Back\ArticleController@trashed')->name('trashed.article');
		Route::get('panel','Back\Dashboard@index')->name('dashboard');
		/** Makale Route's */
		Route::resource('makaleler','Back\ArticleController');
		Route::get('/switch','Back\ArticleController@switch')->name('switch');
		Route::get('/deletearticle/{id}','Back\ArticleController@delete')->name('delete.article');
		Route::get('/harddeletearticle/{id}','Back\ArticleController@hardDelete')->name('hard.delete.article');
		Route::get('/recoverarticle/{id}','Back\ArticleController@recover')->name('recover.article');
		/** Category Route's */
		Route::get('/kategoriler','Back\CategoryController@index')->name('category.index');
        Route::post('/kategoriler/update','Back\CategoryController@update')->name('category.update');
		Route::post('/kategoriler/create','Back\CategoryController@create')->name('category.create');
		Route::post('/kategoriler/delete','Back\CategoryController@delete')->name('category.delete');

		Route::get('/kategori/status','Back\CategoryController@switch')->name('category.switch');
		Route::get('/kategori/getdata','Back\CategoryController@getData')->name('category.getdata');
		/** Pages Route's */
		Route::get('/sayfalar','Back\PageController@index')->name('page.index');
		Route::get('/sayfalar/olustur','Back\PageController@create')->name('page.create');
		Route::get('/sayfalar/gunncelle/{id}','Back\PageController@update')->name('page.edit');
		Route::post('/sayfalar/gunncelle/{id}','Back\PageController@updatePost')->name('page.edit.post');
		Route::post('/sayfalar/olustur','Back\PageController@post')->name('page.create.post');
		Route::get('/sayfa/switch','Back\PageController@switch')->name('page.switch');
		Route::get('/sayfalar/sil/{id}','Back\PageController@delete')->name('page.delete');
		Route::get('/sayfalar/siralama','Back\PageController@orders')->name('page.orders');
        /** Config Route's */
        Route::get('/ayarlar','Back\ConfigController@index')->name('config.index');
        Route::post('/ayarlar/guncelle','Back\ConfigController@edit')->name('config.edit');
		//
		Route::get('logout','Back\AuthController@logout')->name('logout');
	});




	/**
	 *--------------------------------------------------------------------------
	 * Front Routes
	 *--------------------------------------------------------------------------
	 */

	Route::get('/','Front\Homepage@index')->name('homepage');
	Route::get('yazilar','Front\Homepage@index');
	Route::get('/iletisim','Front\Homepage@contact')->name('contact');
	Route::post('/iletisim','Front\Homepage@contactpost')->name('contact.post');
	Route::get('/kategori/{category}','Front\Homepage@category')->name('category');

				/** TODO Ensonda olsun hata veriyor */
	Route::get('/{category}/{slug}','Front\Homepage@singe')->name('single');
	Route::get('/{sayfa}','Front\Homepage@page')->name('page');


