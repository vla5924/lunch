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
                @foreach ($categories as $category)
                <tr>
                    <td>
                        <b>{{ $category->name }}</b>
                    </td>
                    <td>
                        @include('components.user-link', ['user' => $category->user]) <br />
                        <small>@lang('categories.created_at') {{ $category->created_at }}</small>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('categories.show', $category->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">@lang('categories.view')</span>
                        </a>
                        @if ($category->user->id == Auth::user()->id)
                        <a class="btn btn-info btn-sm" href="{{ route('categories.edit', $category->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">@lang('categories.edit')</span>
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $category->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('categories.delete')</span>
                        </button>
                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}" id="destroy-{{ $category->id }}" hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $categories->links('vendor.pagination.bootstrap-4') }}
@endsection
