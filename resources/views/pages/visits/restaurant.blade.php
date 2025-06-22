@extends('layouts.app')

@section('title', __('visits.visits') . ': ' . $restaurant->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('restaurants.restaurants'), route('restaurants.index')],
    [$restaurant->name, route('restaurants.show', $restaurant->id)],
], 'active' => __('visits.visits')])
@endsection

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th>@lang('visits.datetime')</th>
                    <th class="text-right">
                        @can('create visits')
                        <a class="btn btn-primary btn-sm" href="{{ route('visits.create', $restaurant->id) }}">
                            <i class="fas fa-calendar-plus"></i> @lang('visits.create')
                        </a>
                        @endcan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visits as $visit)
                <tr>
                    <td>
                        <x-model-link :model="$visit">{{ $visit->datetime }}</x-model-link>
                    </td>
                    <td class="project-actions text-right">
                        @can('edit visits')
                        <a class="btn btn-info btn-sm" href="{{ route('visits.edit', $visit->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">@lang('visits.edit')</span>
                        </a>
                        @endcan
                        @can('delete visits')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $visit->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('visits.delete')</span>
                        </button>
                        <form method="POST" action="{{ route('visits.destroy', $visit->id) }}" id="destroy-{{ $visit->id }}" hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $visits->links('vendor.pagination.bootstrap-4') }}
@endsection
