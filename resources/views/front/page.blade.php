@extends('front.layouts.master')
@section('title',$page->title)   <!--Başlık-->
@section('bg',$page->image)
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <p>{!! $page->content !!}</p>

            </div>
        </div>
    </div>
@endsection





