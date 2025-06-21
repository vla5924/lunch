@extends('layouts.app')

@section('title', __('visits.edit_visit') . ': ' . $visit->restaurant->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('restaurants.restaurants'), route('restaurants.index')],
    [$visit->restaurant->name, route('restaurants.show', $visit->restaurant->id)],
    [__('visits.visits'), route('visits.restaurant', $visit->restaurant->id)],
    [$visit->datetime, route('visits.show', $visit->id)],
], 'active' => __('visits.edit_visit')])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('visits.update', $visit->id) }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="restaurant_id" value="{{ $visit->restaurant->id }}">

        <div class="card-body">
            <div class="form-group">
                <label>@lang('visits.notes')</label>
                <textarea class="form-control" name="notes" placeholder="@lang('visits.enter_notes')">{{ $visit->notes }}</textarea>
            </div>
            <div class="form-group">
                <label>@lang('visits.datetime')</label>
                <input type="datetime-local" class="form-control" name="datetime" value="{{ $visit->datetime }}" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('visits.save')</button>
        </div>
    </form>
</div>
@endsection
