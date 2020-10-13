@extends('back.layouts.master')
@section('content')
@section('title','Tüm Sayfalar')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a class="m-0 font-weight-bold text-primary">Toplam <strong>{{$pages->count()}}</strong> Sayfa Bulunuyor.</a>
        </div>
        <div class="card-body">
            <div id="orderSuccess" style="display:none; text-align:center;" class="alert alert-success col-md-4 mx-auto">Sıralama Güncellendi</div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Sıra</th>
                        <th>Fotoğraf</th>
                        <th>Başlık</th>
                        <th>Durum Ve İşlemler</th>
                    </tr>
                    </thead>
                    <tbody id="orders">
                    @foreach($pages as $page)
                    <tr id="page_{{$page->id}}">
                        <td style="width:5px"><i style="cursor:move" class="fas fa-arrows-alt-v fa-5x handle"></i></td>
                        <td><img width="200" src="{{asset($page->image)}}" alt="Resim"></td>
                        <td>{{$page->title}}</td>
                        <td>
                            <center>
                                <input class="switch" type="checkbox" page-id="{{$page->id}}" @if($page->status==1) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" data-width="62" data-size="small">
                                <a href="{{route('page',$page->slug)}}" title="Görüntüle" target="_blank" class="btn btn-sm btn-dark"><i class="fa fa-sm fa-eye"></i></a>
                                <a href="{{route('admin.page.edit',$page->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-sm fa-pen"></i></a>
                                <a href="{{route('admin.page.delete',$page->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-sm fa-times"></i></a>

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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.12.0/dist/sortable.umd.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <script>
        $('#orders').sortable({
            handle:'.handle',
            update:function () {
                var siralama = $('#orders').sortable('serialize');
                $.get("{{route('admin.page.orders')}}?"+siralama,function(data,status) {
                    $('#orderSuccess').show().delay(2000).fadeOut();
                });
            }
        });

    </script>

<script>
    // TODO Swich Düğmesi Scripti
    $(function(){
        $('.switch').change(function(){
            id=$(this)[0].getAttribute('page-id');
            statu=$(this).prop('checked');
$.get("{{route('admin.page.switch')}}",{id:id,statu},function(data,status){});
        })
    })
</script>
@endsection
