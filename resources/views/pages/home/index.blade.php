@extends('layouts.app')

@section('title', __('home.home'))

@section('content')
    <h5 class="mb-2">@lang('visits.visits')</h5>
    <div class="row">
        <div class="col-lg-6 col-12">
            @if ($prev_visit)
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $prev_visit->restaurant->name }}</h3>
                        <p>{{ $prev_visit->datetime }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <a href="{{ route('visits.show', $prev_visit->id) }}" class="small-box-footer">
                        @lang('home.last_visit') <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            @else
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>@lang('home.no_past_visits')</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <a href="{{ route('visits.index') }}" class="small-box-footer">
                        @lang('home.all_visits') <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            @endif
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-12">
            @if ($next_visit)
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $next_visit->restaurant->name }}</h3>
                        <p>{{ $next_visit->datetime }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <a href="{{ route('visits.show', $next_visit->id) }}" class="small-box-footer">
                        @lang('home.planned_visit') <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            @else
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>@lang('home.no_planned_visits')</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <a href="{{ route('visits.index') }}" class="small-box-footer">
                        @lang('home.all_visits') <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            @endif
        </div>
        <!-- ./col -->
    </div>

    <h5 class="mb-2">@lang('events.events')</h5>
    <div class="row">
        <div class="col-lg-6 col-12">
            @if ($current_event)
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $current_event->name }}</h3>
                        <p>
                            {{ $current_event->date }}
                            @if ($current_event->annual)
                                (@lang('events.annual'))
                            @endif
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <a href="{{ route('events.show', $current_event->id) }}" class="small-box-footer">
                        @lang('home.today_event') <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            @else
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>@lang('home.no_events_today')</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <a href="{{ route('events.index') }}" class="small-box-footer">
                        @lang('home.all_events') <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            @endif
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-12">
            @if ($next_event)
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $next_event->name }}</h3>
                        <p>
                            {{ $next_event->date }}
                            @if ($next_event->annual)
                                (@lang('events.annual'))
                            @endif
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <a href="{{ route('events.show', $next_event->id) }}" class="small-box-footer">
                        @lang('home.next_event') <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            @else
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>@lang('home.no_future_events')</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <a href="{{ route('events.index') }}" class="small-box-footer">
                        @lang('home.all_events') <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            @endif
        </div>
        <!-- ./col -->
    </div>
@endsection
