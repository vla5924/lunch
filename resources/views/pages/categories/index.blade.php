@extends('layouts.app')

@section('title', 'Категории')

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
                    <th>Название</th>
                    <th class="text-right">
                        @can('create categories')
                        <a class="btn btn-info btn-sm" href="{{ route('categories.create') }}">
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline">Добавить</span>
                        </a>
                        @endcan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>
                        <b>{{ $category->name }}</b>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('categories.show', $category->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">Посмотреть</span>
                        </a>
                        @can('edit categories')
                        <a class="btn btn-info btn-sm" href="{{ route('categories.edit', $category->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">Изменить</span>
                        </a>
                        @endcan
                        @can('delete categories')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $category->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">Удалить</span>
                        </button>
                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}" id="destroy-{{ $category->id }}" hidden>
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

{{ $categories->links('vendor.pagination.bootstrap-4') }}
@endsection
