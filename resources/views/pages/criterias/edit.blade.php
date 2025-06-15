@extends('layouts.app')

@section('title', __('criterias.edit_criteria') . ': ' . $criteria->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('criterias.criterias'), route('criterias.index')],
    [$criteria->name, route('criterias.show', $criteria->id)],
], 'active' => __('criterias.edit_criteria')])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('criterias.update', $criteria->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>@lang('criterias.name_en')</label>
                <input type="text" class="form-control" name="name_en" value="{{ $criteria->name_en }}" placeholder="@lang('criterias.enter_name_en')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.name_ru')</label>
                <input type="text" class="form-control" name="name_ru" value="{{ $criteria->name_ru }}" placeholder="@lang('criterias.enter_name_ru')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.description_en')</label>
                <textarea class="form-control" name="description_en" placeholder="@lang('criterias.enter_description_en')">{{ $criteria->description_en }}</textarea>
            </div>
            <div class="form-group">
                <label>@lang('criterias.description_ru')</label>
                <textarea class="form-control" name="description_ru" placeholder="@lang('criterias.enter_description_ru')">{{ $criteria->description_ru }}</textarea>
            </div>
            <div class="form-group">
                <label>@lang('criterias.icon_class')</label>
                <input type="text" class="form-control" name="fa_icon" pattern="fa-[a-z\-0-9]+" value="{{ $criteria->fa_icon }}" placeholder="@lang('criterias.enter_icon_class')">
            </div>
            <div class="form-group">
                <label>@lang('criterias.min_value')</label>
                <input type="number" class="form-control" name="min_value" value="{{ $criteria->min_value }}" min="0" step="1" placeholder="@lang('criterias.enter_min_value')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.max_value')</label>
                <input type="number" class="form-control" name="max_value" value="{{ $criteria->max_value }}" min="1" step="1" placeholder="@lang('criterias.enter_max_value')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.step')</label>
                <input type="number" class="form-control" name="step" value="1" min="{{ $criteria->step_value }}" step="1" placeholder="@lang('criterias.enter_step')" required>
            </div>
            <div class="form-group">
                <label>@lang('criterias.weight')</label>
                <input type="number" class="form-control" name="impact" value="{{ $criteria->impact }}" min="0.01" max="100.0" step="0.01" placeholder="@lang('criterias.enter_weight')" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('criterias.save')</button>
        </div>
    </form>
</div>
@endsection
