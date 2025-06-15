@extends('layouts.app')

@section('title', __('restaurants.edit_restaurant') . ': ' . $restaurant->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('restaurants.restaurants'), route('restaurants.index')],
    [$restaurant->name, route('restaurants.show', $restaurant->id)],
], 'active' => __('restaurants.edit_restaurant')])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('restaurants.update', $restaurant->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>@lang('restaurants.category')</label>
                <select class="form-control" style="width: 100%;" name="category_id" required>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $restaurant->category->id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.name')</label>
                <input type="text" class="form-control" name="name" value="{{ $restaurant->name }}" placeholder="@lang('restaurants.enter_name')" required>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.description')</label>
                <textarea class="form-control" name="description" placeholder="@lang('restaurants.enter_description')">{{ $restaurant->description }}</textarea>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.location')</label>
                <input type="text" class="form-control" name="location" value="{{ $restaurant->location }}" placeholder="@lang('restaurants.enter_location')" required>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.yandex_map_widget')</label>
                <input type="text" class="form-control" name="yandex_map_widget" value="{{ $restaurant->yandex_map_widget }}" placeholder="@lang('restaurants.enter_yandex_map_widget')">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('restaurants.save')</button>
        </div>
    </form>
</div>
@endsection
