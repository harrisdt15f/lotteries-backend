@if(isset($buttons))
    @foreach($buttons as $button)
        <a class="btn btn-default btn-sm" href="{{$button['url']}}">
            <i class="{{$button['class']}}"></i>
            <span class="menu-item-parent">{{$button['title']}} </span>
        </a>
    @endforeach
@endif