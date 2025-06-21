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

    @if ($categories && $default_category && $rating)
        <h5 class="mb-2">@lang('categories.rating')</h5>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $default_category->name }}</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{ route('categories.rating', $default_category->id) }}" class="btn btn-sm btn-primary">
                            @lang('home.show_all')
                        </a>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-icon"
                            data-toggle="dropdown">
                        </button>
                        <div class="dropdown-menu" role="menu">
                            @foreach ($categories as $category)
                                <a class="dropdown-item" href="{{ route('categories.rating', $category->id) }}">Action</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px">@lang('categories.rank')</th>
                            <th>@lang('categories.restaurant')</th>
                            <th>@lang('categories.score')</th>
                            <th>@lang('categories.bans')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rating as $i => $r)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <a href="{{ route('restaurants.show', $r->restaurant->id) }}">
                                        {{ $r->restaurant->name }}
                                    </a>
                                </td>
                                <td>{{ $r->score }}</td>
                                <td>{{ $r->bans }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>...</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
