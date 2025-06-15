@extends('layouts.app')

@section('title', __('visits.visit') . ': ' . $visit->datetime)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    [__('restaurants.restaurants'), route('restaurants.index')],
    [$visit->restaurant->name, route('restaurants.show', $visit->restaurant->id)],
    [__('visits.visits'), route('visits.restaurant', $visit->restaurant->id)],
], 'active' => $visit->datetime])
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
                    <hr>
                    <strong><i class="fas fa-users mr-1"></i> @lang('visits.group')</strong>
                    <p class="text-muted"> {{ $visit->group->name }}</p>
                    @can('edit visits')
                    <a class="btn btn-info btn-sm" href="{{ route('visits.edit', $visit->id) }}">
                        <i class="fas fa-pencil-alt"></i> @lang('visits.edit')
                    </a>
                    @endcan
                    @can('delete visits')
                    <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $visit->id }}">
                        <i class="fas fa-trash"></i> @lang('visits.delete')
                    </button>
                    <form method="POST" action="{{ route('visits.destroy', $visit->id) }}" id="destroy-{{ $visit->id }}" hidden>
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
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
            @include('components.comments', ['comments' => $comments, 'commentable' => $visit])
        </div>
    </div>
@endsection
