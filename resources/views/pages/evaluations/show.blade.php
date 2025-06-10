@extends('layouts.app')

@section('title', 'Оценка: ' . $evaluation->restaurant->name . ' (' . $evaluation->user->name . ')')

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            ['Рестораны', route('restaurants.index')],
            [$evaluation->restaurant->name, route('restaurants.show', $evaluation->restaurant->id)],
            ['Оценки', route('evaluations.restaurant', $evaluation->restaurant->id)],
        ],
        'active' => $evaluation->user->name,
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8">
                    <p>
                        <b>Ресторан:</b>
                        <a href="{{ route('restaurants.show', $evaluation->restaurant->id) }}">
                            {{ $evaluation->restaurant->name }}
                        </a>
                    </p>
                    <p>{{ $evaluation->notes }}</p>
                    <table class="table table-striped">
                        <thead>
                            <th>Критерий</th>
                            <th>Оценка</th>
                        </thead>
                        <tbody>
                            @foreach ($evaluation->criterias as $ce)
                                <tr>
                                    <td>{{ $ce->criteria->name }}</td>
                                    <td>
                                        <div class="progress progress-xs" data-toggle="tooltip" data-placement="top"
                                            title="<b>{{ $ce->value }}</b> по шкале от {{ $ce->criteria->min_value }} до {{ $ce->criteria->max_value }}">
                                            <div class="progress-bar progress-bar-primary"
                                                style="width: {{ $ce->percentage }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>
                        <b>Средняя оценка:</b> {{ $evaluation->totalf }} по десятибалльной шкале
                    </p>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <div class="mt-3 mb-5">
                        @can('edit criterias')
                            <a class="btn btn-info btn-sm" href="{{ route('evaluations.edit', $evaluation->id) }}">
                                <i class="fas fa-pencil-alt"></i> Изменить
                            </a>
                        @endcan
                        @can('delete criterias')
                            <button type="submit" class="btn btn-danger btn-sm btn-delete"
                                form="destroy-{{ $evaluation->id }}">
                                <i class="fas fa-trash"></i> Удалить
                            </button>
                            <form method="POST" action="{{ route('evaluations.destroy', $evaluation->id) }}"
                                id="destroy-{{ $evaluation->id }}" hidden>
                                @csrf
                                @method('DELETE')
                            </form>
                        @endcan
                    </div>

                    <div class="text-muted">
                        <p class="text-sm">
                            Дата добавления
                            <b class="d-block">{{ $evaluation->created_at }}</b>
                        </p>
                        <p class="text-sm">
                            Пользователь
                            <b class="d-block">@include('components.user-link', ['user' => $evaluation->user])</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
