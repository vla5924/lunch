@extends('layouts.app')

@section('title', 'Добавить категорию')

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Категории', route('categories.index')],
]])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название категории" required>
            </div>
            <div class="form-group">
                <label>Критерии</label>
                <select multiple class="form-control" name="criteria_ids[]">
                    @foreach ($criterias as $criteria)
                    <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </div>
    </form>
</div>
@endsection
