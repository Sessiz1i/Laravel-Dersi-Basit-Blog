<div class="container">
    <div class="row">
        <div class=" col-md-9 mx-auto">
            @if (count($articles)>0)
                @foreach($articles as $article)
                    <div class="post-preview">
                        <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
                            <img width="825" height="400" src="{{url($article->image)}}">
                            <h4 class="post-title">
                                {{$article->title}}
                            </h4>
                            <h4 class="post-subtitle">{!! str_limit($article->content,100) !!}</h4>
                        </a>
                        <p class="post-meta"> Kategori: <a href="#">{{$article->getCategory->name}}</a>
                            <span class="float-md-right" >{{$article->created_at->diffForHumans()}}</span></p>
                    </div>
                    @if (!$loop->last)<hr>@endif
                @endforeach
            @else
                <div class="alert alert-danger col-md-9 mx-auto" style="text-align:center">
                    <h3>Bu kategoriye ait yazı bulunamadı.</h3>
                </div>
            @endif
			<?php /** TODO ----- PAGİNATE ve PAGİNATE ORTALAMA ----- */ ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{$articles->links()}}
                </ul>
            </nav>
        </div>
        @include('front.widgets.categoryWidget')
    </div>
</div>
