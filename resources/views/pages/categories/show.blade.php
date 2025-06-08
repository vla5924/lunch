@extends('layouts.app')

@section('title', 'Категория: ' . $category->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Категории', route('categories.index')],
], 'active' => $category->name])
@endsection

@section('content')
@include('components.form-alert')

<div class="card">
<div class="card-body">
    <div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        Связанные критерии:

        <ul>
            @foreach ($category->criterias as $criteria)
            <li>
                <a href="{{ route('criterias.show', $criteria->id) }}">
                    {{ $criteria->name }}
                </a>
            </li>
            @endforeach
        </ul>

        Связанные рестораны:

        <ul>
            <li>1</li>
            <li>2</li>
        </ul>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <div class="mt-3 mb-5">
            @can('edit categories')
            <a class="btn btn-info btn-sm" href="{{ route('categories.edit', $category->id) }}">
                <i class="fas fa-pencil-alt"></i> Изменить
            </a>
            @endcan
            @can('delete categories')
            <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $category->id }}">
                <i class="fas fa-trash"></i> Удалить
            </button>
            <form method="POST" action="{{ route('categories.destroy', $category->id) }}" id="destroy-{{ $category->id }}" hidden>
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>

        <div class="text-muted">
            <p class="text-sm">
                Добавлена
                <b class="d-block">{{ $category->created_at }}</b>
            </p>
            <p class="text-sm">
                Пользователь
                <b class="d-block">@include('components.user-link', ['user' => $category->user])</b>
            </p>
        </div>
    </div>
    </div>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection
