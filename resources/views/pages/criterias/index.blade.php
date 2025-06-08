@extends('layouts.app')

@section('title', 'Критерии')

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
                    <th>Мин.</th>
                    <th>Макс.</th>
                    <th>Шаг</th>
                    <th>Вес</th>
                    <th class="text-right">
                        @can('create criterias')
                        <a class="btn btn-info btn-sm" href="{{ route('criterias.create') }}">
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline">Добавить</span>
                        </a>
                        @endcan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($criterias as $criteria)
                <tr>
                    <td>
                        @if($criteria->fa_icon)
                        <i class="fas {{ $criteria->fa_icon }}"></i>
                        @endif
                        <b>{{ $criteria->name }}</b>
                    </td>
                    <td>{{ $criteria->min_value }}</td>
                    <td>{{ $criteria->max_value }}</td>
                    <td>{{ $criteria->step }}</td>
                    <td>{{ $criteria->impact }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('criterias.show', $criteria->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">Посмотреть</span>
                        </a>
                        @can('edit criterias')
                        <a class="btn btn-info btn-sm" href="{{ route('criterias.edit', $criteria->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">Изменить</span>
                        </a>
                        @endcan
                        @can('delete criterias')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $criteria->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">Удалить</span>
                        </button>
                        <form method="POST" action="{{ route('criterias.destroy', $criteria->id) }}" id="destroy-{{ $criteria->id }}" hidden>
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
