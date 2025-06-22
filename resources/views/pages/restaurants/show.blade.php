@extends('layouts.app')

@section('title', $restaurant->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [[__('restaurants.restaurants'), route('restaurants.index')]],
        'active' => $restaurant->name,
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">@lang('restaurants.information')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-layer-group mr-1"></i> @lang('restaurants.category')</strong>
                    <p class="text-muted">
                        <a href="{{ route('categories.show', $restaurant->category->id) }}">
                            {{ $restaurant->category->name }}
                        </a>
                    </p>
                    @if ($restaurant->description)
                        <hr>
                        <strong><i class="fas fa-book mr-1"></i> @lang('restaurants.description')</strong>
                        <p class="text-muted">{{ $restaurant->description }}</p>
                    @endif
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> @lang('restaurants.location')</strong>
                    <p class="text-muted">{{ $restaurant->location }}</p>
                    @if ($restaurant->yandex_map_widget)
                        <p>
                            <iframe src="{{ $restaurant->yandex_map_widget }}" allowfullscreen="true" frameborder="0"
                                width=100% height="400"></iframe>
                        </p>
                    @endif
                    @can('edit restaurants')
                        <a class="btn btn-info btn-sm" href="{{ route('restaurants.edit', $restaurant->id) }}">
                            <i class="fas fa-pencil-alt"></i> @lang('restaurants.edit')
                        </a>
                    @endcan
                    @can('delete restaurants')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $restaurant->id }}">
                            <i class="fas fa-trash"></i> @lang('restaurants.delete')
                        </button>
                        <form method="POST" action="{{ route('restaurants.destroy', $restaurant->id) }}"
                            id="destroy-{{ $restaurant->id }}" hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                    @endcan
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">@lang('restaurants.statistics')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>@lang('restaurants.all_visits')</b>
                            <a class="float-right" href="{{ route('visits.restaurant', $restaurant->id) }}">
                                {{ $restaurant->visits->count() }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>@lang('restaurants.last_visit')</b>
                            @if ($last_visit)
                                <a class="float-right" href="{{ route('visits.show', $last_visit->id) }}">
                                    {{ $last_visit->datetime }}
                                </a>
                            @else
                                <span class="float-right">@lang('restaurants.never')</span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <b>@lang('restaurants.bans')</b>
                            <a class="float-right" href="#" data-toggle="modal" data-target="#modal-bans">
                                {{ $restaurant->bans()->count() }}
                            </a>
                        </li>
                    </ul>
                    @can('create visits')
                        <a class="btn btn-primary btn-sm" href="{{ route('visits.create', $restaurant->id) }}">
                            <i class="fas fa-calendar-plus"></i> @lang('restaurants.add_visit')
                        </a>
                    @endcan
                    @can('ban restaurants')
                        @if ($banned)
                            <button type="submit" class="btn btn-outline-danger btn-sm btn-delete" form="unban-form">
                                <i class="fas fa-ban"></i>
                                @lang('restaurants.unban_restaurant')
                            </button>
                            <form method="POST" action="{{ route('restaurants.unban') }}" id="unban-form" hidden>
                                @csrf
                                @method('POST')
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                            </form>
                        @else
                            <button type="submit" class="btn btn-danger btn-sm btn-delete" form="ban-form">
                                <i class="fas fa-ban"></i>
                                @lang('restaurants.ban_restaurant')
                            </button>
                            <form method="POST" action="{{ route('restaurants.ban') }}" id="ban-form" hidden>
                                @csrf
                                @method('POST')
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                            </form>
                        @endif
                    @endcan
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">@lang('restaurants.rating')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <!-- small card -->
                            @if ($evaluation)
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>{{ $evaluation->totalf }}</h3>
                                        <p>@lang('restaurants.your_score')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <a href="{{ route('evaluations.show', $evaluation->id) }}" class="small-box-footer">
                                        @lang('restaurants.more') <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            @else
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <h3>@lang('restaurants.unknown')</h3>
                                        <p>@lang('restaurants.your_score')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-times"></i>
                                    </div>
                                    <a href="{{ route('evaluations.create', $restaurant->id) }}" class="small-box-footer">
                                        @lang('restaurants.evaluate') <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-6 col-12">
                            <!-- small card -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $evaluation_avg }}</h3>
                                    <p>@lang('restaurants.average_score')</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <a href="{{ route('evaluations.restaurant', $restaurant->id) }}" class="small-box-footer">
                                    @lang('restaurants.all_evaluations') ({{ $restaurant->evaluations->count() }})
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="position-relative mb-2 mt-4">
                                <canvas id="evaluation-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> @lang('restaurants.your_score')
                                </span>
                                <span>
                                    <i class="fas fa-square text-info"></i> @lang('restaurants.average_score')
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            @include('components.comments', ['comments' => $comments, 'commentable' => $restaurant])
        </div>
    </div>

    <div class="modal fade" id="modal-bans">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('restaurants.bans')</h4>
                    <button type="button" class="close fas fa-times" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @foreach ($restaurant->bans as $ban)
                        <x-model-link :model="$ban->user" />
                        <br />
                    @endforeach
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script>
        let criteriaDescriptions = [
            @foreach ($chart as $c)
                '{{ $c['description'] }}',
            @endforeach
        ];

        let actualValues = [
            // User values
            [
                @foreach ($chart as $c)
                    {{ $c['user']['value'] }},
                @endforeach
            ],
            // Average values
            [
                @foreach ($chart as $c)
                    {{ $c['avg']['value'] }},
                @endforeach
            ],
        ];

        let rangeTooltips = [
            @foreach ($chart as $c)
                '{{ $c['range_tooltip'] }}',
            @endforeach
        ];

        let drawChart = () => {
            let ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            };

            let mode = 'index';
            let intersect = true;

            let chart = $('#evaluation-chart');
            new Chart(chart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($chart as $c)
                            '{{ $c['name'] }}',
                        @endforeach
                    ],
                    datasets: [{
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: [
                                @foreach ($chart as $c)
                                    {{ $c['user']['percentage'] }},
                                @endforeach
                            ],
                        },
                        {
                            backgroundColor: '#17a2b8',
                            borderColor: '#17a2b8',
                            data: [
                                @foreach ($chart as $c)
                                    {{ $c['avg']['percentage'] }},
                                @endforeach
                            ],
                        },

                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect,
                        callbacks: {
                            label(tooltipItem, data) {
                                let value = actualValues[tooltipItem.datasetIndex][tooltipItem.index];
                                let range = rangeTooltips[tooltipItem.index];
                                return `${value} ${range}`;
                            },
                            footer(tooltipItems, data) {
                                return criteriaDescriptions[tooltipItems[0].index];
                            },
                        },
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect,
                    },
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent',
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                callback: (value) => `${value}%`,
                            }, ticksStyle),
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                            },
                            ticks: ticksStyle,
                        }]
                    }
                },
            });
        };
    </script>
@endsection

@section('inline-script')
    $(drawChart);
@endsection
