@extends('layouts.app')

@section('title', __('criterias.create_criteria'))

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('criterias.criterias'), route('criterias.index')],
]])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('criterias.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('criterias.name_en')</label>
                <input type="text" class="form-control" name="name_en" placeholder="@lang('criterias.enter_name_en')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.name_ru')</label>
                <input type="text" class="form-control" name="name_ru" placeholder="@lang('criterias.enter_name_ru')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.description_en')</label>
                <textarea class="form-control" name="description_en" placeholder="@lang('criterias.enter_description_en')"></textarea>
            </div>
            <div class="form-group">
                <label>@lang('criterias.description_ru')</label>
                <textarea class="form-control" name="description_ru" placeholder="@lang('criterias.enter_description_ru')"></textarea>
            </div>
            <div class="form-group">
                <label>@lang('criterias.icon_class')</label>
                <input type="text" class="form-control" name="fa_icon" pattern="fa-[a-z\-0-9]+" placeholder="@lang('criterias.enter_icon_class')">
            </div>
            <div class="form-group">
                <label>@lang('criterias.min_value')</label>
                <input type="number" class="form-control" name="min_value" value="1" min="0" step="1" placeholder="@lang('criterias.enter_min_value')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.max_value')</label>
                <input type="number" class="form-control" name="max_value" value="10" min="1" step="1" placeholder="@lang('criterias.enter_max_value')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.step')</label>
                <input type="number" class="form-control" name="step" value="1" min="1" step="1" placeholder="@lang('criterias.enter_step')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.weight')</label>
                <input type="number" class="form-control" name="impact" value="1.0" min="0.01" max="100.0" step="0.01" placeholder="@lang('criterias.enter_weight')" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('criterias.create')</button>
        </div>
    </form>
</div>
@endsection
