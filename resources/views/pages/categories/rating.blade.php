@extends('layouts.app')

@section('title', __('categories.rating') . ': ' . $category->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            [__('categories.categories'), route('categories.index')],
            [$category->name, route('categories.show', $category->id)],
        ],
        'active' => __('categories.rating'),
    ])
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px">@lang('categories.rank')</th>
                        <th>@lang('categories.restaurant')</th>
                        <th>@lang('categories.score')</th>
                        <th>@lang('categories.bans')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurants as $i => $r)
                        <tr style="{{ $r->bans ? 'background-color:#ffeeee' : '' }}">
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <a href="{{ route('restaurants.show', $r->restaurant->id) }}">
                                    {{ $r->restaurant->name }}
                                </a>
                            </td>
                            <td>{{ $r->score }}</td>
                            <td>{{ $r->bans }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
