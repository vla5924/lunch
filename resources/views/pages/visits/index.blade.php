@extends('layouts.app')

@section('title', __('visits.visits'))

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
                    <th>@lang('visits.datetime')</th>
                    <th>@lang('visits.restaurant')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visits as $visit)
                <tr>
                    <td>
                        <b>{{ $visit->datetime }}</b>
                    </td>
                    <td>{{ $visit->restaurant->name }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('visits.show', $visit->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">@lang('visits.show')</span>
                        </a>
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
