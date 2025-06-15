@extends('layouts.app')

@section('title', __('categories.create_category'))

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('categories.categories'), route('categories.index')],
]])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('categories.name')</label>
                <input type="text" class="form-control" name="name" placeholder="@lang('categories.enter_name')" required>
            </div>
            <div class="form-group">
                <label>@lang('categories.criterias')</label>
                <select multiple class="form-control" name="criteria_ids[]">
                    @foreach ($criterias as $criteria)
                    <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('categories.create')</button>
        </div>
    </form>
</div>
@endsection
