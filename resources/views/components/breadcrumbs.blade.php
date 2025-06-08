<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('home.home')</a></li>
    @foreach($prev as $item)
    <li class="breadcrumb-item"><a href="{{ $item[1] }}">{{ $item[0] }}</a></li>
    @endforeach
    <li class="breadcrumb-item active">{{ $active }}</li>
</ol>
