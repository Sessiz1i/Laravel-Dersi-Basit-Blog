@extends('back.layouts.master')
@section('content')
@section('title','Tüm Kategoriler')
{{--		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Kategori Oluştur</h6>
			</div>
			<form method="post" action="{{route('admin.category.create')}}">
				@csrf
			<div class="card-body">
					<div class="form-group">
						<label>Kategori Adı</label>
							<input type="text" class="form-control" name="category" value="{{old('title')}}" required>
					</div>
					<div class="form-group">
							<button type="submit" name="gonder" class="form-control btn btn-primary">Kategori Oluştur</button>
				</div>
			</div>
			</form>
		</div>--}}
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<a class="m-0 font-weight-bold text-primary">Toplam <strong>{{$categories->count()}}</strong> Kategori Bulunuyor.</a>

                <a id="id" class="btn btn-primary btn-sm text-white float-right create-click"><i class="fa fa-pen text-white"></i> Kategori Oluştur</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
						<tr>
							<th>Kategori Adı</th>
							<th>Makale Sayısı</th>
							<th>Durum</th>
						</tr>
						</thead>
						<tbody>
						@foreach($categories as $category)
						<tr>
							<td>{{$category->name}}</td>
							<td>{{$category->articleCount()}}</td>
							<td>

								<center>
									<input class="switch" type="checkbox" category-id="{{$category->id}}" @if($category->status==1) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" data-width="62" data-size="small">

									<a category-id="{{$category->id}}" class="btn btn-sm btn-primary edit-click" title="Kategori Düzenle"><i class="fa fa-pen text-white"></i></a>
									<a category-id="{{$category->id}}" category-name="{{$category->name}}" category-count="{{$category->articleCount()}}" class="btn btn-sm btn-danger remove-click" title="Kategori Sil"><i class="fa fa-times text-white"></i></a>

								</center>
							</td>
						</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
{{--Model--}}
<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kategori Sil</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="body" class="modal-body">
                <div  id="articleAlert" class="alert alert-danger"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                <form method="post" action="{{route('admin.category.delete')}}">
                    @csrf
                    <input type="hidden" id="delete-id" name="id">
                    <button id="deleteButon" type="submit" class="btn btn-success">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Kategori Oluştur</h4>
                <button type="button" class="close" data-dismiss="modal">&times</button>
            </div>
            <form method="post" action="{{route('admin.category.create')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kategori Adı</label>
                        <input id="newCategory" type="text" class="form-control" name="newCategory">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Kategori Düzenle</h4>
                <button type="button" class="close" data-dismiss="modal">&times</button>
            </div>
            <form method="post" action="{{route('admin.category.update')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kategori Adı</label>
                        <input id="category" type="text" class="form-control" name="category"/>
                    </div>
                        <input type="hidden" id="slug" type="text" class="form-control" name="slug"/>
                        <input type="hidden" name="id" id="category_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>

                </div>
            </form>
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
	$(function()
	{
		$('.remove-click').click(function() {
			id=$(this)[0].getAttribute('category-id');
			count=$(this)[0].getAttribute('category-count');
			name=$(this)[0].getAttribute('category-name');
            $('#delete-id').val(id);
            if(id==1){
                $('#articleAlert').html('<b>'+name+' kategorisi sabittir Kategoridir.<br>Silinen kategorilere ailt makaleler '+name+' kategorisine eklenir.</b>');
                $('#body').show();
                $('#deleteButon').hide();
                $('#deleteModal').modal();
                return;
            }
			if(count>0){
			    $('#articleAlert').html('<b>Kategoriye ait '+count+' Makale Bulunmaktadır.<br>Silmek istediğinize Eminmisiniz?</b>');
                $('#body').show();
                $('#deleteButon').show();
            }else{
                $('#articleAlert').html();
                $('#body').hide();
                $('#deleteButon').show();
            }
			$('#deleteModal').modal();
		});
		$('.edit-click').click(function() {
			id=$(this)[0].getAttribute('category-id');
			$.ajax({
                type:'GET',
                url:'{{route('admin.category.getdata')}}',
                data:{id:id},
                success:function (data)
                {
                    console.log(data);
                    $('#category').val(data.name);
                    $('#slug').val(data.slug);
                    $('#category_id').val(data.id);
                    $('#editModal').modal();
                }
            })
		});
		$('.create-click').click(function() {
            $('#createModal').modal();
		});

		$('.switch').change(function()
		{
			id=$(this)[0].getAttribute('category-id');
			statu=$(this).prop('checked');
			$.get("{{route('admin.category.switch')}}",{id: id,statu},function(data,status){});
		})
	})
</script>
		@endsection

