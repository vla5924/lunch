@extends('layouts.app')

@section('title', __('groups.groups'))

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
                    <th>@lang('groups.name')</th>
                    <th>@lang('groups.users')</th>
                    <th class="text-right">
                        @can('create groups')
                        <a class="btn btn-info btn-sm" href="{{ route('groups.create') }}">
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline">@lang('groups.create')</span>
                        </a>
                        @endcan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                <tr>
                    <td>
                        <b>{{ $group->name }}</b>
                    </td>
                    <td>{{ $group->users->count() }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('groups.show', $group->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">@lang('groups.show')</span>
                        </a>
                        @can('edit groups')
                        <a class="btn btn-info btn-sm" href="{{ route('groups.edit', $group->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">@lang('groups.edit')</span>
                        </a>
                        @endcan
                        @can('delete groups')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $group->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('groups.delete')</span>
                        </button>
                        <form method="POST" action="{{ route('groups.destroy', $group->id) }}" id="destroy-{{ $group->id }}" hidden>
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
