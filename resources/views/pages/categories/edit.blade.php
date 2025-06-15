@extends('layouts.app')

@section('title', __('categories.edit_category') . ': ' . $category->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('categories.categories'), route('categories.index')],
    [$category->name, route('categories.show', $category->id)],
], 'active' => __('categories.edit_category')])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('categories.update', $category->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>@lang('categories.name')</label>
                <input type="text" class="form-control" name="name" value="{{ $category->name }}" placeholder="@lang('categories.enter_name')" required>
            </div>
            <div class="form-group">
                <label>@lang('categories.criterias')</label>
                <select multiple class="form-control" name="criteria_ids[]">
                    @foreach ($criterias as $criteria)
                    <option value="{{ $criteria->id }}" {{ $category->criterias->contains($criteria) ? 'selected' : '' }}>{{ $criteria->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('categories.save')</button>
        </div>
    </form>
</div>
@endsection
