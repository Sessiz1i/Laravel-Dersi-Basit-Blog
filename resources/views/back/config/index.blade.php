@extends('back.layouts.master')
@section('content')
@section('title','Site Ayarları')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a class="m-0 font-weight-bold text-primary">Ayar</a>
        </div>
            <div class="card-body">
                <form action="{{route('admin.config.edit')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site Başlığı</label>
                                <input class="form-control" type="text" name="title" value="{{$config->title}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site Aktiflik Durumu</label>
                                <select class="form-control" name="active">
                                    <option @if($config->active==1) selected @endif value="1">Site Açık</option>
                                    <option @if($config->active==0) selected @endif value="0">Site Kapalı</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site Logo</label>
                                <input class="form-control" type="file" name="logo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site Favicon</label>
                                <input class="form-control" type="file" name="favicon">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fab fa-facebook-square"></i> Facebook</label>
                                <input class="form-control" type="text" name="facebook" value="{{$config->facebook}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fab fa-twitter-square"></i> Twitter</label>
                                <input class="form-control" type="text" name="twitter" value="{{$config->twitter}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fab fa-github-square"></i> GitHub</label>
                                <input class="form-control" type="text" name="github" value="{{$config->github}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fab fa-linkedin"></i> LinkEdin</label>
                                <input class="form-control" type="text" name="linkedin" value="{{$config->linkedin}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fab fa-youtube"></i> YouTube</label>
                                <input class="form-control" type="text" name="youtube" value="{{$config->youtube}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fab fa-instagram-square"></i> Instagram</label>
                                <input class="form-control" type="text" name="instagram" value="{{$config->instagram}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class=" btn-block btn btn-success float-right" type="submit">Güncelle</button>
                    </div>
                </form>
            </div>
    </div>
@endsection



