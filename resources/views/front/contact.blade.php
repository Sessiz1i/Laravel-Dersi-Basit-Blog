@extends('front.layouts.master')
@section('title','İletişim')   <!--Başlık-->
@section('bg','https://startbootstrap.github.io/startbootstrap-clean-blog/img/contact-bg.jpg')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto">
                @if(session('success'))
                <div class="alert alert-success col-md-9 mx-auto" style="text-align:center">
                      <b>{{session('success')}}</b>
                </div>
                    @endif
                @if($errors->any())
                    <div class="alert alert-danger col-md-9 mx-auto" style="text-align:center">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach

                        </ul>
                    </div>
                @endif
                <p>Bu sayfa bizim ile iletişime geçeblirsiniz.</p>
                <form method="post" action="{{route('contact.post')}}" name="sentMessage" id="contactForm" novalidate>
                    @csrf
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="İsim Soyisminiz" name="name" value="{{old('name')}}" required>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Email Address</label>
                            <input type="email" class="form-control" placeholder="Email Adresiniz" name="email" value="{{old('email')}}" required>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Konu</label>
                            <select class="form-control" name="topic" value="{{old('topic')}}" required>
                                <option @if(old('topic')=='Genel')selected @endif >Genel</option>
                                <option @if(old('topic')=='Destek')selected @endif >Destek</option>
                                <option @if(old('topic')=='Bilgi')selected @endif >Bilgi</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Message</label>
                            <textarea rows="5" class="form-control" placeholder="Mesajınız" name="message"required>{{old('message')}}</textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <button type="submit" class="btn btn-primary" id="sendMessageButton">Gönder</button>
                </form>
            </div>
        </div>
    </div>
    <hr>


@endsection






