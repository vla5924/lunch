@extends('layouts.app')

@section('title', __('evaluations.evaluation') . ': ' . $evaluation->restaurant->name . ' (' . $evaluation->user->name .
    ')')

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            [__('restaurants.restaurants'), route('restaurants.index')],
            [$evaluation->restaurant->name, route('restaurants.show', $evaluation->restaurant->id)],
            [__('evaluations.evaluations'), route('evaluations.restaurant', $evaluation->restaurant->id)],
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
                        <b>@lang('evaluations.restaurant'):</b>
                        <x-model-link :model="$evaluation->restaurant" />
                    </p>
                    <p>{{ $evaluation->notes }}</p>
                    <table class="table table-striped">
                        <thead>
                            <th>@lang('evaluations.criteria')</th>
                            <th>@lang('evaluations.score')</th>
                            <th style="min-width: 100px"></th>
                        </thead>
                        <tbody>
                            @foreach ($evaluation->criterias as $ce)
                                <tr>
                                    <td>
                                        @if ($ce->criteria->fa_icon)
                                            <i class="fas {{ $ce->criteria->fa_icon }} fa-fw"></i>
                                        @endif
                                        {{ $ce->criteria->name }}
                                    </td>
                                    <td>
                                        <b>{{ $ce->value }}</b> @lang('evaluations.range_tooltip', ['min' => $ce->criteria->min_value, 'max' => $ce->criteria->max_value])
                                    </td>
                                    <td>
                                        <div class="progress progress-xs" data-toggle="tooltip" data-placement="left"
                                            title="{{ $ce->percentage }}%">
                                            <div class="progress-bar progress-bar-primary"
                                                style="width: {{ $ce->percentage }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>
                        <b>@lang('evaluations.average_score'):</b> {{ $evaluation->totalf }} @lang('evaluations.on_ten_point_scale')
                    </p>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <div class="mt-3 mb-5">
                        @if (App\Helpers\EvaluationHelper::canEdit($evaluation))
                            <a class="btn btn-info btn-sm" href="{{ route('evaluations.edit', $evaluation->id) }}">
                                <i class="fas fa-pencil-alt"></i> @lang('evaluations.edit')
                            </a>
                        @endif
                        @if (App\Helpers\EvaluationHelper::canDelete($evaluation))
                            <button type="submit" class="btn btn-danger btn-sm btn-delete"
                                form="destroy-{{ $evaluation->id }}">
                                <i class="fas fa-trash"></i> @lang('evaluations.delete')
                            </button>
                            <form method="POST" action="{{ route('evaluations.destroy', $evaluation->id) }}"
                                id="destroy-{{ $evaluation->id }}" hidden>
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>

                    <div class="text-muted">
                        <p class="text-sm">
                            @lang('evaluations.evaluated_at')
                            <b class="d-block">{{ $evaluation->created_at }}</b>
                        </p>
                        <p class="text-sm">
                            @lang('evaluations.author')
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
