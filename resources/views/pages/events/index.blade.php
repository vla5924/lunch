@extends('layouts.app')

@section('title', __('events.events'))

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
                        <th>@lang('events.name')</th>
                        <th>@lang('events.date')</th>
                        <th class="text-right">
                            @can('create events')
                                <a class="btn btn-info btn-sm" href="{{ route('events.create') }}">
                                    <i class="fas fa-plus"></i>
                                    <span class="d-none d-md-inline">@lang('events.create')</span>
                                </a>
                            @endcan
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>
                                <b>{{ $event->name }}</b>
                            </td>
                            <td>
                                {{ $event->date }}
                                @if ($event->annual)
                                    (@lang('events.annual'))
                                @endif
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('events.show', $event->id) }}">
                                    <i class="fas fa-folder"></i>
                                    <span class="d-none d-md-inline">@lang('events.show')</span>
                                </a>
                                @can('edit events')
                                    <a class="btn btn-info btn-sm" href="{{ route('events.edit', $event->id) }}">
                                        <i class="fas fa-pencil-alt"></i>
                                        <span class="d-none d-md-inline">@lang('events.edit')</span>
                                    </a>
                                @endcan
                                @can('delete events')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#"
                                        form="destroy-{{ $event->id }}">
                                        <i class="fas fa-trash"></i>
                                        <span class="d-none d-md-inline">@lang('events.delete')</span>
                                    </button>
                                    <form method="POST" action="{{ route('events.destroy', $event->id) }}"
                                        id="destroy-{{ $event->id }}" hidden>
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

    {{ $events->links('vendor.pagination.bootstrap-4') }}
@endsection
