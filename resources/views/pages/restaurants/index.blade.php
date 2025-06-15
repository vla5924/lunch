@extends('layouts.app')

@section('title', __('restaurants.restaurants'))

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
                    <th>@lang('restaurants.name')</th>
                    <th>@lang('restaurants.category')</th>
                    <th>@lang('restaurants.location')</th>
                    <th class="text-right">
                        @can('create restaurants')
                        <a class="btn btn-info btn-sm" href="{{ route('restaurants.create') }}">
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline">@lang('restaurants.create')</span>
                        </a>
                        @endcan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($restaurants as $restaurant)
                <tr>
                    <td>
                        <b>{{ $restaurant->name }}</b>
                    </td>
                    <td>{{ $restaurant->category->name }}</td>
                    <td>{{ $restaurant->location }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('restaurants.show', $restaurant->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">@lang('restaurants.show')</span>
                        </a>
                        @can('edit restaurants')
                        <a class="btn btn-info btn-sm" href="{{ route('restaurants.edit', $restaurant->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">@lang('restaurants.edit')</span>
                        </a>
                        @endcan
                        @can('delete restaurants')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $restaurant->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('restaurants.delete')</span>
                        </button>
                        <form method="POST" action="{{ route('restaurants.destroy', $restaurant->id) }}" id="destroy-{{ $restaurant->id }}" hidden>
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

{{ $restaurants->links('vendor.pagination.bootstrap-4') }}
@endsection
