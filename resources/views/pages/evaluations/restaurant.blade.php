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
                            <td>
                                <x-model-link :model="$evaluation">
                                    <b>{{ $evaluation->totalf }}</b>
                                </x-model-link>
                            </td>
                            <td>{{ $evaluation->notes }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('evaluations.show', $evaluation->id) }}">
                                    <i class="fas fa-folder"></i>
                                    <span class="d-none d-md-inline">@lang('evaluations.show')</span>
                                </a>
                                @if(App\Helpers\EvaluationHelper::canEdit($evaluation))
                                <a class="btn btn-info btn-sm" href="{{ route('evaluations.edit', $evaluation->id) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                    <span class="d-none d-md-inline">@lang('evaluations.edit')</span>
                                </a>
                                @endif
                                @if(App\Helpers\EvaluationHelper::canDelete($evaluation))
                                <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $evaluation->id }}">
                                    <i class="fas fa-trash"></i>
                                    <span class="d-none d-md-inline">@lang('evaluations.delete')</span>
                                </button>
                                <form method="POST" action="{{ route('evaluations.destroy', $evaluation->id) }}" id="destroy-{{ $evaluation->id }}" hidden>
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
