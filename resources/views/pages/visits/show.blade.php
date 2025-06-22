@extends('layouts.app')

@section('title', __('visits.visit') . ': ' . $visit->datetime)

@section('breadcrumbs')
    @include('components.breadcrumbs', [
        'prev' => [
            [__('restaurants.restaurants'), route('restaurants.index')],
            [$visit->restaurant->name, route('restaurants.show', $visit->restaurant->id)],
            [__('visits.visits'), route('visits.restaurant', $visit->restaurant->id)],
        ],
        'active' => $visit->datetime,
    ])
@endsection

@section('content')
    @include('components.form-alert')

    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">@lang('visits.information')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-utensils mr-1"></i> @lang('visits.restaurant')</strong>
                    <p>
                        <a href="{{ route('restaurants.show', $visit->restaurant->id) }}">{{ $visit->restaurant->name }}</a>
                    </p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> @lang('restaurants.location')</strong>
                    <p class="text-muted">{{ $visit->restaurant->location }}</p>
                    @can('edit visits')
                        <a class="btn btn-info btn-sm" href="{{ route('visits.edit', $visit->id) }}">
                            <i class="fas fa-pencil-alt"></i> @lang('visits.edit')
                        </a>
                    @endcan
                    @can('delete visits')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $visit->id }}">
                            <i class="fas fa-trash"></i> @lang('visits.delete')
                        </button>
                        <form method="POST" action="{{ route('visits.destroy', $visit->id) }}" id="destroy-{{ $visit->id }}"
                            hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                    @endcan
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        @lang('visits.participants')
                        ({{ $visit->participants->count() }})
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="mb-4">
                        @if ($participant)
                            <button type="submit" class="btn btn-block btn-outline-success btn-delete"
                                form="cancel-participation">
                                <i class="fas fa-user-minus"></i> @lang('visits.cancel_participation')
                            </button>
                            <form method="POST" action="{{ route('visits.cancel_participation') }}"
                                id="cancel-participation" hidden>
                                @csrf
                                <input type="hidden" name="visit_id" value="{{ $visit->id }}">
                            </form>
                        @else
                            <a href="{{ route('visits.participate', $visit->id) }}" class="btn btn-block btn-success">
                                <i class="fas fa-user-plus"></i> @lang('visits.participate')
                            </a>
                        @endif
                    </div>
                    <p>
                        @foreach ($visit->participants as $participant)
                            <x-model-link :model="$participant" />
                            <br />
                        @endforeach
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            @if ($visit->notes)
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('visits.notes')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {{ $visit->notes }}
                    </div>
                    <!-- /.card -->
                </div>
            @endif
            @include('components.comments', ['comments' => $comments, 'commentable' => $visit])
        </div>
    </div>
@endsection
