@extends('layouts.app')

@section('title', $restaurant->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [['Рестораны', route('restaurants.index')]],
        'active' => $restaurant->name,
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Информация</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Категория</strong>
                    <p class="text-muted">
                        <a href="{{ route('categories.show', $restaurant->category->id) }}">
                            {{ $restaurant->category->name }}
                        </a>
                    </p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Описание</strong>
                    <p class="text-muted">{{ $restaurant->description }}</p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Местоположение</strong>
                    <p class="text-muted">{{ $restaurant->location }}</p>
                    @if ($restaurant->yandex_map_widget)
                        <p>
                            <iframe src="{{ $restaurant->yandex_map_widget }}" allowfullscreen="true" frameborder="0"
                                width=100% height="400"></iframe>
                        </p>
                    @endif
                    @can('edit restaurants')
                        <a class="btn btn-info btn-sm" href="{{ route('restaurants.edit', $restaurant->id) }}">
                            <i class="fas fa-pencil-alt"></i> Изменить
                        </a>
                    @endcan
                    @can('delete restaurants')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $restaurant->id }}">
                            <i class="fas fa-trash"></i> Удалить
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
                    <h3 class="card-title">Статистика</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Все посещения</b>
                            <a class="float-right"
                                href="{{ route('visits.restaurant', $restaurant->id) }}">{{ $restaurant->visits->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Последнее посещение</b>
                            @if ($last_visit)
                                <a class="float-right" href="{{ route('visits.show', $last_visit->id) }}">
                                    {{ $last_visit->datetime }}
                                </a>
                            @else
                                <span class="float-right">никогда</span>
                            @endif
                        </li>
                    </ul>
                    @can('create visits')
                        <a class="btn btn-primary btn-sm" href="{{ route('visits.create', $restaurant->id) }}">
                            <i class="fas fa-calendar-plus"></i> Добавить посещение
                        </a>
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
                    <h3 class="card-title">Рейтинг</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <!-- small card -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $evaluation_avg }}</h3>
                                    <p>Средняя оценка</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <a href="{{ route('evaluations.restaurant', $restaurant->id) }}" class="small-box-footer">
                                    Все оценки ({{ $restaurant->evaluations->count() }})
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-6 col-12">
                            <!-- small card -->
                            @if ($evaluation)
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $evaluation->totalf }}</h3>
                                        <p>Ваша оценка</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <a href="{{ route('evaluations.show', $evaluation->id) }}" class="small-box-footer">
                                        Подробнее <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            @else
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <h3>Неизвестно</h3>
                                        <p>Ваша оценка</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-times"></i>
                                    </div>
                                    <a href="{{ route('evaluations.create', $restaurant->id) }}" class="small-box-footer">
                                        Поставить оценку <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            @endif
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
                                    <i class="fas fa-square text-primary"></i> Ваша оценка
                                </span>
                                <span>
                                    <i class="fas fa-square text-gray"></i> Средняя оценка
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

    <script>
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
                                    {{ $c['avg']['percentage'] }},
                                @endforeach
                            ],
                        },
                        {
                            backgroundColor: '#ced4da',
                            borderColor: '#ced4da',
                            data: [
                                @foreach ($chart as $c)
                                    {{ $c['user']['percentage'] }},
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
