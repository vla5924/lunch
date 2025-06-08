@extends('layouts.app')

@section('title', 'Создать группу')

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Группы', route('groups.index')],
]])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('groups.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название группы" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Создать</button>
        </div>
    </form>
</div>
@endsection
