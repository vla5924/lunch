@extends('layouts.app')

@section('title', __('restaurants.add_restaurant'))

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('restaurants.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('restaurants.group')</label>
                <select class="form-control" style="width: 100%;" name="category_id" required>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.name')</label>
                <input type="text" class="form-control" name="name" placeholder="@lang('category.name_placeholder')" required>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.description')</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.yandex_map_widget')</label>
                <input type="text" class="form-control" name="yandex_map_widget">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('restaurants.add')</button>
        </div>
    </form>
</div>
@endsection
