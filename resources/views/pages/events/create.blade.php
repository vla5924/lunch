@extends('layouts.app')

@section('title', __('events.create_event'))

@section('breadcrumbs')
    @include('components.breadcrumbs', ['prev' => [[__('events.events'), route('events.index')]]])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card card-primary">
        <form method="POST" action="{{ route('events.store') }}">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>@lang('events.name')</label>
                    <input type="text" class="form-control" name="name" placeholder="@lang('events.enter_name')" required>
                </div>
                <div class="form-group">
                    <label>@lang('events.description')</label>
                    <textarea class="form-control" name="description" placeholder="@lang('events.enter_description')"></textarea>
                </div>
                <div class="form-group">
                    <label>@lang('events.day')</label>
                    <input type="number" class="form-control" name="day" min="1" max="31" step="1"
                        placeholder="@lang('events.enter_day')" required>
                </div>
                <div class="form-group">
                    <label>@lang('events.month')</label>
                    <select class="form-control" style="width: 100%;" name="month" required>
                        @foreach (App\Helpers\EventHelper::monthsLang() as $value => $name)
                            <option value="{{ $value }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>@lang('events.year')</label>
                    <input type="number" class="form-control" name="year" min="1" step="1"
                        placeholder="@lang('events.enter_year')">
                </div>
                <div class="form-check">
                    <input type="checkbox" id="event-annual" class="form-check-input" name="annual">
                    <label class="form-check-label" for="event-annual">@lang('events.annual')</label>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">@lang('events.create')</button>
            </div>
        </form>
    </div>
@endsection
