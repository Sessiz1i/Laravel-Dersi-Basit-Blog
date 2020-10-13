@extends('back.layouts.master')
@section('content')
@section('title','Tüm Silinen Makaleler')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a class="m-0 font-weight-bold text-primary">Toplam <strong>{{$articles->count()}}</strong> Silinen Makale Bulunuyor.</a>
            <a href="{{route('admin.makaleler.index')}}" class="btn btn-primary btn-sm float-right"><i class="fa fa-home"></i> Tüm Makaleler</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>Başlık</th>
                        <th>Kategori</th>
                        <th>Tarihi</th>
                        <th>Hit</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td><img width="200" src="{{asset($article->image)}}"alt="Resim"></td>
                        <td>{{$article->title}}</td>
                        <td>{{$article->getCategory->name}}</td>
                        <td>{{$article->created_at->diffForHumans()}}</td>
                        <td>{{$article->hit}}</td>
                        <td>
                            <center>
                                <a href="{{route('admin.recover.article',$article->id)}}" title="Kurtarma" class="btn btn-sm btn-primary"><i class="fa fa-sm fa-recycle"></i></a>
                                <a href="{{route('admin.hard.delete.article',$article->id)}}" title="Tamamen Sil" class="btn btn-sm btn-danger"><i class="fa fa-sm fa-times"></i></a>
                            </center>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

