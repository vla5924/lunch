@extends('layouts.app')

@section('title', 'Изменить категорию: ' . $category->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Категории', route('categories.index')],
    [$category->name, route('categories.show', $category->id)],
], 'active' => 'Изменить категорию'])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('categories.update', $category->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" value="{{ $category->name }}" placeholder="Введите название категории" required>
            </div>
            <div class="form-group">
                <label>Критерии</label>
                <select multiple class="form-control" name="criteria_ids[]">
                    @foreach ($criterias as $criteria)
                    <option value="{{ $criteria->id }}" {{ $category->criterias->contains($criteria) ? 'selected' : '' }}>{{ $criteria->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
@endsection
