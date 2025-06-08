<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('home.home')</a></li>
    @isset($prev)
    @foreach($prev as $item)
    <li class="breadcrumb-item"><a href="{{ $item[1] }}">{{ $item[0] }}</a></li>
    @endforeach
    @endif
    <li class="breadcrumb-item active">
        @isset($active)
        {{ $active }}
        @else
        @yield('title')
        @endif
    </li>
</ol>
