@extends('layouts.app')

@section('title', __('restaurants.create_restaurant'))

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('restaurants.restaurants'), route('restaurants.index')],
]])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('restaurants.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('restaurants.category')</label>
                <select class="form-control" style="width: 100%;" name="category_id" required>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.name')</label>
                <input type="text" class="form-control" name="name" placeholder="@lang('restaurants.enter_name')" required>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.description')</label>
                <textarea class="form-control" name="description" placeholder="@lang('restaurants.enter_description')"></textarea>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.location')</label>
                <input type="text" class="form-control" name="location" placeholder="@lang('restaurants.enter_location')" required>
            </div>
            <div class="form-group">
                <label>@lang('restaurants.yandex_map_widget')</label>
                <input type="text" class="form-control" name="yandex_map_widget" placeholder="@lang('restaurants.enter_yandex_map_widget')">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('restaurants.create')</button>
        </div>
    </form>
</div>
@endsection
