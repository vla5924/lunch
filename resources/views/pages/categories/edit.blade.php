@extends('layouts.app')

@section('title', __('categories.edit_pollbunch'))

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('categories.update', $category->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>@lang('categories.name')</label>
                <input type="text" class="form-control" value="{{ $category->name }}" name="name" placeholder="@lang('categories.name_placeholder')" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('categories.save')</button>
        </div>
    </form>
</div>
@endsection
