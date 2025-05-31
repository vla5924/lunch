@extends('layouts.app')

@section('title', __('category.create_category'))

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('category.name')</label>
                <input type="text" class="form-control" name="name" placeholder="@lang('category.name_placeholder')" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('category.create')</button>
        </div>
    </form>
</div>
@endsection
