@extends('layouts.app')

@section('title', __('practice.practices'))

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th>@lang('practice.name')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($restaurants as $restaurant)
                <tr>
                    <td>
                        <b>{{ $restaurant->name }}</b>
                    </td>
                    <td>
                        @include('components.user-link', ['user' => $restaurant->user]) <br />
                        <small>@lang('restaurants.created_at') {{ $restaurant->created_at }}</small>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('restaurants.show', $restaurant->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">@lang('restaurants.view')</span>
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
