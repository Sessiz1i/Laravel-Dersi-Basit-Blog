@extends('back.layouts.master')
@section('content')
@section('title','Tüm Makaleler')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a class="m-0 font-weight-bold text-primary">Toplam <strong>{{$articles->count()}}</strong> Makale Bulunuyor.</a>
            <a href="{{route('admin.trashed.article')}}" class="btn btn-warning btn-sm float-right"><i class="fa fa-trash"></i> Silinen Makaleler</a>
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
                        <th>Durum Ve İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td style="width:200px"><img width="200" src="{{asset($article->image)}}"alt="Resim"></tdwidth:500px>
                        <td style="width:500px">{{$article->title}}</td>
                        <td>{{$article->getCategory->name}}</td>
                        <td>{{$article->created_at->diffForHumans()}}</td>
                        <td>{{$article->hit}}</td>
                        <td style="min-width:170px; width:170px;">
                            <center>
                                <input class="switch" type="checkbox" article-id="{{$article->id}}" @if($article->status==1) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" data-width="62" data-size="small">
                                <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}" title="Görüntüle" target="_blank" class="btn btn-sm btn-dark"><i class="fa fa-sm fa-eye"></i></a>
                                <a href="{{route('admin.makaleler.edit',$article->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-sm fa-pen"></i></a>
                                <a href="{{route('admin.delete.article',$article->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-sm fa-times"></i></a>

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
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    // TODO Swich Düğmesi Scripti
    $(function(){
        $('.switch').change(function(){
            id=$(this)[0].getAttribute('article-id');
            statu=$(this).prop('checked');
$.get("{{route('admin.switch')}}",{id:id,statu},function(data,status){});
        })
    })
</script>
@endsection
