@extends('layouts.app')

@section('title', $event->name)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [[__('events.events'), route('events.index')]],
        'active' => $event->name,
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">@lang('events.information')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-calendar-day mr-1"></i> @lang('events.date')</strong>
                    <p class="text-muted">
                        {{ $event->date }}
                        @if ($event->annual)
                            <br>
                            <i class="fas fa-sync"></i> @lang('events.annual')
                        @endif
                    </p>
                    @if ($event->description)
                        <hr>
                        <strong><i class="fas fa-book mr-1"></i> @lang('events.description')</strong>
                        <p class="text-muted">{{ $event->description }}</p>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-body">
                    <div class="text-muted">
                        <p class="text-sm">
                            @lang('events.created_at')
                            <b class="d-block">{{ $event->created_at }}</b>
                        </p>
                        <p class="text-sm">
                            @lang('events.created_by')
                            <b class="d-block">@include('components.user-link', ['user' => $event->user])</b>
                        </p>
                    </div>

                    @can('edit events')
                        <a class="btn btn-info btn-sm" href="{{ route('events.edit', $event->id) }}">
                            <i class="fas fa-pencil-alt"></i> @lang('events.edit')
                        </a>
                    @endcan
                    @can('delete events')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $event->id }}">
                            <i class="fas fa-trash"></i> @lang('events.delete')
                        </button>
                        <form method="POST" action="{{ route('events.destroy', $event->id) }}" id="destroy-{{ $event->id }}"
                            hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                    @endcan
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            @include('components.comments', ['comments' => $comments, 'commentable' => $event])
        </div>
    </div>
@endsection
