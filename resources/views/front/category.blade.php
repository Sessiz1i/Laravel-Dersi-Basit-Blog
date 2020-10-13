@extends('front.layouts.master')
@section('title',$category->name.' Kategorisi | '.count($articles).' Adet yazı bulundu.')   <!--Başlık-->
@section('content')
@include('front.widgets.articleList')
@endsection
