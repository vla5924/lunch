@extends('layouts.app')

@section('title', __('criterias.criterias'))

@section('breadcrumbs')
@include('components.breadcrumbs')
@endsection

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th>@lang('criterias.name')</th>
                    <th>@lang('criterias.min')</th>
                    <th>@lang('criterias.max')</th>
                    <th>@lang('criterias.step_short')</th>
                    <th>@lang('criterias.weight_short')</th>
                    <th class="text-right">
                        @can('create criterias')
                        <a class="btn btn-primary btn-sm" href="{{ route('criterias.create') }}">
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline">@lang('criterias.create')</span>
                        </a>
                        @endcan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($criterias as $criteria)
                <tr>
                    <td>
                        @if($criteria->fa_icon)
                        <i class="fas {{ $criteria->fa_icon }} fa-fw"></i>
                        @endif
                        <x-model-link :model="$criteria" />
                    </td>
                    <td>{{ $criteria->min_value }}</td>
                    <td>{{ $criteria->max_value }}</td>
                    <td>{{ $criteria->step }}</td>
                    <td>{{ $criteria->impact }}</td>
                    <td class="project-actions text-right">
                        @can('edit criterias')
                        <a class="btn btn-info btn-sm" href="{{ route('criterias.edit', $criteria->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">@lang('criterias.edit')</span>
                        </a>
                        @endcan
                        @can('delete criterias')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $criteria->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('criterias.delete')</span>
                        </button>
                        <form method="POST" action="{{ route('criterias.destroy', $criteria->id) }}" id="destroy-{{ $criteria->id }}" hidden>
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

@endsection
