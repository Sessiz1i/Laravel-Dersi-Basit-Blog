@isset($categories)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <b>Kategoriler</b>
            </div>
            <div class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item  @if(Request::segment(2)==$category->slug) list-group-item-dark @endif">
                        <a @if(Request::segment(2)!=$category->slug) href="{{route('category',$category->slug)}}" @endif>{{$category->name}}</a>
                            <span class="float-right">{{$category->articleCount()}}</span>
                @endforeach
            </div>
        </div>
    </div>
@endisset
