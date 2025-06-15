@extends('layouts.app')

@section('title', __('evaluations.evaluations') . ': ' . $restaurant->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            [__('restaurants.restaurants'), route('restaurants.index')],
            [$restaurant->name, route('restaurants.show', $restaurant->id)],
        ],
        'active' => __('evaluations.evaluations'),
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="card">
        <div class="card-body p-0" style="display: block;">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>@lang('evaluations.author')</th>
                        <th>@lang('evaluations.average_score')</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluations as $evaluation)
                        <tr>
                            <td>
                                @include('components.user-link', ['user' => $evaluation->user])
                                <div class="test-sm text-muted">
                                    @lang('evaluations.created_at') {{ $evaluation->created_at }}
                                </div>
                            </td>
                            <td>{{ $evaluation->totalf }}</td>
                            <td>{{ $evaluation->notes }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('evaluations.show', $evaluation->id) }}">
                                    <i class="fas fa-folder"></i>
                                    <span class="d-none d-md-inline">@lang('evaluations.show')</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
