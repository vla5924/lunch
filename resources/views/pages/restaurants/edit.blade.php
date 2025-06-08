@extends('layouts.app')

@section('title', 'Изменить ресторан: ' . $restaurant->name)

@section('breadcrumbs')
@include('components.breadcrumbs', ['prev' => [
    ['Рестораны', route('restaurants.index')],
    [$restaurant->name, route('restaurants.show', $restaurant->id)],
], 'active' => 'Изменить ресторан'])
@endsection

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('restaurants.update', $restaurant->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>Категория</label>
                <select class="form-control" style="width: 100%;" name="category_id" required>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $restaurant->category->id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" value="{{ $restaurant->name }}" placeholder="Введите название ресторана" required>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea class="form-control" name="description" placeholder="Введите описание ресторана">{{ $restaurant->description }}</textarea>
            </div>
            <div class="form-group">
                <label>Местоположение</label>
                <input type="text" class="form-control" name="location" value="{{ $restaurant->location }}" placeholder="Введите местоположение ресторана (например, город, улицу и номер дома)" required>
            </div>
            <div class="form-group">
                <label>Ссылка для виджета Яндекс Карт</label>
                <input type="text" class="form-control" name="yandex_map_widget" value="{{ $restaurant->yandex_map_widget }}">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
@endsection
