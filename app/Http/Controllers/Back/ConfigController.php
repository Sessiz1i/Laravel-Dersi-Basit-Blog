<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Support\Str;

class ConfigController extends Controller
{
    public function index()
    {
        $config=Config::find(1);
        return view('back.config.index',compact('config'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'title'=>'min:5',
            'image'=>'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $config=Config::find(1);
        $config->title=$request->title;
        $config->active=$request->active;
        $config->facebook=$request->facebook;
        $config->twitter=$request->twitter;
        $config->github=$request->github;
        $config->linkedin=$request->linkedin;
        $config->youtube=$request->youtube;
        $config->instagram=$request->instagram;

        if ($request->hasFile('logo'))
        {
            $logoName=Str::slug($request->title).'-logo.'.$request->logo->getClientOriginalExtension(); /** TODO Resim adı değiştirme Uzantı ekleme */
            $request->logo->move(public_path('uploads'),$logoName); 							/** TODO Upload klasörüne Dosya ekleme */
            $config->logo='uploads/'.$logoName;
        }
        if ($request->hasFile('favicon'))
        {
            $faviconName=Str::slug($request->title).'favicon.'.$request->favicon->getClientOriginalExtension(); /** TODO Resim adı değiştirme Uzantı ekleme */
            $request->favicon->move(public_path('uploads'),$faviconName); 							/** TODO Upload klasörüne Dosya ekleme */
            $config->favicon='uploads/'.$faviconName;
        }
        $config->save();																			/** TODO Tüm sutunlar ve veriler eklendikten sonra tabloya kayıt işlemi */
        toastr()->success( 'Site Ayarları Güncellendi.');
        return redirect()->route('admin.config.index');
    }
}
