@extends('front.layouts.master')
@section('title',$article->title)   <!--Başlık-->
@section('bg',$article->image)
@section('content')
<article>
    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto">
                {!! $article->content !!}
            </div>
            @include('front.widgets.categoryWidget')
        </div>
        <span class="text-info">Okunma Sayısı: <b class="text-primary">{{$article->hit}}</b></span>
    </div>
</article>
@endsection
