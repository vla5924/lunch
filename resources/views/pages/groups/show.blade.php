@extends('layouts.app')

@section('title', 'Группа: ' . $group->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Группы', route('groups.index')],
], 'active' => $group->name])
@endsection

@section('content')
@include('components.form-alert')

<div class="card">
<div class="card-body">
    <div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        Связанные пользователи:

        <ul>
            @foreach ($group->users as $user)
            <li>@include('components.user-link', ['user' =>  $user])</li>
            @endforeach
        </ul>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <div class="mt-3 mb-5">
            @can('edit groups')
            <a class="btn btn-info btn-sm" href="{{ route('groups.edit', $group->id) }}">
                <i class="fas fa-pencil-alt"></i> Изменить
            </a>
            @endcan
            @can('delete groups')
            <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $group->id }}">
                <i class="fas fa-trash"></i> Удалить
            </button>
            <form method="POST" action="{{ route('groups.destroy', $group->id) }}" id="destroy-{{ $group->id }}" hidden>
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>

        <div class="text-muted">
            <p class="text-sm">
                Создана
                <b class="d-block">{{ $group->created_at }}</b>
            </p>
            <p class="text-sm">
                Пользователь
                <b class="d-block">@include('components.user-link', ['user' => $group->user])</b>
            </p>
        </div>
    </div>
    </div>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection
