@extends('layouts.app')

@section('title', 'Изменить группу: ' . $group->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Группы', route('groups.index')],
    [$group->name, route('groups.show', $group->id)],
], 'active' => 'Изменить группу'])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('groups.update', $group->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" value="{{ $group->name }}" placeholder="Введите название группы" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
@endsection
